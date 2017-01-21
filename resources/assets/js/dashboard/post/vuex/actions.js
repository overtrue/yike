import * as services from '../services'

export default {
  getPosts: ({ dispatch, state }) => {
    console.log(state)
    return state.posts
  },
  loadPosts: ({ commit }, posts) => {
    return services.getPosts()
            .then(posts => {
              commit('POST//SET_POSTS', posts.data)
            }).catch(response => console.log(response))
  }
}
