import vuex from '../vuex'

const needAuth = auth => auth === true

const beforeEach = (to, from, next) => {
  const auth = to.meta.requiresAuth

  /**
  * Clears all global feedback message
  * that might be visible
  */
  vuex.dispatch('resetMessages')

  /**
   * Otherwise  if authentication is required login.
   */
  vuex.dispatch('checkUserToken')
    .then((token) => {
      // There is a token and it is valid
      next(); // can access the route
    })
    .catch(() => {
      if (needAuth(auth)) {
        // No token, or it is invalid
        next({ name: 'auth.singin' }) // redirect to login
      }
      next();
    });
}

export default beforeEach
