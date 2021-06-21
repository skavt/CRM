const bcrypt = require('bcryptjs');
const crypto = require('crypto');
const db = require('../db');
const logger = require('../logger');

module.exports = {
  verifyToken(token) {
    return new Promise((resolve, reject) => {
      db.connection.query(`SELECT id,
                                  email,
                                  image_path,
                                  CONCAT(first_name, ' ', last_name) as name
                           FROM users
                           WHERE access_token = ?`, token, function (error, [user], fields) {
        if (error) {
          reject(error);
        } else if (user) {
          resolve(user);
        } else {
          resolve(false);
        }
      });
    })
  },
  register(userData) {
    return new Promise((resolve, reject) => {
      cryptPassword(userData.password, (err, hash) => {
        if (err) {
          logger.error(err);
          reject(err);
          return;
        }
        userData.password = hash;
        crypto.randomBytes(48, function (err, buffer) {
          if (err) {
            reject(err);
            return;
          }
          userData.access_token = buffer.toString('hex');

          db.connection.query('INSERT INTO users SET ?', userData, function (error, results, fields) {
            if (error) {
              reject(error);
              return;
            }
            userData.id = results.insertId;
            resolve(userData);
          });
        });
      });
    })
  },
  login(userData) {
    return new Promise((resolve, reject) => {
      db.connection.query(`SELECT id,
                                  email,
                                  image_path,
                                  CONCAT(first_name, ' ', last_name) as name
                           FROM users
                           WHERE email = ?`, userData.email, async function (error, [user], fields) {
        if (error) {
          reject(error);
          return;
        }

        if (user) {
          const result = await validatePassword(userData.password, user.password);
          if (result) {
            resolve({success: true, user});
          } else {
            resolve({success: false, message: "Password is not correct"})
          }
        } else {
          resolve({success: false, message: "User does not exist with this email address"})
        }
      });
    })
  },
  getUserMessagesByUserId(userId) {
    return new Promise((resolve, reject) => {
      if (!userId) {
        resolve(null);
        return;
      }
      db.connection.query(`SELECT id, user_id, unread_messages
                           FROM user_messages
                           where user_id = ?`, userId, function (err, result) {
        if (err) {
          reject(err);
          return;
        }
        resolve(result && result.length ? result[0] : null);
      });
    });
  },
  getUsers(user) {
    return new Promise((resolve, reject) => {
      db.connection.query(`SELECT u.id,
                                  u.email,
                                  u.image_path,
                                  CONCAT(u.first_name, ' ', u.last_name) as name,
                                  (SELECT message
                                   FROM messages m
                                   WHERE m.action IS NULL
                                     AND ((m.sender_id = u.id
                                       AND m.receiver_id = ?)
                                       OR (m.sender_id = ? AND m.receiver_id = u.id))
                                   ORDER BY send_date DESC                  LIMIT 1) as latestMessage,
                                   (SELECT send_date 
                                   FROM messages m
                                   WHERE m.action IS NULL
                                      AND ((m.sender_id = u.id 
                                        AND m.receiver_id = ? ) 
                                        OR (m.sender_id = ? AND m.receiver_id = u.id))
                                    ORDER BY send_date DESC LIMIT 1) as latestDate
                           FROM users u
                           WHERE u.id != ? AND u.status = 1
                           ORDER BY latestDate DESC`, [user.id, user.id, user.id, user.id, user.id, user.id], async function (error, users, fields) {
        if (error) {
          reject(error);
        } else {
          resolve(users);
        }
      });
    });
  },
  async getByIds(userIds) {
    if (!userIds.length) {
      return [];
    }
    return new Promise((resolve, reject) => {
      db.connection.query(`SELECT u.id,
                                  u.email,
                                  CONCAT(u.first_name, ' ', u.last_name) as name,
                                  u.image_path
                           FROM users u
                           WHERE id IN (?)`, [userIds], async function (error, users, fields) {
        if (error) {
          reject(error);
        } else {
          resolve(users);
        }
      });
    });
  },
  insertOrUpdateUnreadMessages(result, senderId) {
    new Promise((resolve, reject) => {
      let unreadMessages;
      if (!result.unread_messages) {
        unreadMessages = {
          'users': {}
        };
        unreadMessages.users[senderId] = 1;
      } else {
        unreadMessages = JSON.parse(result.unread_messages);
        unreadMessages.users[senderId] = 1 + (unreadMessages.users[senderId] ? unreadMessages.users[senderId] : 0);
      }
      let query = '';
      let data = [];
      if (result.user_messages_id) {
        query = `UPDATE user_messages
                 SET unread_messages = ?
                 WHERE id = ?`;
        data.push(JSON.stringify(unreadMessages));
        data.push(result.user_messages_id);
      } else {
        query = `INSERT INTO user_messages
                 SET ?`;
        data = {user_id: result.id, unread_messages: JSON.stringify(unreadMessages)};
      }

      db.connection.query(query, data, function (err, results) {
        if (err) {
          reject(err);
          return;
        }
        resolve(results);
      });
    })
  },
  saveUnreadMessage(senderId, userId, msg) {
    return new Promise((resolve, reject) => {
      let query;
      let data = [];
      if (userId) {
        query = `SELECT u.id,
                        m.id as user_messages_id,
                        m.unread_messages
                 FROM users u
                          LEFT JOIN user_messages m ON m.user_id = u.id
                 WHERE u.id = ?`;
        data.push(userId);
      }
      var me = this;
      db.connection.query(query, data, function (error, results, fields) {
        if (error) {
          reject(error);
          return;
        }
        const promises = [];
        results.forEach((result) => {
          promises.push(me.insertOrUpdateUnreadMessages(result, senderId));
        });

        Promise.all(promises)
          .then(result => {
            resolve(result)
          });
      });
    });
  },
  markMessagesRead(userId, anotherUserId) {
    this.getUserMessagesByUserId(userId).then(function (userMessages) {
      if (!userMessages || !userMessages.unread_messages) {
        return;
      }
      let unreadMessages = JSON.parse(userMessages.unread_messages);

      let needUpdate = false;
      if (anotherUserId && unreadMessages.users && unreadMessages.users[anotherUserId]) {
        delete unreadMessages.users[anotherUserId];
        needUpdate = true;
      }
      if (!needUpdate) {
        return true;
      }
      db.connection.query(`UPDATE user_messages
                           SET unread_messages = ?
                           WHERE id = ?`,
        [JSON.stringify(unreadMessages), userMessages.id], function (err, result) {
          if (err) {
            logger.error(err);
            return false;
          }
          return true;
        })
    });
  },
};

function validatePassword(password, hash) {
  return new Promise((resolve, reject) => {
    bcrypt.compare(password, hash, function (err, res) {
      if (err) {
        reject(err);
      }
      if (res) {
        resolve(true);
      } else {
        resolve(false);
      }
    });
  })
}

function cryptPassword(password, callback) {
  bcrypt.genSalt(10, function (err, salt) {
    if (err)
      return callback(err);

    bcrypt.hash(password, salt, function (err, hash) {
      return callback(err, hash);
    });
  });
}
