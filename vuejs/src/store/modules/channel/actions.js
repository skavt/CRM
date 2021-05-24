import {
  ADD_NEW_CHANNEL,
  DELETE_CHANNEL,
  HIDE_CHANNEL_MODAL,
  HIDE_CHANNEL_USER_MODAL,
  SET_CHANNEL_DATA,
  SHOW_CHANNEL_MODAL,
  SHOW_CHANNEL_USER_MODAL,
  UPDATE_CHANNEL_DATA
} from "./mutation-types";
import httpService from "../../../core/services/httpService";

export async function getChannelData({commit}) {
  const res = await httpService.get(`channel`)
  if (res.success) {
    commit(SET_CHANNEL_DATA, res.body)
  }
  return res
}

export function showChannelModal({commit}, data) {
  commit(SHOW_CHANNEL_MODAL, data)
}

export function hideChannelModal({commit}) {
  commit(HIDE_CHANNEL_MODAL)
}

export function showChannelUserModal({commit}, data) {
  commit(SHOW_CHANNEL_USER_MODAL, data)
}

export function hideChannelUserModal({commit}) {
  commit(HIDE_CHANNEL_USER_MODAL)
}

export async function createNewChannel({commit}, data) {
  const res = await httpService.post(`channel`, data)
  if (res.success) {
    commit(ADD_NEW_CHANNEL, res.body)
  }
  return res
}

export async function updateChannel({commit}, data) {
  const res = await httpService.put(`channel/${data.id}`, data)
  if (res.success) {
    commit(UPDATE_CHANNEL_DATA, data)
  }
  return res
}

export async function deleteChannel({commit}, channelId) {
  const res = await httpService.delete(`channel/${channelId}`)
  if (res.success) {
    commit(DELETE_CHANNEL, channelId)
  }
  return res
}
