export default {
  admin1: [
    {
      url: '/',
      name: '我的主页',
      icon: 'fa fa-home'
    },
    {
      url: '/customer',
      name: '客户管理',
      icon: 'fa fa-user-circle',
      children: [
        {
          url: '/customer/add',
          name: '新增客户',
          icon: 'fa fa-plus-square',
          active: false
        },
        {
          url: '/customer',
          name: '客户列表',
          icon: 'fa fa-th-list',
          active: false
        },
        {
          url: '/customer-order',
          name: '客户预约',
          icon: 'fa fa-bookmark',
          active: false
        }
      ]
    },
    {
      url: '/case',
      name: '案例管理',
      icon: 'fa fa-image',
      children: [
        {
          url: '/case/add',
          name: '新增客户',
          icon: 'fa fa-plus-square',
          active: false
        },
        {
          url: '/case',
          name: '案例列表',
          icon: 'fa fa-th-list',
          active: false
        },
        {
          url: '/case/category',
          name: '案例分类',
          icon: 'fa fa-tags',
          active: false
        }
      ]
    },
    {
      url: '/material',
      name: '材料管理',
      icon: 'fa fa-superpowers',
      children: [
        {
          url: '/material/add',
          name: '新增材料',
          icon: 'fa fa-plus-square',
          active: false
        },
        {
          url: '/material',
          name: '材料列表',
          icon: 'fa fa-th-list',
          active: false
        },
        {
          url: '/material/category',
          name: '材料分类',
          icon: 'fa fa-tags',
          active: false
        },
        {
          url: '/material/order',
          name: '新增采购',
          icon: 'fa fa-ambulance',
          active: false
        },
        {
          url: '/material/orders',
          name: '采购订单',
          icon: 'fa fa-shopping-bag',
          active: false
        }
      ]
    },
    {
      url: '/news',
      name: '资讯管理',
      icon: 'fa fa-newspaper-o',
      children: [
        {
          url: '/news/add',
          name: '新增资讯',
          icon: 'fa fa-plus-square',
          active: false
        },
        {
          url: '/news',
          name: '资讯列表',
          icon: 'fa fa-th-list',
          active: false
        },
        {
          url: '/news/category',
          name: '资讯分类',
          icon: 'fa fa-tags',
          active: false
        }
      ]
    },
    {
      url: '/operate',
      name: '运营管理',
      icon: 'fa fa-rocket',
      children: [
        {
          url: '/operate/index',
          name: '首页案例',
          icon: 'fa fa-plus-square',
          active: false
        }
      ]
    },
    {
      url: '/system',
      name: '系统管理',
      icon: 'fa fa-terminal',
      children: [
        {
          url: '/user',
          name: '管理账号',
          icon: 'fa fa-user-o',
          active: false
        },
        {
          url: '/user/group',
          name: '权限组',
          icon: 'fa fa-user-secret',
          active: false
        },
        {
          url: '/system/logs',
          name: '操作日志',
          icon: 'fa fa-bell-o',
          active: false
        },
        {
          url: '/system/flush',
          name: '缓存更新',
          icon: 'fa fa-refresh',
          active: false
        }
      ]
    },
    {
      url: '/logout',
      name: '注销登录',
      icon: 'fa fa-sign-out',
      active: false
    }
  ]
}
