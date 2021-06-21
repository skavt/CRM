import {CONNECTED_USERS, GET_CONTACTS, SET_UNREAD_MESSAGES, TOGGLE_WORKING_STATUS} from './mutation-types';

export default {
  [CONNECTED_USERS](state, data) {
    state.connectedUsers = data;
  },
  [GET_CONTACTS](state, data) {
    state.contacts = data;
  },
  [SET_UNREAD_MESSAGES](state, data) {
    state.unreadMessages = data;
  },
  [TOGGLE_WORKING_STATUS](state, status) {
    state.working = status;
  },
};
