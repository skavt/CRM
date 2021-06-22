const UserService = require('../models/user');
const MessageService = require('../models/messages');
const logger = require('./../logger');

class UserController {
  async getUsers(req, res, next) {
    const user = req.currentUser;

    try {
      let users = await UserService.getUsers(user);
      let userIds = [];

      let roomUsers = await UserService.getByIds(userIds);
      const userObj = {};
      for (let user of roomUsers) {
        userObj[user.id] = user;
      }
      users = users.map(u => {
        return {
          ...u,
          isUser: true,
          avatar: u.image_path ? process.env.API_HOST + u.image_path : '/assets/avatar.svg',
          latestMessage: {
            message: u.latestMessage,
            time: u.latestDate
          }
        }
      });
      res.send(JSON.stringify(users));
    } catch (e) {
      logger.error(e);
      res.status(500).json(e);
    }
  }

  async getMessagesByReceiver(req, res, next) {
    const user = req.currentUser;

    try {
      const userId = req.params.id;
      let messages = await MessageService.getMessages(user.id, userId);

      messages = messages.map(msg => {
        return {
          id: msg.id,
          sender: msg.sender_id === user.id ? 'me' : msg.sender_name,
          userId: userId,
          sender_id: msg.sender_id,
          action: msg.action,
          action_user_id: msg.action_user_id,
          avatar: msg.image_path ? process.env.API_HOST + msg.image_path : '/assets/avatar.svg',
          message: msg.message,
          time: msg.send_date,
        }
      });

      res.send(JSON.stringify(messages));
    } catch (e) {
      logger.error(e);
      res.status(500).json(e);
    }
  }
}

module.exports = new UserController();