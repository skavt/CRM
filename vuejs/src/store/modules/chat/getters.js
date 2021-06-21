export function messages(state) {
  return state.selectedContact ? state.selectedContact.messages : []
}
export function hasUnreadMessages(state) {
  return Object.keys(state.unreadMessages).length > 0
}
