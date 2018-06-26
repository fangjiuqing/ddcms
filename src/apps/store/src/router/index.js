import Vue from 'vue'
import Router from 'vue-router'
import Meta from 'vue-meta'
import home from '@/components/home'
import shoppingList from '@/components/shoppingList'
import Personal from '@/components/personal'

Vue.use(Router)
Vue.use(Meta)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: home
    },
    {
      path: '/shoppingList',
      name: 'shopping-list',
      component: shoppingList
    },
    {
      path: '/personal',
      name: 'personal',
      component: Personal
    }
  ],
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
})
