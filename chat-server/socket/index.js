const UserService = require('./../models/user');
const MessageService = require('./../models/messages');
const logger = require('../logger.js');

const SOCKET_TOKEN_MAP = new Map();
const USER_ID_SOCKET_MAP = new Map();
const USER_INFO = {};

class SocketIo {
  constructor(io) {
    this.io = io;
    this.connections = new Map();

    this.io.on('connection', this.onConnection.bind(this))
  }

  async onConnection(socket) {
    let token = socket.handshake.query && socket.handshake.query.token;
    if (token) {
      try {
        const user = await UserService.verifyToken(token);
        if (user) {
          this.onSuccessfulConnection(user, socket, token);
        }
      } catch (e) {
        logger.error(e);
      }
    }

    socket.on('USER_LOGGED_IN', this.onUserLogin.bind(this, socket));

    socket.on('USER_LOGOUT', this.onUserLogout.bind(this, socket));

    socket.on('SEND_MESSAGE', this.onSendMessage.bind(this, socket));

    socket.on('MESSAGES_READ', this.onMessagesRead.bind(this, socket));

    socket.on('START_CALL', this.onStartCall.bind(this, socket));

    socket.on('disconnect', this.onDisconnect.bind(this, socket));
  }

  onSuccessfulConnection(user, socket, token) {
    USER_INFO[token] = user;
    SOCKET_TOKEN_MAP.set(socket, token);
    USER_ID_SOCKET_MAP.set(user.id, socket);

    this.io.emit('USER_LIST', getUserArray(''));
    this.emitUnreadMessageCounter(user, socket);
    logger.info(`Emitting event "USER_LIST" to user: ${user.name}`);
  }

  async onUserLogin(socket, {token}) {
    try {
      const user = await UserService.verifyToken(token);
      if (user) {
        this.onSuccessfulConnection(user, socket, token);
        this.emitUnreadMessageCounter(user, socket);
      }
    } catch (e) {
      logger.error(e);
    }
  }

  async onUserLogout(socket) {
    logger.info('user logged out via logout button');
    this.onDisconnect(socket);
  }

  async onSendMessage(socket, {message, token, userId, fileId}) {
    try {
      const user = await UserService.verifyToken(token);
      if (user) {
        const msg = await MessageService.saveMessage(user.id, userId, message, null, null, fileId);
        this.sendMessage(user, msg);
        await UserService.saveUnreadMessage(user.id, userId, msg);
      }
    } catch (e) {
      logger.error(e);
    }
  }

  async sendMessage(user, msg) {
    const userId = msg.receiver_id;
    const sockets = [];

    sockets.push(USER_ID_SOCKET_MAP.get(msg.sender_id));
    sockets.push(USER_ID_SOCKET_MAP.get(userId));

    const data = {
      userId: user.id,
      receiverId: msg.receiver_id,
      sender: user.name,
      sender_id: user.id,
      avatar: user.image_path ? process.env.API_HOST_INFO + '/storage' + user.image_path : '/assets/img/users/no_avatar.png',
      message: msg.message,
      action: msg.action,
      action_user_id: msg.action_user_id,
      time: new Date().toISOString(),
      file: null
    };
    /*if (msg.file_id) {
      const file = await MessageService.getFileById(msg.file_id);
      if (file) {
        data.file = {
          id: file.id,
          name: file.name,
          size: file.size,
          mime: file.mime,
          path: process.env.API_HOST_INFO + '/storage' + file.path
        };
      }
    }*/
    sockets.forEach(socket => {
      if (socket) {
        socket.emit('ON_MESSAGE_RECEIVE', data);
      }
    });
  }

  async onStartCall(socket, {token, jitsiToken, userId}) {
    try {
      const user = await UserService.verifyToken(token);
      if (user) {
        logger.info('Call is started');
        const msg = await MessageService.saveMessage(user.id, userId, jitsiToken, 'JITSI_CALL', user.id, null);
        this.sendMessage(user, msg);
        await UserService.saveUnreadMessage(user.id, userId, msg);
      }
    } catch (e) {
      logger.error(e);
    }
  }

  async onDisconnect(socket) {
    let token = SOCKET_TOKEN_MAP.get(socket);
    logger.info('user logged out');
    if (token) {
      const user = USER_INFO[token];
      if (user) {
        USER_ID_SOCKET_MAP.delete(user.id);
      }
      delete USER_INFO[token];
      SOCKET_TOKEN_MAP.delete(socket);
    }
    this.io.emit('USER_LIST', getUserArray(''));
  }

  async emitUnreadMessageCounter(user, socket) {
    const userMessages = await UserService.getUserMessagesByUserId(user.id);
    socket.emit('UNREAD_MESSAGES', userMessages && userMessages.unread_messages ? JSON.parse(userMessages.unread_messages) : null);
  }

  async onMessagesRead(socket, {token, userId}) {
    logger.info('on message read');
    try {
      const user = await UserService.verifyToken(token);
      if (user) {
        UserService.markMessagesRead(user.id, userId);
      }
    } catch (e) {
      logger.error(e);
    }
  }
}

module.exports = SocketIo;


function getUserArray(token) {
  const USERARRAY = [];
  for (let access_token in USER_INFO) {
    if (access_token !== token) {
      USERARRAY.push(USER_INFO[access_token]);
    }
  }
  return USERARRAY;
}


