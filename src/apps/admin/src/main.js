// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import 'bootstrap/dist/css/bootstrap.min.css'
import '@/assets/font-awesome/css/font-awesome.css'
import '@/assets/themes/common.css'
import '@/assets/themes/v1/style.css'

import Vue from 'vue'
import App from './App'
import router from './router'

import store from '@/store'
import http from '@/common/http'
import cache from '@/common/cache'
import sess from '@/common/sess'

import Topbar from '@/components/common/topbar'
import Leftbar from '@/components/common/leftbar'

import * as uiv from 'uiv'
import VueProgressBar from 'vue-progressbar'

Vue.config.productionTip = false

// 接口配置
if (process.env.NODE_ENV !== 'development') {
  http.gateway = 'http://api.ddzz360.com/index.php'
} else {
  http.gateway = 'http://ddcms.d/api/index.php'
}

Vue.use(cache)
Vue.use(sess, {cache})
Vue.use(http, {sess, cache})
Vue.use(uiv)
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})

/* import commonSidebar from './components/common/sidebar' */

Vue.component('Topbar', Topbar)
Vue.component('Leftbar', Leftbar)
/* Vue.component('common-sidebar', commonSidebar) */
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  http,
  components: { App },
  template: '<App/>'
})
