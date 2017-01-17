import { User, Edit } from './components'

export default [{
  name: 'user.show',
  path: '/:username(\\w+)',
  component: User,
  meta: { requiresAuth: false },
}, {
  name: 'user.edit',
  path: '/user/edit',
  component: Edit,
  meta: { requiresAuth: true },
}]
