import Vue from 'vue'
import {default as loading} from './loading.vue'

export default {
  LoaderCls: null,
  div: null,
  instance: null,
  install: function (v) {
    v.prototype.$loading = this
  },
  show: function (opt) {
    opt = opt || {
      msg: '加载中, 请稍后 ...',
      type: 'loading',
      left_offset: '160px'
    }
    if (!this.instance) {
      this.LoadingCls = Vue.extend(loading)
      let div = document.createElement('div')
      document.getElementById('app').appendChild(div)
      this.instance = new Vue({
        extends: this.LoadingCls
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
