export default {
  access_token: '',
  login: null,
  install: function (v, opt) {
    this.login = opt.cache.get('login')
    this.access_token = opt.cache.get('access_token') || ''
    v.prototype.$sess = this
  }
}
