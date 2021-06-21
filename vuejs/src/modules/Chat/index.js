import Vue from "vue";
import VueSocketIO from "vue-socket.io";
import authService from "../../core/services/authService";

const socket = new VueSocketIO({
  debug: true,
  connection: process.env.VUE_APP_NODE_SERVER,
  vuex: {
    actionPrefix: 'SOCKET_',
    mutationPrefix: 'SOCKET_'
  },
  options: {
    path: "/socket.io",
    query: {token: authService.getToken()}
  },
});
Vue.use(socket);

export default socket;
