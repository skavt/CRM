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
      if (!channel) {
        console.log(`Channel ID ${channelId} does not exist in channel list`);

        return false;
      }
      return (channel.permissions.indexOf(permission) > -1)
    }
  },
};
