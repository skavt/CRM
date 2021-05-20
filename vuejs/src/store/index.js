import Vuex from "vuex";
import Vue from 'vue';

import auth from './modules/auth'
import invitation from './modules/invitation'

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    menuCollapsed: false,
    menuHidden: false,
    _menuItems: {},
  },
  getters: {
    menuItems: state => Object.values(state._menuItems).sort((a, b) => a.weight - b.weight),
  },
  actions: {
    addMenuItem({commit}, {name, menuItem}) {
      commit('addMenuItem', {name, menuItem});
    },
    toggleMenuCollapse({commit, state}) {
      commit('toggleMenuCollapse', !state.menuCollapsed);
    },
    toggleMenuHide({commit, state}) {
      commit('toggleMenuHide', !state.menuHidden);
    },
  },
  mutations: {
    toggleMenuCollapse: (state, collapsed) => state.menuCollapsed = collapsed,
    toggleMenuHide: (state, hide) => state.menuHidden = hide,
    addMenuItem: (state, {name, menuItem}) => {
      state._menuItems = {
        ...state._menuItems,
        [name]: menuItem
      }
    },
  },
  modules: {
    auth,
    invitation,
  }
});