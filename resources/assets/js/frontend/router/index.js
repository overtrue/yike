import Vue from 'vue'
import Router from 'vue-router'
import beforeEach from './beforeEach'
import { routes as auth } from '../auth'
import { routes as user } from '../user'
import { routes as article } from '../article'

Vue.use(Router)

// https://developer.mozilla.org/pt-BR/docs/Web/JavaScript/Reference/Operators/Spread_operator
const routes = [...auth, ...user, ...article]

const router = new Router({
  routes,
  linkActiveClass: 'active',
  mode: 'history', // do not use /#/.
})

/**
* Before a route is resolved we check for
* the token if the route is marked as
* requireAuth.
*/
router.beforeEach(beforeEach)

export default router
