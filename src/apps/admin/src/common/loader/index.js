import Vue from 'Vue'
import {default as loader} from './loader.vue'

export default {
  LoaderCls: null,
  div: null,
  instance: null,
  install: function (v) {
    v.prototype.$loader = this
  },
  show: function (opt) {
    if (!this.instance) {
      this.LoaderCls = Vue.extend(loader)
      let div = document.createElement('div')
      document.getElementById('app').appendChild(div)
      this.instance = new Vue({
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
