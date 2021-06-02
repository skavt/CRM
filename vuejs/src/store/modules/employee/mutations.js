import {DELETE_USER, SET_EMPLOYEE_LIST} from './mutation-types';

export default {

  [SET_EMPLOYEE_LIST](state, data) {
    state.employee.data = [...data];
  },

  [DELETE_USER](state, data) {
    state.employee.data = state.employee.data.filter(user => user.id !== data.id);
  },
};
