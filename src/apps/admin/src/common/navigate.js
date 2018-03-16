export default {
  admin1: [
    {
      url: '/customer',
      name: '客户管理',
      icon: 'fa fa-user-circle',
      children: [
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
          name: '新增案例',
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
          url: '/material/orders',
          name: '采购订单',
          icon: 'fa fa-shopping-bag',
          active: false
        },
        {
          url: '/material/stock',
          name: '仓库管理',
          icon: 'fa fa-rebel',
          active: false
        },
        {
          url: '/material/brand',
          name: '品牌管理',
          icon: 'fa fa-coffee',
          active: false
        },
        {
          url: '/material/supplier',
          name: '供应商',
          icon: 'fa fa-bullhorn',
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
        },
        {
          url: '/operate/desinger',
          name: '设计师',
          icon: 'fa fa-address-book',
          active: false
        }
      ]
    },
    {
      url: '/system',
      name: '系统管理',
      icon: 'fa fa-delicious',
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
    }
  ]
}
