export const Main = require('./components/Main');
export const Signin = require('./components/Signin');
export const Signup = require('./components/Signup');

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
  children,
  name: 'auth',
  path: 'auth',
  component: Main,
  redirect: { name: 'auth.signin' },
  meta: { requiresAuth: false },
}]
