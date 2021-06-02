import {GET_CURRENT_USER} from "./mutation-types";

export default {
  [GET_CURRENT_USER](state, data) {
    state.currentUser = {...data}
  },
}
