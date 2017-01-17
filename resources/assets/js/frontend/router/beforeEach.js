import vuex from '../vuex'

const needAuth = route => route.meta.requiresAuth === true

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
    .then((token) => {
      // There is a token and it is valid
      return next(); // can access the route
    })
    .catch((err, error) => {
      if (needAuth(to)) {
        console.log(err, error)
        // No token, or it is invalid
        return next({ name: 'auth.signin' }) // redirect to login
      }
      next();
    });
}

export default beforeEach
