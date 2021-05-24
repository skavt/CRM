import {
  ADD_NEW_CHANNEL,
  DELETE_CHANNEL, GET_ACTIVE_USERS,
  HIDE_CHANNEL_MODAL,
  HIDE_CHANNEL_USER_MODAL,
  SET_CHANNEL_DATA,
  SHOW_CHANNEL_MODAL,
  SHOW_CHANNEL_USER_MODAL,
  UPDATE_CHANNEL_DATA
} from './mutation-types';

export default {
  [SET_CHANNEL_DATA](state, data) {
    state.channel.data = [...data];
  },
  [SHOW_CHANNEL_MODAL](state, data) {
    state.channel.modal.show = true;
    state.channel.modal.data = {...data};
  },
  [HIDE_CHANNEL_MODAL](state) {
    state.channel.modal.show = false;
    state.channel.modal.data = {};
  },
  [SHOW_CHANNEL_USER_MODAL](state, data) {
    state.channel.userModal.show = true;
    state.channel.userModal.data = {...data};
  },
  [HIDE_CHANNEL_USER_MODAL](state) {
    state.channel.userModal.show = false;
    state.channel.userModal.data = {};
  },
  [ADD_NEW_CHANNEL](state, data) {
    state.channel.data.push(data);
  },
  [UPDATE_CHANNEL_DATA](state, data) {
    const index = state.channel.data.findIndex(c => c.id === data.id);
    state.channel.data[index] = data
    state.channel.data = [...state.channel.data]
  },
  [DELETE_CHANNEL](state, channelId) {
    state.channel.data = state.channel.data.filter(c => c.id !== channelId)
  },
  [GET_ACTIVE_USERS](state, users) {
    state.channel.userModal.users = [...users]
  },
};
