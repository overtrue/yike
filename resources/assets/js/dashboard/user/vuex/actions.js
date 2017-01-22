import * as services from '../services'

export default {
  getUsers: ({ dispatch, state }) => {
    return state.users
  },
  loadUsers: ({ commit }, { number, page }) => {
    return services.getUsers(number, page)
            .then(users => {
              commit('USER//SET_USERS', users.data)
              commit('USER//SET_PAGINATION', users.meta.pagination)
            }).catch(response => console.log(response))
  }
}
