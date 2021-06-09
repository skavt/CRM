import * as actions from './actions';
import mutations from './mutations';
import state from './state';

export default {
  namespaced: true,
  mutations,
  actions,
  state,
  getters: {
    hasPermission: (state) => (permission, channelId) => {
      let channel = state.channel.data.find(ch => ch.id === channelId);
      return channel ? (channel.permissions.indexOf(permission) > -1) : false;
    },
  },
};
