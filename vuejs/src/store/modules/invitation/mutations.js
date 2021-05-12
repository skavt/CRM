import {HIDE_INVITE_MODAL, SHOW_INVITE_MODAL} from "./mutation-types";

export default {
  [SHOW_INVITE_MODAL](state) {
    state.invitation.modal.show = true
  },
  [HIDE_INVITE_MODAL](state) {
    state.invitation.modal.show = false
  },
};
