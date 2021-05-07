import httpService from "../../../core/services/httpService";

export async function login({commit}, data) {
  return await httpService.post('/user/login', data)
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