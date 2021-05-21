import httpService from "../../../core/services/httpService";

export async function setData({commit}) {
  return await httpService.get(`channel`)
}
