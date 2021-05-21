import {HIDE_CHANNEL_MODAL, SHOW_CHANNEL_MODAL} from "./mutation-types";
import httpService from "../../../core/services/httpService";

export async function setData({commit}) {
  return await httpService.get(`channel`)
}

export function showChannelModal({commit}, data) {
  commit(SHOW_CHANNEL_MODAL, data)
}

export function hideChannelModal({commit}) {
  commit(HIDE_CHANNEL_MODAL)
}
