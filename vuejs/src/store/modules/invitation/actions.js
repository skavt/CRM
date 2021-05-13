import {
  ADD_NEW_INVITED_USER,
  DELETE_INVITED_USER,
  HIDE_INVITE_MODAL,
  SET_INVITATION_DATA,
  SHOW_INVITE_MODAL
} from "./mutation-types";
import httpService from "../../../core/services/httpService";

export function showInvitationModal({commit}) {
  commit(SHOW_INVITE_MODAL)
}

export function hideInvitationModal({commit}) {
  commit(HIDE_INVITE_MODAL)
}

export async function inviteUser({commit}, data) {
  const res = await httpService.post(`/invitation/invite-user?expand=createdBy,user`, data);
  if (res.success) {
    commit(ADD_NEW_INVITED_USER, res.body)
  }
  return res
}

export async function deleteInvitedUser({commit}, data) {
  commit(DELETE_INVITED_USER, data)
}

export async function getInvitedUsers({commit}) {
  const res = await httpService.get(`/invitation/invited-users?expand=createdBy,user`);
  commit(SET_INVITATION_DATA, res.body)
  return res
}