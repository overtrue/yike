import Vue from 'vue'
import Router from 'vue-router'
import beforeEach from './beforeEach'
import Home from '../Home'
import NotFound from '../components/general/404'
import { routes as auth } from '../auth'
import { routes as user } from '../user'
import { routes as article } from '../article'

Vue.use(Router)

const HomeRoute = {
  name: 'home',
  path: '/',
  component: Home
}

const NotFoundRoute = {
  name: '404',
  path: '*',
  component: NotFound
}

const routes = [HomeRoute, ...auth, ...user, ...article, NotFoundRoute]

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
