// https://vuex.vuejs.org/en/mutations.html
import * as TYPES from './mutations-types'

/* eslint-disable no-param-reassign */
export default {
  [TYPES.SET_TOKEN] (state, value) {
    state.token = value
  },
  [TYPES.SET_USER] (state, value) {
    state.user = value
  },
  [TYPES.SET_AVATAR] (state, value) {
    state.user.avatar = value
  }
}
