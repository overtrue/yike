export const Show = require('./Show');
export const Profile = require('./Profile');
export const Notification = require('./Notification');

export default [{
  name: 'user.profile',
  path: 'settings/profile',
  component: Profile,
  meta: { requiresAuth: true },
},{
  name: 'user.notification',
  path: 'notification',
  component: Notification,
  meta: { requiresAuth: true },
},{
  name: 'user.show',
  path: ':username(\\w+)',
  component: Show,
  meta: { requiresAuth: false },
}]
