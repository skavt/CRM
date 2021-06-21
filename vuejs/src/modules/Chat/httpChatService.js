import axios from 'axios';
import authService from "../../core/services/authService";

const httpChatService = axios.create({
  baseURL: process.env.VUE_APP_NODE_SERVER,
});

httpChatService.interceptors.request.use(request => {
  request.headers.Authorization = `Bearer ${authService.getToken()}`;

  return request;
});
httpChatService.interceptors.response.use(response => {

  return response;
}, (error) => {
  if (error && error.response && 401 === error.response.status) {
    authService.logout();
    return Promise.reject(error);
  } else {
    return Promise.reject(error);
  }
});

export default httpChatService;
