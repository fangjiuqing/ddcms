import Vue from 'vue'
import Router from 'vue-router'
import Meta from 'vue-meta'
import Header from '@/components/HelloWorld'
import superior from '@/components/superior'
import scheme from '@/components/scheme'
import cash from '@/components/cash'
import design from '@/components/design'
import construction from '@/components/construction'
import service from '@/components/service'
// import entity from '@/components/entity'
import experience from '@/components/experience'
import gather from '@/components/gather'
import caseDetail from '@/components/caseDetail'
import designDetail from '@/components/designerdetail'
import classroom from '@/components/classroom'
import classDetail from '@/components/classDetail'
import joinUs from '@/components/joinUs'

Vue.use(Router)
Vue.use(Meta)

export default new Router({
  // mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Header',
      component: Header
    },
    {
      path: '/scheme',
      name: 'scheme',
      component: scheme
    },
    {
      path: '/case',
      name: 'case',
      component: cash
    },
    {
      path: '/gather',
      name: 'gather',
      component: gather
    },
    {
      path: '/design',
      name: 'design',
      component: design
    },
    {
      path: '/construction',
      name: 'construction',
      component: construction
    },
    {
      path: '/superior',
      name: 'superior',
      component: superior
    },
    {
      path: '/service',
      name: 'service',
      component: service
    },
    {
      path: '/entity',
      name: 'entity',
      component: experience
    },
    {
      path: '/caseDetail',
      name: 'caseDetail',
      component: caseDetail
    },
    {
      path: '/designerDetail',
      name: 'designerDetail',
      component: designDetail
    },
    {
      path: '/classroom',
      name: 'classroom',
      component: classroom
    },
    {
      path: '/classDetail/:id',
      name: 'class-detail',
      component: classDetail
    },
    {
      path: '/joinUs',
      name: 'join-us',
      component: joinUs
    }
  ],
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
})
