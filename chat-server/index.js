require('dotenv').config({path: '../.env'});

const fs = require('fs');
var app = require('express')();
var http;
const logger = require('./logger');
if(process.env.SOCKET_CERT_KEY_PATH && process.env.SOCKET_CERT_CRT_PATH) {
  logger.info('starting https server');
  http = require('https').createServer({
    key: fs.readFileSync(process.env.SOCKET_CERT_KEY_PATH),
    cert: fs.readFileSync(process.env.SOCKET_CERT_CRT_PATH)
}, app);
} else {
  logger.info('starting http server');
  http = require('http').createServer(app);
}

var io = require('socket.io')(http);
var bodyParser = require('body-parser')
const bearerToken = require('express-bearer-token');
var cors = require('cors');

const routes = require('./routes');

app.use(cors());
app.options('*', cors());
app.use(bodyParser.json()); // to support JSON-encoded bodies
app.use(bodyParser.urlencoded({ // to support URL-encoded bodies
  extended: true
}));
app.use(bearerToken());

app.use('/', routes);

let SocketIo = require('./socket');
const mySocketIo = new SocketIo(io);

http.listen(3000, function () {
console.log('listening on *:3000');
});