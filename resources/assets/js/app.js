import Vue from 'vue'
import { sync } from 'vuex-router-sync'
import {vuex as store, router} from "./frontend"
import Root from "./frontend/Root"
import { Input } from 'element-ui'
import Message from "home/message"
import 'element-ui/lib/theme-default/message.css'
import 'element-ui/lib/theme-default/input.css'

/**
* $http plugin based on axios
*/
import httpPlugin from './plugins/http'

/**
* eventbus plugin
*/
import eventbus from './plugins/eventbus'

/**
* jQuery and Bootstrap includes
*/
require('./bootstrap')

/**
* Make $http avaible to all components
* Send store and router to httpPlugin (injection)
*/
Vue.use(httpPlugin, { store, router })

/**
* Make $bus avaible to all components
*/
Vue.use(eventbus)
Vue.use(Input)
Vue.prototype.$message = Message
Vue.prototype.$config = require("./config")
Vue.prototype.$endpoints = require("./frontend/endpoints").default

// Effortlessly keep vue-router and vuex store in sync.
sync(store, router) // https://github.com/vuejs/vuex-router-sync/tree/next

/* eslint-disable no-new */
new Vue({
  store, // injects the Store into all components
  router, // make Router work with the application
  el: '#app',
  render: h => h(Root)
})
