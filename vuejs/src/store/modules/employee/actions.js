import {DELETE_USER, HIDE_USER_EDIT_MODAL, SET_EMPLOYEE_LIST, SHOW_USER_EDIT_MODAL} from './mutation-types';
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

export async function getChannels({commit}, userId) {
  return await httpService.get(`/employee/get-channels?userId=${userId}`);
}

export async function showUserEditModal({commit}, data) {
  commit(SHOW_USER_EDIT_MODAL, data);
}

export async function hideUserEditModal({commit}) {
  commit(HIDE_USER_EDIT_MODAL);
}