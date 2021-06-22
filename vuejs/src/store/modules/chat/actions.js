import {
  ACTIVE_USERS,
  GET_CONTACTS,
  RESET_CHAT_DATA,
  SET_SELECTED_CONTACT,
  SET_UNREAD_MESSAGES,
  TOGGLE_WORKING_STATUS
} from "./mutation-types";
import httpChatService from "../../../modules/Chat/httpChatService";
import socket from "../../../modules/Chat";
import authService from "../../../core/services/authService";

export async function getContacts({commit}) {
  commit(TOGGLE_WORKING_STATUS, false)
  const {data, status} = await httpChatService.get('/users')
  if (status === 200) {
    commit(GET_CONTACTS, data)
    commit(TOGGLE_WORKING_STATUS, true)
  }
}

export async function selectContact({commit}, contact) {
  const {data, status} = await httpChatService.get(`/messages/${contact.id}`);
  if (status === 200) {
    commit(SET_SELECTED_CONTACT, {messages: data, contact})

    socket.io.emit('MESSAGES_READ', {
      token: authService.getToken(),
      userId: contact.id,
    })
  }
}

export function socketUserList({commit, state}, activeUsers) {
  commit(ACTIVE_USERS, activeUsers);
  commit(GET_CONTACTS, state.contacts);
}

export function setUnreadMessages({commit}, unreadMessages) {
  commit(SET_UNREAD_MESSAGES, unreadMessages)
}

export function socketSendMessage({state}, message) {
  socket.io.emit('SEND_MESSAGE', {
    token: authService.getToken(),
    message: message,
    userId: state.selectedContact.id
  })
}

export function socketStartVideoCall({state}, jitsiUrl) {
  socket.io.emit('START_CALL', {
    token: authService.getToken(),
    message: jitsiUrl,
    userId: state.selectedContact.id
  })
}

export function resetChatData({commit}) {
  commit(RESET_CHAT_DATA)
}
