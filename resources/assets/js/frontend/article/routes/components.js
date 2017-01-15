/**
* Components are lazy-loaded - See "Grouping Components in the Same Chunk"
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
// export const User = r => require.ensure([], () => r(require('../User')), 'auth-bundle')

/* eslint-disable global-require */
export const Article = require('../Article');
