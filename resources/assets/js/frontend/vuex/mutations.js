// https://vuex.vuejs.org/en/mutations.html

/* eslint-disable no-param-reassign */
export default {
  ['MAIN_SET_FETCHING'](state, obj) {
    state.fetching = obj.fetching
  },
  ['MAIN_SET_MESSAGE'](state, obj) {
    state.messages[obj.type] = obj.message
  },
  ['MARK_NOTIFICATION_AS_READ'](state) {
    state.Auth.user.unread_count = 0
  },
  ['MARK_ONE_NOTIFICATION_AS_READ'](state) {
    state.Auth.user.unread_count --
  },
}
