import {CONNECTED_USERS, GET_CONTACTS, SET_UNREAD_MESSAGES, TOGGLE_WORKING_STATUS} from "./mutation-types";
import httpChatService from "../../../modules/Chat/httpChatService";

export async function getContacts({commit}) {
  const {data, status} = await httpChatService.getUsers()
  if (status === 200) {
    commit(GET_CONTACTS, data)
    commit(TOGGLE_WORKING_STATUS, true)
  } else {
    commit(TOGGLE_WORKING_STATUS, false)
  }
}

export function socketUserList({commit, state}, connectedUsers) {
  commit(CONNECTED_USERS, connectedUsers);
  commit(GET_CONTACTS, state.contacts);
}

export function setUnreadMessages({commit}, unreadMessages) {
  commit(SET_UNREAD_MESSAGES, unreadMessages);
}
