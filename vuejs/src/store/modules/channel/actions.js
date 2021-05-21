import {ADD_NEW_CHANNEL, HIDE_CHANNEL_MODAL, SET_CHANNEL_DATA, SHOW_CHANNEL_MODAL} from "./mutation-types";
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

export async function createNewChannel({commit}, data) {
  const res = await httpService.post(`channel`, data)
  if (res.success) {
    commit(ADD_NEW_CHANNEL, data)
  }
  return res
}
