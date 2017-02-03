const Show = require('./Show');
const New = require('./New');
const Edit = require('./Edit');

const ShowRoute = {
  name: 'post.show',
  path: ':username(\\w+)/:slug([\\w-]+)',
  component: Show,
  meta: { requiresAuth: false }
}

const NewRoute = {
  name: 'post.new',
  path: 'new-post',
  component: New,
  meta: { requiresAuth: true },
}

const EditRoute = {
    name: 'post.edit',
    path: ShowRoute.path + '/edit',
    component: Edit,
    meta: { requiresAuth: true },
}

export default [ShowRoute, NewRoute, EditRoute]
