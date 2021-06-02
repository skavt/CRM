import {DELETE_USER, HIDE_USER_EDIT_MODAL, SET_EMPLOYEE_LIST, SHOW_USER_EDIT_MODAL} from './mutation-types';
import httpService from "../../../core/services/httpService";

export async function getEmployeeList({commit}) {
  const res = await httpService.get(`/employee?expand=userChannels`);
  commit(SET_EMPLOYEE_LIST, res.body);
  return res
}

export async function deleteUser({commit}, data) {
  const res = await httpService.delete(`/employee/${data.id}`);
  commit(DELETE_USER, data);
  return res
}

export async function getChannels({commit}) {
  return await httpService.get(`/channel`);
}

export async function showUserEditModal({commit}, data) {
  commit(SHOW_USER_EDIT_MODAL, data);
}

export async function hideUserEditModal({commit}) {
  commit(HIDE_USER_EDIT_MODAL);
}