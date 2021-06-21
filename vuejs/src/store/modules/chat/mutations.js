import {
  CONNECTED_USERS,
  GET_CONTACTS,
  SET_SELECTED_CONTACT,
  SET_UNREAD_MESSAGES,
  TOGGLE_WORKING_STATUS
} from './mutation-types';

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
};
