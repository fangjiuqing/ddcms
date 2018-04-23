// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import './css/reset.css'
import VueAwesomeSwiper from 'vue-awesome-swiper'
import VueLazyload from 'vue-lazyload'
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
Vue.use(VueLazyload, {
  preLoad: 1, // 预加载高度的比例
  error: 'http://cdn.uehtml.com/201402/1392662591495_1140x0.gif', // 图像的src加载失败
  loading: 'http://cdn.uehtml.com/201402/1392662591495_1140x0.gif', // src的图像加载
  attempt: 1, // 尝试计数
  listenEvents: [ 'scroll', 'mousewheel' ] // 你想要监听的事件,我个人喜欢全部监听，方便
})

Vue.use(cache)
Vue.use(sess, {cache})
Vue.use(http, {sess, cache})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  http,
  components: { App },
  template: '<App/>'
})
