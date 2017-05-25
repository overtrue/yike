// https://vuex.vuejs.org/en/actions.html
export default {
  setFetching({ commit }, obj) {
    commit('MAIN_SET_FETCHING', obj)
  },

  setMessage({ commit }, obj) {
    commit('MAIN_SET_MESSAGE', obj)
  },

  resetMessages({ commit }) {
    commit('MAIN_SET_MESSAGE', { type: 'success', message: '' })
    commit('MAIN_SET_MESSAGE', { type: 'error', message: [] })
    commit('MAIN_SET_MESSAGE', { type: 'warning', message: '' })
    commit('MAIN_SET_MESSAGE', { type: 'validation', message: {} })
  },

  markAllAsRead({ commit }) {
    commit('MARK_NOTIFICATION_AS_READ')
  },

  markOneAsRead({ commit }) {
    commit('MARK_ONE_NOTIFICATION_AS_READ')
  },
}
