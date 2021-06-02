import {SET_EMPLOYEE_LIST} from './mutation-types';

export default {

  [SET_EMPLOYEE_LIST](state, data) {
    state.employee.data = [...data];
  },
};
