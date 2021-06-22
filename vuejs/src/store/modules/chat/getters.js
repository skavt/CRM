export function messages(state) {
  return state.selectedContact ? state.selectedContact.messages : []
}

export function hasUnreadMessages(state) {
  return Object.keys(state.unreadMessages).length > 0
}

export function contacts(state) {
  for (let user of state.contacts) {
    user.hasUnreadMessage = !!state.unreadMessages[user.id]

    user.messages = user.messages || [];
    user.latestMessage = user.latestMessage || {}
    if (user.isUser) {
      user.online = false
      const contact = state.activeUsers.find(c => c.id === user.id)
      if (contact) {
        user.online = true
      }
    }
  }
  return state.contacts
    .sort((u1, u2) => {
      if (!u1.latestMessage.time && !u2.latestMessage.time) {
        if (u1.online && !u2.online) {
          return -1;
        }
        if (u2.online && !u1.online) {
          return 1;
        }
        return u1.name < u2.name ? -1 : 1
      }
      return u1.latestMessage.time < u2.latestMessage.time ? 1 : -1
    });
}
