import Vue from 'Vue'
import {default as loader} from './loader.vue'

import store from '@/store'

export default {
  LoaderCls: null,
  div: null,
  instance: null,
  install: function (v) {
    v.prototype.$loader = this
  },
  show: function (opt) {
    opt = opt || {
      msg: '加载中, 请稍后 ...',
      type: 'loading',
      left_offset: '200px'
    }
    if (!this.instance) {
      this.LoaderCls = Vue.extend(loader)
      let div = document.createElement('div')
      document.getElementById('app').appendChild(div)
      this.instance = new Vue({
        store,
        extends: this.LoaderCls
      })
      this.instance.$mount(div)
    }
    this.instance.show(opt)
  },
  hide: function () {
    if (this.instance) {
      this.instance.hide()
    }
  }
}
