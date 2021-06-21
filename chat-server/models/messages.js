const db = require('../db');

module.exports = {
  getMessages(userId1, userId2) {
    return new Promise((resolve, reject) => {
      db.connection.query(`SELECT m.*,
                                  u.image_path,
                                  CONCAT(u.first_name, ' ', u.last_name) as sender
                           FROM messages m
                                    JOIN users u on m.sender_id = u.id
                           WHERE sender_id = ? AND receiver_id = ?
                              OR sender_id = ? and receiver_id = ?
                           ORDER BY send_date ASC`, [userId1, userId2, userId2, userId1], async function (error, messages, fields) {
        if (error) {
          reject(error);
        } else if (messages) {
          resolve(messages);
        } else {
          resolve(false);
        }
      });
    })
  },
  saveMessage: (sender_id, receiver_id, message, action, action_user_id, file_id) => {
    return new Promise((resolve, reject) => {
      let msg = {
        message,
        sender_id,
        receiver_id,
        action,
        file_id,
        action_user_id,
        send_date: Date.now()
      };
      db.connection.query('INSERT INTO messages SET ?', msg, function (error, results, fields) {
        if (error) {
          reject(error);
          return;
        }
        msg.id = results.insertId;
        resolve(msg);
      });
    })
  },
  getFileById: (fileId) => {
    return new Promise((resolve, reject) => {
      db.connection.query(`SELECT f.*
                           FROM chat_file f
                           WHERE f.id = ?`,
        [fileId], async function (error, files, fields) {
          if (error) {
            reject(error);
          } else if (files && files.length) {
            resolve(files[0]);
          } else {
            resolve(false);
          }
        });
    })
  }
}
