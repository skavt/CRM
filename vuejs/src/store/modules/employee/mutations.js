import {
  DELETE_USER,
  GET_CURRENT_USER,
  HIDE_USER_EDIT_MODAL,
  SET_EMPLOYEE_LIST,
  SHOW_USER_EDIT_MODAL,
  UPDATE_CURRENT_USER
} from './mutation-types';

export default {

  [SET_EMPLOYEE_LIST](state, data) {
    state.employee.data = [...data];
  },

  [DELETE_USER](state, data) {
    state.employee.data = state.employee.data.filter(user => user.id !== data.id);
  },

  [SHOW_USER_EDIT_MODAL](state, data) {
    state.employee.modal.show = true;
    state.employee.modal.data = {...data};
  },

  [HIDE_USER_EDIT_MODAL](state) {
    state.employee.modal.show = false;
    state.employee.modal.data = {};
  },

  [GET_CURRENT_USER](state, data) {
    state.currentUser = {...data.currentUser}
    state.permissions = {...data.permissions}
  },

  [UPDATE_CURRENT_USER](state, data) {
    state.currentUser = {...data}
  },
};
