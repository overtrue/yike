/**
* Components are lazy-loaded - See "Grouping Components in the Same Chunk"
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
// export const Main = r => require.ensure([], () => r(require('../components/Main')), 'auth-bundle')
// export const Signin = r => require.ensure([], () => r(require('../components/forms/Signin')), 'auth-bundle')
// export const Signup = r => require.ensure([], () => r(require('../components/forms/Signup')), 'auth-bundle')

/* eslint-disable global-require */
export const Main = require('../components/Main');
export const Signin = require('../components/forms/Signin');
export const Signup = require('../components/forms/Signup');
