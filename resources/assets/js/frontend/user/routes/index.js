import { User } from './components'

export default [{
  name: 'user',
  path: '/user',
  component: User,
  meta: { requiresAuth: false },
}]
