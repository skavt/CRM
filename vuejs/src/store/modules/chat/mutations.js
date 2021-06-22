import {
  ACTIVE_USERS,
  GET_CONTACTS,
  RESET_CHAT_DATA,
  SET_SELECTED_CONTACT,
  SET_UNREAD_MESSAGES,
  TOGGLE_WORKING_STATUS
} from './mutation-types';

export default {
  [ACTIVE_USERS](state, data) {
    state.activeUsers = data;
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
  [SET_SELECTED_CONTACT](state, {messages, contact}) {
    state.selectedContact = contact
    state.selectedContact.hasUnreadMessage = false
    state.selectedContact.messages = messages

    delete state.contactUnreadMessageMap[contact.id]
    state.contactUnreadMessageMap = {
      ...state.contactUnreadMessageMap
    }
    if (state.unreadMessages[contact.id]) {
      delete state.unreadMessages[contact.id]
      state.unreadMessages = {...state.unreadMessages}
    }
  },
  [RESET_CHAT_DATA](state) {
    state.selectedContact = null;
    state.contacts = [];
  },
};
