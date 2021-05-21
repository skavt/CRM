import {HIDE_CHANNEL_MODAL, SET_DATA, SHOW_CHANNEL_MODAL} from './mutation-types';

export default {
  [SET_DATA](state, {data}) {
    state.data = data;
  },
  [SHOW_CHANNEL_MODAL](state, data) {
    state.channel.modal.show = true;
    state.channel.modal.data = {...data};
  },
  [HIDE_CHANNEL_MODAL](state) {
    state.channel.modal.show = false;
    state.channel.modal.data = {};
  },
};
