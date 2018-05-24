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
      url: '/operate',
      name: '运营管理',
      icon: 'fa fa-rocket',
      children: [
        {
          url: '/designer',
          name: '设计师',
          icon: 'fa fa-address-book',
          active: false
        },
        {
          url: '/case',
          name: '案例列表',
          icon: 'fa fa-image',
          active: false
        },
        {
          url: '/operate/index',
          name: '首页案例',
          icon: 'fa fa-plus-square',
          active: false
        },
        {
          url: '/article',
          name: '资讯管理',
          icon: 'fa fa-newspaper-o',
          active: false
        },
        {
          url: '/community',
          name: '小区管理',
          icon: 'fa fa-building',
          active: false
        }
      ]
    },
    {
      url: '/store',
      name: '商城管理',
      icon: 'fa fa-shopping-bag',
      children: [
        {
          url: '/store/order',
          name: '订单列表',
          icon: 'fa fa-calendar-o',
          active: false
        },
        {
          url: '/store/goods',
          name: '商品列表',
          icon: 'fa fa-gift',
          active: false
        },
        {
          url: '/store/goods/type',
          name: '商品类型',
          icon: 'fa fa-cog',
          active: false
        },
        {
          url: '/store/promotion',
          name: '促销管理',
          icon: 'fa fa-rocket',
          active: false
        },
        {
          url: '/store/shipping',
          name: '配送管理',
          icon: 'fa fa-truck',
          active: false
        }
      ]
    },
    {
      url: '/advert',
      name: '广告管理',
      icon: 'fa fa-audio-description',
      children: [
        {
          url: '/advert',
          name: '广告列表',
          icon: 'fa fa-file-audio-o',
          active: false
        },
        {
          url: '/advert-content',
          name: '广告内容',
          icon: 'fa fa-inbox',
          active: false
        }
      ]
    },
    {
      url: '/category',
      name: '分类管理',
      icon: 'fa fa-yelp',
      children: [
        {
          url: '/category/article',
          name: '资讯分类',
          icon: 'fa fa-newspaper-o',
          active: false
        },
        {
          url: '/category/material',
          name: '材料分类',
          icon: 'fa fa-bath',
          active: false
        },
        {
          url: '/category/case',
          name: '案例分类',
          icon: 'fa fa-image',
          active: false
        },
        {
          url: '/category/style',
          name: '风格分类',
          icon: 'fa fa-magic',
          active: false
        },
        {
          url: '/category/space',
          name: '空间分类',
          icon: 'fa fa-hotel',
          active: false
        },
        {
          url: '/category/type',
          name: '户型分类',
          icon: 'fa fa-superpowers',
          active: false
        },
        {
          url: '/category/layout',
          name: '布局分类',
          icon: 'fa fa-delicious',
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
          url: '/system/admin',
          name: '管理账号',
          icon: 'fa fa-user-o',
          active: false
        },
        {
          url: '/system/admin/group',
          name: '管理权限',
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
