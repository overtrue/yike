import * as services from '../services'

export default {
  getUsers: ({ dispatch, state }) => {
    return state.users
  },
  loadUsers: ({ commit }, users) => {
    return services.getUsers()
            .then(users => {
              commit('USER//SET_USERS', users.data)
            }).catch(response => console.log(response))
  }
}
