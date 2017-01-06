import Vue from 'vue'
import Vuex from 'vuex'
import state from './state'
import mutations from './mutations'
import actions from './actions'
import vuex from './vuex'
import * as getters from './getters'

Vue.use(Vuex)

export default new Vuex.Store({
  state,
  mutations,
  actions,
  ...vuex.modules,
  ...vuex.plugins,
  getters,
  strict: process.env.NODE_ENV !== 'production',
})