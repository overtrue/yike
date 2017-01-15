import { Article } from './components'

export default [{
  name: 'article',
  path: '/article',
  component: Article,
  meta: { requiresAuth: false },
}]
