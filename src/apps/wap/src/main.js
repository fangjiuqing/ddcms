// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import 'lib-flexible'
import './assets/css/reset.css'
import VueAwesomeSwiper from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
import http from './common/http'
import cache from './common/cache'
import sess from './common/sess'

// 接口配置
if (process.env.NODE_ENV !== 'development') {
  http.gateway = 'http://api.dev.ddzz360.com/index.php'
} else {
  http.gateway = 'http://ddcms.d/api/index.php'
}

Vue.config.productionTip = false
Vue.use(VueAwesomeSwiper)

Vue.use(cache)
Vue.use(sess, {cache})
Vue.use(http, {sess, cache})
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
