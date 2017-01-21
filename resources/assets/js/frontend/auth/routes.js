const Main = require('./components/Main');
const Signin = require('./components/Signin');
const Signup = require('./components/Signup');

const children = [{
  name: 'auth.signin',
  path: 'signin',
  component: Signin,
  meta: { requiresAuth: false },
}, {
  name: 'auth.signup',
  path: 'signup',
  component: Signup,
  meta: { requiresAuth: false },
}]

export default [{
  path: 'auth',
  component: Main,
  redirect: { name: 'auth.signin' },
  children,
  meta: { requiresAuth: false },
}]
