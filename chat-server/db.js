const mysql = require('mysql');
const logger = require('./logger');

logger.info('connecting to db');
let database, port, host;
if (process.env.DB_DSN) {
  const matches = process.env.DB_DSN.match(/host=([^;]+);port=(\d+);dbname=(.+)/);
  host = matches[1];
  port = matches[2];
  database = matches[3];
}
var db = {
  connection: null
};

function createConnection() {
  db.connection = mysql.createConnection({
    host: host,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: database,
    port: port,
    charset: 'UTF8MB4_UNICODE_CI'
  });

  db.connection.connect(function (err) {
      if (err) {
        var retryMilliseconds = 2000;
        logger.error('Error connecting to database: ' + err.stack);
        logger.info('Will retry to connect to mysql database in ' + retryMilliseconds + ' milliseconds');
        setTimeout(createConnection, retryMilliseconds);
        return;
      }
      logger.info('Connected with connection id ' + db.connection.threadId);
    }
  );

  db.connection.on('error', function (err) {
    logger.error('Error on mysql connection: ' + err.stack);
    logger.error('Error Code: ' + err.code);
    setTimeout(function () {
      createConnection();
    }, 1000);
  });

}

createConnection();

module.exports = db;
