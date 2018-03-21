import Vue from 'Vue'
import {default as upload} from './simple_upload.vue'

export default {
  UploadCls: null,
  instance: null,
  install: function (v) {
    v.prototype.$uploader = this
  },
  select: function (opt) {
    opt = opt || {}
    if (!this.instance) {
      this.UploadCls = Vue.extend(upload)
      let div = document.createElement('div')
      document.getElementById('app').appendChild(div)
      this.instance = new Vue({
        extends: this.UploadCls
      })
      this.instance.$mount(div)
    }
    this.instance.select(opt)
  },
  upload: function () {},
  cancle: function () {}
}
