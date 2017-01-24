import vuex from '../vuex'

const needAuth = route => route.meta.requiresAuth === true

const beforeEach = (to, from, next) => {
  /**
  * Clears all global feedback message
  * that might be visible
  */
  vuex.dispatch('resetMessages')

  if (to.path.indexOf('auth') > 0) {
    return next()
  }
  /**
   * Otherwise  if authentication is required login.
   */
  vuex.dispatch('checkUserToken')
    .then((token) => {
      // There is a token and it is valid
      return next(); // can access the route
    })
    .catch((err) => {
      if (needAuth(to)) {
        // No token, or it is invalid
        return next({ name: 'auth.signin' }) // redirect to login
      }
    });
}

export default beforeEach
