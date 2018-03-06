import Vue from 'vue'
import Router from 'vue-router'

import Index from '@/components/index/index'
import Login from '@/components/index/login'

Vue.use(Router)

Vue.directive('focus', {
  update: function (el, {value}) {
    if (value) {
      el.focus()
    }
  }
})

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'index',
      component: Index
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    }
  ]
})

router.beforeEach((to, from, next) => {
  // 登录
  if (!this.a.app.$sess.login && to.name.toLowerCase() !== 'login') {
    next({
      path: '/login',
      query: { redirect: to.fullPath }
    })
  } else {
    next()
  }
})

export default router
