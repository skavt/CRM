import router from "../../router/router";

export default {
  loggedIn() {
    return !!localStorage.getItem('AUTH_TOKEN');
  },

  logout() {
    localStorage.removeItem('AUTH_TOKEN');
    localStorage.removeItem('CURRENT_USER');
    router.push({name: 'login'});
  },

  getToken() {
    return localStorage.getItem('AUTH_TOKEN');
  },

  setToken(token) {
    localStorage.setItem('AUTH_TOKEN', token);
  },
}