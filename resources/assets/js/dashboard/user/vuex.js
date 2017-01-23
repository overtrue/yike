const state = {
  users: [],
  pagination: {},
}

const mutations = {
  ['USER//SET_DATA'](state, value) {
    state.users = value.data
    state.pagination = value.meta.pagination
  }
}

const actions = {
  userSetData({ commit }, value) {
    commit('USER//SET_DATA', value)
  }
}

export default {
  module: {
    state,
    mutations,
    actions,
  }
}
