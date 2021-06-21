const UserService = require('../models/user');

module.exports = async function checkUserAuthentication(req, res, next) {
  if (!req.headers.authorization) {
    res.status(401).send();
    return null;
  }

  try {
    const token = req.headers.authorization.split(' ')[1];
    const user = await UserService.verifyToken(token);
    if (!user) {
      res.status(401).send();
    } else {
      req.currentUser = user;
      next();
    }
  } catch (e) {
    throw e;
  }
};