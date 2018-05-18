import Vue from 'vue'
import Router from 'vue-router'
import Meta from 'vue-meta'

import Index from '@/components/index/index'
import Login from '@/components/index/login'

import Profile from '@/components/user/profile'
import Category from '@/components/common/category'
import Brand from '@/components/material/brand'
import Supplier from '@/components/material/supplier'

import Article from '@/components/article/index'
import ArticleAdd from '@/components/article/add'

import Case from '@/components/case/index'
import CaseAdd from '@/components/case/add'

import Material from '@/components/material/index'
import MaterialAdd from '@/components/material/add'

import Customer from '@/components/customer/index'
import CustomerAdd from '@/components/customer/add'
import CustomerOrder from '@/components/customer/order'

import Logs from '@/components/system/logs'
import Admin from '@/components/system/admin/index'
import Group from '@/components/system/admin/group'
import Flush from '@/components/system/flush'
import Community from '@/components/community/index'
import CommunityAdd from '@/components/community/add'

import Designer from '@/components/designer/index'
import DesignerAdd from '@/components/designer/add'

Vue.use(Router)
Vue.use(Meta)

var dateFormat = require('dateformat')
Vue.filter('time', function (value, format) {
  var d = new Date()
  d.setTime(value * 1000)
  return dateFormat(d, format)
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
      path: '/customer',
      name: 'Customer',
      component: Customer
    },
    {
      path: '/customer-order',
      name: 'CustomerOrder',
      component: CustomerOrder
    },
    {
      path: '/customer/add',
      name: 'CustomerAdd',
      component: CustomerAdd
    },
    {
      path: '/community',
      name: 'Community',
      component: Community
    },
    {
      path: '/community/add',
      name: 'CommunityAdd',
      component: CommunityAdd
    },
    {
      path: '/article',
      name: 'Article',
      component: Article
    },
    {
      path: '/article/add',
      name: 'ArticleAdd',
      component: ArticleAdd
    },
    {
      path: '/material',
      name: 'Material',
      component: Material
    },
    {
      path: '/material/add',
      name: 'MaterialAdd',
      component: MaterialAdd
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
      path: '/system/admin',
      name: 'Admin',
      component: Admin
    },
    {
      path: '/system/admin/group',
      name: 'Group',
      component: Group
    },
    {
      path: '/system/logs',
      name: 'Logs',
      component: Logs
    },
    {
      path: '/system/flush',
      name: 'Flush',
      component: Flush
    },
    {
      path: '/category/case',
      name: 'CCategory',
      component: Category,
      props: {
        code: 'case',
        label: '案例'
      }
    },
    {
      path: '/category/material',
      name: 'MCategory',
      component: Category,
      props: {
        code: 'material',
        label: '材料'
      }
    },
    {
      path: '/category/article',
      name: 'NCategory',
      component: Category,
      props: {
        code: 'article',
        label: '资讯'
      }
    },
    {
      path: '/category/style',
      name: 'STCategory',
      component: Category,
      props: {
        code: 'style',
        label: '风格'
      }
    },
    {
      path: '/category/space',
      name: 'SPCategory',
      component: Category,
      props: {
        code: 'space',
        label: '空间'
      }
    },
    {
      path: '/category/type',
      name: 'TCategory',
      component: Category,
      props: {
        code: 'type',
        label: '户型'
      }
    },
    {
      path: '/category/layout',
      name: 'LCategory',
      component: Category,
      props: {
        code: 'layout',
        label: '布局'
      }
    },
    {
      path: '/case',
      name: 'Case',
      component: Case
    },
    {
      path: '/case/add',
      name: 'CaseAdd',
      component: CaseAdd
    },
    {
      path: '/designer',
      name: 'Designer',
      component: Designer
    },
    {
      path: '/designer/add',
      name: 'DesignerAdd',
      component: DesignerAdd
    }
  ]
})

export default router
