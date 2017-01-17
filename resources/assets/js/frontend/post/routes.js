export const Show = require('./Show');
export const Form = require('./Form');

export default [{
  name: 'post.show',
  path: '/:username(\\w+)/:slug(\\w+)',
  component: Show,
  meta: { requiresAuth: false },
},{
  name: 'post.new',
  path: '/new-post',
  component: Form,
  meta: { requiresAuth: false },
}]
