export default {
  admin1: [
    {
      url: '',
      name: '我的资料',
      icon: 'fa fa-home',
      children: [
        {
          url: '/user/profile',
          name: '我的资料',
          icon: 'fa fa-cog',
          active: false
        },
        {
          url: '/user/passwd',
          name: '密码修改',
          icon: 'fa fa-key',
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
