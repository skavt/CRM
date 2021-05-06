import httpService from "../../../core/services/httpService";

export async function login({commit}, data) {
  return await httpService.post('/user/login', data)
}
export async function resetPassword({commit}, data) {
  return await httpService.post('/user/send-password-reset-link', data)
}