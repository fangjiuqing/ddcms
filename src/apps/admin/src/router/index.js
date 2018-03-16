import Vue from 'vue'
import Router from 'vue-router'
import Meta from 'vue-meta'

import Index from '@/components/index/index'
import Login from '@/components/index/login'

import Profile from '@/components/user/profile'
import Category from '@/components/common/category'
import Brand from '@/components/material/brand'
import Supplier from '@/components/material/supplier'

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
    },
    {
      path: '/news/category',
      name: 'NCategory',
      component: Category,
      props: {
        code: 'news',
        label: '资讯'
      }
    },
    {
      path: '/material/category',
      name: 'MCategory',
      component: Category,
      props: {
        code: 'material',
        label: '材料'
      }
    },
    {
      path: '/material/brand',
      name: 'Brand',
      component: Brand
    },
    {
      path: '/material/supplier',
      name: 'Supplier',
      component: Supplier
    },
    {
      path: '/case/category',
      name: 'CCategory',
      component: Category,
      props: {
        code: 'case',
        label: '案例'
      }
    }
  ]
})

router.beforeEach((to, from, next) => {
  next()
})

export default router
