import Vue from 'vue'
import Router from 'vue-router'
import beforeEach from './beforeEach'
import NotFound from '../components/general/404'
import { routes as home } from '../home'
import { routes as auth } from '../auth'
import { routes as user } from '../user'
import { routes as post } from '../post'

Vue.use(Router)

const NotFoundRoute = {
  name: '404',
  path: '*',
  component: NotFound
}

const routes = [...auth, ...home, ...user, ...post, NotFoundRoute]

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
