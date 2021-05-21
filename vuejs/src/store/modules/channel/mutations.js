import {ADD_NEW_CHANNEL, HIDE_CHANNEL_MODAL, SET_CHANNEL_DATA, SHOW_CHANNEL_MODAL} from './mutation-types';

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
  [ADD_NEW_CHANNEL](state, data) {
    state.channel.data.push(data);
  },
};
