import httpService from "../../../core/services/httpService";
import authService from "../../../core/services/authService";

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

export async function updateUserStatus({commit}, data) {
  return await httpService.put(`/employee/${data.user.id}`, {status: data.activeStatus ? 1 : 2})
}