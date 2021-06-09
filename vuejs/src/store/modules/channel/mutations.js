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
} from './mutation-types';

export default {
  [SET_CHANNEL_DATA](state, data) {
    state.channel.data = [...data];
  },
  [SHOW_CHANNEL_MODAL](state, data) {
    state.channel.modal.show = true;
    state.channel.modal.data = {...data};
  },
  [HIDE_CHANNEL_MODAL](state) {
    state.channel.modal.show = false;
    state.channel.modal.data = {};
  },
  [SHOW_CHANNEL_USER_MODAL](state, data) {
    state.channel.userModal.show = true;
    state.channel.userModal.data = {...data};
  },
  [HIDE_CHANNEL_USER_MODAL](state) {
    state.channel.userModal.show = false;
    state.channel.userModal.data = {};
  },
  [ADD_NEW_CHANNEL](state, data) {
    state.channel.data.push(data);
  },
  [UPDATE_CHANNEL_DATA](state, data) {
    const index = state.channel.data.findIndex(c => c.id === data.id);
    state.channel.data[index] = data
    state.channel.data = [...state.channel.data]
  },
  [DELETE_CHANNEL](state, channelId) {
    state.channel.data = state.channel.data.filter(c => c.id !== channelId)
  },
  [GET_ACTIVE_USERS](state, users) {
    state.channel.userModal.users = [...users]
  },
  [SHOW_POST_MODAL](state, data) {
    state.post.modal.show = true
    state.post.modal.data = {...data}
  },
  [HIDE_POST_MODAL](state) {
    state.post.modal.show = false
    state.post.modal.data = {}
  },
  [SET_POST_DATA](state, data) {
    state.post.data = [...data];
  },
  [ADD_NEW_POST](state, data) {
    state.post.data.unshift(data);
  },
  [UPDATE_POST_DATA](state, data) {
    const index = state.post.data.findIndex(c => c.id === data.id);
    state.post.data[index] = data
    state.post.data = [...state.post.data]
  },
  [DELETE_POST](state, postId) {
    state.post.data = state.post.data.filter(c => c.id !== postId)
  },
  [LIKE_POST](state, data) {
    const index = state.post.data.findIndex(p => p.id === data.post_id);
    state.post.data[index].userLikes.unshift(data)
    state.post.data[index].myLikes.unshift(data)
    state.post.data = [...state.post.data]
  },
  [UNLIKE_POST](state, data) {
    const index = state.post.data.findIndex(p => p.id === data.post_id)
    state.post.data[index].userLikes = state.post.data[index].userLikes.filter(ul => ul.id !== data.id)
    state.post.data[index].myLikes = []
    state.post.data = [...state.post.data]
  },
  [ADD_POST_COMMENT](state, data) {
    state.post.data.filter(p => p.id === data.post_id)
      .forEach(p => p.postComments.unshift(data))
  },
  [DELETE_POST_COMMENT](state, data) {
    state.post.data.forEach(p => p.postComments = p.postComments.filter(c => c.id !== data.id))
  },
  [ADD_POST_CHILD_COMMENT](state, data) {
    state.post.data.filter(p => p.id === data.parent.post_id)
      .forEach(p => p.postComments.filter(pc => pc.id === data.parent_id)
        .forEach(pc => pc.childrenComments.unshift(data)))
  },
  [DELETE_POST_CHILD_COMMENT](state, data) {
    state.post.data.forEach(p => p.postComments
      .forEach(p => p.childrenComments = p.childrenComments
        .filter(c => c.id !== data.id)))
  },
};
