import {DELETE_USER, SET_EMPLOYEE_LIST} from './mutation-types';
import httpService from "../../../core/services/httpService";

export async function getEmployeeList({commit}) {
  const res = await httpService.get(`/employee`);
  commit(SET_EMPLOYEE_LIST, res.body);
  return res
}

export async function deleteUser({commit}, data) {
  const res = await httpService.delete(`/employee/${data.id}`);
  commit(DELETE_USER, data);
  return res
}