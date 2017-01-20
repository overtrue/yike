import Vue from 'vue'
import Router from 'vue-router'
import beforeEach from './beforeEach'
import NotFound from '../components/404'
import Content from '../components/Content'
import { routes as home } from '../home'
import { routes as auth } from 'app/auth'
import { routes as user } from '../user'

Vue.use(Router)

const NotFoundRoute = {
  name: '404',
  path: '*',
  component: NotFound
}

const routes = [{
  path: '/dashboard',
  component: Content,
  redirect: { name: 'dashboard.home' },
  children: [...auth, ...home, ...user, NotFoundRoute]
}]

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
