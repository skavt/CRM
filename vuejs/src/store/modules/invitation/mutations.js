import {ADD_NEW_INVITED_USER, HIDE_INVITE_MODAL, SET_INVITATION_DATA, SHOW_INVITE_MODAL} from "./mutation-types";

export default {
  [SHOW_INVITE_MODAL](state) {
    state.invitation.modal.show = true
  },
  [HIDE_INVITE_MODAL](state) {
    state.invitation.modal.show = false
  },
  [SET_INVITATION_DATA](state, data) {
    state.invitation.data = [...data]
  },
  [ADD_NEW_INVITED_USER](state, data) {
    state.invitation.data.push(data)
  },
};
