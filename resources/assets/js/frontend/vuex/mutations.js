// https://vuex.vuejs.org/en/mutations.html

/* eslint-disable no-param-reassign */
export default {
  MAIN_SET_MESSAGE(state, obj) {
    state.fetching = obj.fetching
  },
  MAIN_SET_FETCHING(state, obj) {
    state.messages[obj.type] = obj.message
  },
}
