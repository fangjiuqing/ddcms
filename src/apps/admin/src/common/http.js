import axios from 'axios'

export function fetch (url, params) {
  return new Promise((resolve, reject) => {
    axios.post(url, params)
      .then(response => {
        resolve(response.data)
      }, err => {
        reject(err)
      })
      .catch((error) => {
        reject(error)
      })
  })
}

export default {
  handle: axios,
  gateway: '',
  token: '',
  cache: null,
  loading: null,
  install: function (v, opt) {
    this.token = opt.sess.access_token || ''
    this.cache = opt.cache
    this.loading = opt.loading

    this.handle.defaults.timeout = 5000

    // 请求预处理
    this.handle.interceptors.request.use((config) => {
      config.headers.common['authkey'] = config.data['access_token'] || this.token
      if (config.method === 'post') {
        config.data = JSON.stringify(config.data || {})
      }
      return config
    }, (error) => {
      console.log(error, 'error')
      return Promise.reject(error)
    })

    // 响应预处理
    this.handle.interceptors.response.use((res) => {
      if (res.status !== 200) {
        return Promise.reject(res)
      } else {
        if (res.headers.authkey) {
          this.cache.set('access_token', res.headers.authkey)
        }
      }
      return res
    }, (error) => {
      return Promise.reject(error)
    })

    v.prototype.$http = this
  },
  post (uri, params) {
    return fetch(this.gateway, {
      uri: uri,
      data: params
    }).then(d => {
      return d
    })
  },
  get (uri, data) {
    data = data || {}
    return this.post(uri + '/get', data)
  },
  del (uri, data) {
    return this.post(uri + '/del', data)
  },
  save (uri, data) {
    return this.post(uri + '/save', data)
  },
  update (uri, data) {
    return this.post(uri + '/update', data)
  },
  list (uri, data) {
    return this.post(uri + '/list', data)
  },
  set (uri, data) {
    data = data || {}
    return this.post(uri + '/set', data)
  }
}
