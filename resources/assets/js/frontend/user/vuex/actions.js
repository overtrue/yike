import * as services from "../services"

export default {
  getInterviewee: ({ dispatch, state }) => {
    return state.user
  },
  loadInterviewee: function({ commit }, payload) {
    return services.getUserByUsername(payload.username || payload)
            .then(user => {
              commit('USER//SET_USER', user.data)
            }).catch(function(response){
              console.log(response)
            });
  }
}
