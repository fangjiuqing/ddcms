import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/HelloWorld'
import Meal from '../components/meal'
import Custom from '../components/custom'
import Example from '../components/example'
import exampleDetail from '../components/exampleDetail'
import Designer from '../components/designer'
import designerDetail from '../components/designerDetail'
import Material from '../components/material'
import Work from '../components/work'
// import Material from '../components/material'
import Serve from '../components/serve'
import classroom from '../components/classroom'
import classDetail from '../components/classDetail'
import Point from '../components/point'
import joinUs from '../components/joinUs'
import Meta from 'vue-meta'
Vue.use(Router)
Vue.use(Meta)
export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/meal',
      name: 'meal',
      component: Meal
    },
    {
      path: '/custom',
      name: 'custom',
      component: Custom
    },
    {
      path: '/example',
      name: 'example',
      component: Example
    },
    {
      path: '/exampleDetail',
      name: 'example-detail',
      component: exampleDetail
    },
    {
      path: '/designer',
      name: 'designer',
      component: Designer
    },
    {
      path: '/designerDetail',
      name: 'designer-detail',
      component: designerDetail
    },
    {
      path: '/work',
      name: 'work',
      component: Work
    },
    {
      path: '/material',
      name: 'material',
      component: Material
    },
    {
      path: '/serve',
      name: 'serve',
      component: Serve
    },
    {
      path: '/class',
      name: 'classroom',
      component: classroom
    },
    {
      path: '/classDetail',
      name: 'class-detail',
      component: classDetail
    },
    {
      path: '/point',
      name: 'point',
      component: Point
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
