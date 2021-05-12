import Vuex from "vuex";
import Vue from 'vue';

import auth from './modules/auth'
import invitation from './modules/invitation'

Vue.use(Vuex);

export default new Vuex.Store({
  state: {},
  getters: {},
  actions: {},
  mutations: {},
  modules: {
    auth,
    invitation,
  }
});