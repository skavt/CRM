import {
  ACTIVE_USERS,
  GET_CONTACTS,
  SET_SELECTED_CONTACT,
  SET_UNREAD_MESSAGES,
  TOGGLE_WORKING_STATUS
} from "./mutation-types";
import httpChatService from "../../../modules/Chat/httpChatService";
import socket from "../../../modules/Chat";
import authService from "../../../core/services/authService";

export async function getContacts({commit}) {
  const {data, status} = await httpChatService.get('/users')
  if (status === 200) {
    commit(GET_CONTACTS, data)
    commit(TOGGLE_WORKING_STATUS, true)
  } else {
    commit(TOGGLE_WORKING_STATUS, false)
  }
}

export async function selectContact({commit}, contact) {
  const {data, status} = await httpChatService.get(`/messages/${contact.id}`);
  if (status === 200) {
    commit(SET_SELECTED_CONTACT, {messages: data, contact})
    commit(TOGGLE_WORKING_STATUS, true)

    socket.io.emit('MESSAGES_READ', {
      token: authService.getToken(),
      userId: contact.id,
    })
  } else {
    commit(TOGGLE_WORKING_STATUS, false)
  }
}

export function socketUserList({commit, state}, activeUsers) {
  commit(ACTIVE_USERS, activeUsers);
  commit(GET_CONTACTS, state.contacts);
}

export function setUnreadMessages({commit}, unreadMessages) {
  commit(SET_UNREAD_MESSAGES, unreadMessages);
}
