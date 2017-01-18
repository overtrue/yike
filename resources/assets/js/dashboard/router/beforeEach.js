import vuex from '../vuex'

const beforeEach = (to, from, next) => {
  /**
  * Clears all global feedback message
  * that might be visible
  */
  vuex.dispatch('resetMessages')

  /**
   * Otherwise  if authentication is required login.
   */
  vuex.dispatch('checkUserToken')
    .then(() => {
      if (!vuex.getters.currentUser.is_admin) {
        return window.location.href = '/'
      }
      return next()
    })
    .catch((err) => {
      // No token, or it is invalid
      return window.location.href = '/'
    });
}

export default beforeEach
