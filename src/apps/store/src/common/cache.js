export default {
  pre: '',
  install: function (v, opt) {
    this.key = 'pfm'
    v.prototype.$cache = this
  },
  get_key: function (k) {
    if (typeof (k) === 'object') {
      return this.pre + '-' + this.hash(k[0]) + '@' + k[1]
    }
    return this.pre + '-' + this.hash(k)
  },
  hash: function (input) {
    let I64BIT_TABLE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-'.split('')
    let hash = 5381
    let i = input.length - 1
    if (typeof input === 'string') {
      for (; i > -1; i--) {
        hash += (hash << 5) + input.charCodeAt(i)
      }
    } else {
      for (; i > -1; i--) {
        hash += (hash << 5) + input[i]
      }
    }
    let val = hash & 0x7FFFFFFF
    let ret = ''
    do {
      ret += I64BIT_TABLE[val & 0x3F]
    }
    while ((val >>= 6) !== 0)
    return ret
  },

  set: function (k, v, ttl) {
    let expiredTime = (Date.parse(new Date()) / 1000) + (ttl || 99999999)
    localStorage.setItem(this.get_key(k), JSON.stringify([v, expiredTime]))
  },

  get: function (k) {
    k = this.get_key(k)
    var ret = JSON.parse(localStorage.getItem(k))
    if (ret !== null && (Date.parse(new Date()) / 1000) < ret[1]) {
      ret = ret[0]
    } else {
      ret = null
      localStorage.removeItem(k)
    }
    return ret
  },

  del: function (k) {
    localStorage.removeItem(this.pre + '-' + k)
  },

  keys: function (regex) {
    let ret = []
    regex = new RegExp('^' + this.pre + '-' + (regex === undefined ? '.*$' : regex))
    for (var i = 0; i < localStorage.length; i++) {
      var key = localStorage.key(i)
      if (regex.exec(key)) {
        ret.push(key.replace(this.pre + '-', ''))
      }
    }
    return ret
  }
}
