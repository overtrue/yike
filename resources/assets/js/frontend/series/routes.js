import List from './List'
import Show from './Show'

export default [{
  name: 'series.list',
  path: 'series',
  component: List,
  meta: { requiresAuth: false }
}, {
  name: 'series.show',
  path: 'series/:slug([\\w-]+)',
  component: Show,
  meta: { requiresAuth: false }
}]
