import * as services from "../services"

export default {
  getInterviewee: ({ dispatch, state }) => {
    return state.user
  },
  loadInterviewee: ({ commit }, user) => {
    return services.getUserByUsername(user.username || user)
            .then(user => {
              commit('USER//SET_USER', user.data)
            }).catch(response => console.log(response))
  },
  getIntervieweePosts: ({dispatch, state}) => {
    return state.posts
  },
  loadIntervieweePosts: ({ commit, state }, posts) => {
    return services.getUserPosts(state.user)
          .then(posts => {
            commit('USER//SET_USER_POSTS', posts.data)
          }).catch(response => console.log(response))
  }
}
