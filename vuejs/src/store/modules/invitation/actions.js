import {HIDE_INVITE_MODAL, SET_INVITATION_DATA, SHOW_INVITE_MODAL} from "./mutation-types";
import httpService from "../../../core/services/httpService";

export function showInvitationModal({commit}) {
  commit(SHOW_INVITE_MODAL)
}

export function hideInvitationModal({commit}) {
  commit(HIDE_INVITE_MODAL)
}

export async function inviteUser({commit}, data) {
  const res = await httpService.post(`/invitation/invite-user`, data);
  return res
}

export async function getInvitedUsers({commit}) {
  const res = await httpService.get(`/invitation/invited-users?expand=createdBy,user`);
  commit(SET_INVITATION_DATA, res.body)
  return res
}