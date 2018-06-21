import Vue from 'vue'
import Router from 'vue-router'
import Meta from 'vue-meta'
import home from '@/components/home'
import classroom from '@/components/classroom'
import construction from '@/components/construction'
import designList from '@/components/designList'
import entity from '@/components/entity'
import gather from '@/components/gather'
import service from '@/components/service'
import superior from '@/components/superior'
import personalTailor from '@/components/personalTailor'
import caseDetail from '@/components/caseDetail'
import designerDetail from '@/components/designerDetail'
import classDetail from '@/components/classDetail'

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
      path: '/classroom',
      name: 'classroom',
      component: classroom
    },
    {
      path: '/construction',
      name: 'construction',
      component: construction
    },
    {
      path: '/designList',
      name: 'designList',
      component: designList
    },
    {
      path: '/entity',
      name: 'entity',
      component: entity
    },
    {
      path: '/gather',
      name: 'gather',
      component: gather
    },
    {
      path: '/service',
      name: 'service',
      component: service
    },
    {
      path: '/superior',
      name: 'superior',
      component: superior
    },
    {
      path: '/personalTailor',
      name: 'personal-tailor',
      component: personalTailor
    },
    {
      path: '/caseDetail',
      name: 'caseDetail',
      component: caseDetail
    },
    {
      path: '/designerDetail',
      name: 'designerDetail',
      component: designerDetail
    },
    {
      path: '/classDetail',
      name: 'class-detail',
      component: classDetail
    }
  ],
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
})
