import {HIDE_INVITE_MODAL, SHOW_INVITE_MODAL} from "./mutation-types";

export function showInvitationModal({commit}) {
  commit(SHOW_INVITE_MODAL)
}

export function hideInvitationModal({commit}) {
  commit(HIDE_INVITE_MODAL)
}