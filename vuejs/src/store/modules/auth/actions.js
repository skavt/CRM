import httpService from "../../../core/services/httpService";
import authService from "../../../core/services/authService";
import {GET_CURRENT_USER} from "./mutation-types";

export async function login({commit, dispatch}, data) {
  const response = await httpService.post('/user/login', data)

  if (response.success) {
    authService.setToken(response.body.access_token)
  }

  return response
}

export async function register({commit}, data) {
  return await httpService.post('/user/register', data)
}

export async function resetPasswordRequest({commit}, data) {
  return await httpService.post('/user/send-password-reset-link', data)
}

export async function checkToken({commit}, token) {
  return await httpService.get(`/user/check-token?token=${token}`)
}

export async function resetPassword({commit}, data) {
  return await httpService.post('/user/reset-password', data)
}

export async function updateUserStatus({commit}, {id, status}) {
  return await httpService.put(`/employee/${id}`, {status: status ? 1 : 2})
}