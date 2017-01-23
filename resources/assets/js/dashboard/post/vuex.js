const state = {
  posts: [],
  pagination: {},
}

const mutations = {
  ['POST//SET_DATA'] (state, value) {
    state.posts = value.data
    state.pagination = value.meta.pagination
  },
}

const actions = {
  postSetData({ commit }, value) {
    commit('POST//SET_DATA', value)
  }
}

export default {
  module: {
    state,
    mutations,
    actions,
  }
}
