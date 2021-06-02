import {SET_EMPLOYEE_LIST} from './mutation-types';
import httpService from "../../../core/services/httpService";

export async function getEmployeeList({commit}) {
  const res = await httpService.get(`/employee`);
  commit(SET_EMPLOYEE_LIST, res.body);
  return res
}