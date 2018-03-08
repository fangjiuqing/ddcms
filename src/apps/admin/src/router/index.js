import Vue from 'vue'
import Router from 'vue-router'
import Meta from 'vue-meta'

import Index from '@/components/index/index'
import Login from '@/components/index/login'

import Profile from '@/components/user/profile'

Vue.use(Router)
Vue.use(Meta)

Vue.directive('focus', {
  update: function (el, {value}) {
    if (value) {
      el.focus()
    }
  }
})

const router = new Router({
  mode: 'history',
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
    },
    {
      path: '/user/profile',
      name: 'Profile',
      component: Profile
    }
  ]
})

router.beforeEach((to, from, next) => {
  next()
})

export default router
