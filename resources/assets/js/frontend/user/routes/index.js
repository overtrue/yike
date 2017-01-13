import { User, Edit } from './components'

export default [{
  name: 'user',
  path: '/user',
  component: User,
  meta: { requiresAuth: false },
}, {
  name: 'user.edit',
  path: '/user/edit',
  component: Edit,
  meta: { requiresAuth: false },
}]
