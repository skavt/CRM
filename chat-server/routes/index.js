const routes = require('express').Router();
const userController = require('../controllers/userController');
const authMiddleware = require('../middlewares/authMiddleware');

routes.get('/users', authMiddleware, userController.getUsers);

routes.get('/messages/:id/:type', authMiddleware, userController.getMessagesByReceiver);

module.exports = routes;