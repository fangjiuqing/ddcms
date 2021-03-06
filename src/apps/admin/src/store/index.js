import Vue from 'vue'
import Vuex from 'vuex'
import mutations from './mutations'
import actions from './actions'

Vue.use(Vuex)

const state = {
  admin_level: 'admin1',
  left_active_key: '',
  is_login: true,
  loader_left: 0
}

export default new Vuex.Store({
  state,
  actions,
  mutations
})
