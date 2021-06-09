import * as actions from './actions';
import mutations from './mutations';
import state from './state';

export default {
  namespaced: true,
  mutations,
  actions,
  state,
  getters: {
    hasPermission: (state) => (permission) => {
      return !!state.permissions[permission]
    },
  },
};
