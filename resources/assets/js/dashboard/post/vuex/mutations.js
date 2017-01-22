export default {
  ['POST//SET_POSTS'] (state, value) {
    return state.posts = value
  },
  ['POST//SET_PAGINATION'] (state, value) {
    return state.pagination = value
  }
}
