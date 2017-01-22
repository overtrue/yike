import * as services from '../services'

export default {
  getPosts: ({ dispatch, state }) => {
    return state.posts
  },
  loadPosts: ({ commit }, { number, page }) => {
    return services.getPosts(number, page)
            .then(posts => {
              commit('POST//SET_POSTS', posts.data)
              commit('POST//SET_PAGINATION', posts.meta.pagination)
            }).catch(response => console.log(response))
  }
}
