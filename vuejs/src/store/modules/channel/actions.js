import {
  ADD_NEW_CHANNEL,
  ADD_NEW_POST,
  ADD_POST_CHILD_COMMENT,
  ADD_POST_COMMENT,
  DELETE_CHANNEL,
  DELETE_POST,
  DELETE_POST_CHILD_COMMENT,
  DELETE_POST_COMMENT,
  GET_ACTIVE_USERS,
  HIDE_CHANNEL_MODAL,
  HIDE_CHANNEL_USER_MODAL,
  HIDE_POST_MODAL,
  LIKE_POST,
  SET_CHANNEL_DATA,
  SET_POST_DATA,
  SHOW_CHANNEL_MODAL,
  SHOW_CHANNEL_USER_MODAL,
  SHOW_POST_MODAL,
  UNLIKE_POST,
  UPDATE_CHANNEL_DATA,
  UPDATE_POST_DATA
} from "./mutation-types";
import httpService from "../../../core/services/httpService";

const postExpand = 'createdBy,myLikes,userLikes,postComments,userLikes.createdBy,postComments.createdBy,' +
  'postComments.childrenComments,postComments.childrenComments.createdBy'

export async function getChannelData({commit}) {
  const res = await httpService.get(`channel?expand=userChannels`)
  if (res.success) {
    commit(SET_CHANNEL_DATA, res.body)
  }
  return res
}

export function showChannelModal({commit}, data) {
  commit(SHOW_CHANNEL_MODAL, data)
}

export function hideChannelModal({commit}) {
  commit(HIDE_CHANNEL_MODAL)
}

export function showChannelUserModal({commit}, data) {
  commit(SHOW_CHANNEL_USER_MODAL, data)
}

export function hideChannelUserModal({commit}) {
  commit(HIDE_CHANNEL_USER_MODAL)
}

export async function createNewChannel({commit}, data) {
  const res = await httpService.post(`channel?expand=userChannels`, data)
  if (res.success) {
    commit(ADD_NEW_CHANNEL, res.body)
  }
  return res
}

export async function updateChannel({commit}, data) {
  const res = await httpService.put(`channel/${data.id}?expand=userChannels`, data)
  if (res.success) {
    commit(UPDATE_CHANNEL_DATA, data)
  }
  return res
}

export async function deleteChannel({commit}, channelId) {
  const res = await httpService.delete(`channel/${channelId}`)
  if (res.success) {
    commit(DELETE_CHANNEL, channelId)
  }
  return res
}

export async function getActiveUsers({commit}, channelId) {
  const res = await httpService.get(`employee/active-users?channelId=${channelId}`)
  if (res.success) {
    commit(GET_ACTIVE_USERS, res.body)
  }
  return res
}

export async function addNewUsersInChannel({commit}, data) {
  return await httpService.post(`channel/add-new-users`, data)
}

export function showPostModal({commit}, data) {
  commit(SHOW_POST_MODAL, data)
}

export function hidePostModal({commit}) {
  commit(HIDE_POST_MODAL)
}

export async function getPostData({commit}, channelId) {
  let params = {
    channel_id: channelId,
  }
  const res = await httpService.get(`post?expand=${postExpand}`, {params})
  if (res.success) {
    commit(SET_POST_DATA, res.body)
  }
  return res
}

export async function createNewPost({commit}, data) {
  const res = await httpService.post(`post?expand=${postExpand}`, data)
  if (res.success) {
    commit(ADD_NEW_POST, res.body)
  }
  return res
}

export async function updatePost({commit}, data) {
  const res = await httpService.put(`post/${data.id}?expand=${postExpand}`, data)
  if (res.success) {
    commit(UPDATE_POST_DATA, data)
  }
  return res
}

export async function deletePost({commit}, postId) {
  const res = await httpService.delete(`post/${postId}`)
  if (res.success) {
    commit(DELETE_POST, postId)
  }
  return res
}

export async function like({commit}, data) {
  const {success, body} = await httpService.post(`user-like?expand=createdBy`, data)
  if (success) {
    commit(LIKE_POST, body)
  }
}

export async function unlike({commit}, data) {
  const {success} = await httpService.delete(`user-like/${data.id}`, data)
  if (success) {
    commit(UNLIKE_POST, data)
  }
}

export async function addComment({commit}, data) {
  const res = await httpService.post(`user-comment?expand=createdBy,childrenComments,parent`, data);
  if (res.success) {
    if (data.parent_id) {
      commit(ADD_POST_CHILD_COMMENT, res.body)
    }
    commit(ADD_POST_COMMENT, res.body)
  }
  return res;
}

export async function deleteComment({commit}, data) {
  const res = await httpService.delete(`user-comment/${data.id}`);
  if (res.success) {
    if (data.parent_id) {
      commit(DELETE_POST_CHILD_COMMENT, data)
    }
    commit(DELETE_POST_COMMENT, data)
  }
  return res;
}
