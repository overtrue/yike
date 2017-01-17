import * as services from "./services"
import {isEmpty} from "lodash"

const state = {
  user: {}
}

const mutations = {
  ['USER//SET_USER'] (state, value) {
    state.user = value
  }
}

const actions = {
  getUser: ({ dispatch, state }) => {
    return state.user
  },
  loadUser: function({ commit }, payload) {
    return services.getUserByUsername(payload.username || payload)
            .then(user => {
              commit('USER//SET_USER', user.data)
            }).catch(function(response){
              console.log(response)
            });
  }
}

const getters = {
  getInterviewee: ({user}) => user
}

export default {
    module: {
        state,
        mutations,
        actions,
        getters
    }
}
