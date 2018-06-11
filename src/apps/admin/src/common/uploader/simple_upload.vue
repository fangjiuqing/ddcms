<template>
  <input type="file" name="fileUpload" style="display:none" @change="onFileChange" ref="simple_upload_input">
</template>

<script>
export default {
  name: 'fileupload',
  data () {
    return {
      file: null,
      opts: {},
      el: null,
      pre: ''
    }
  },
  methods: {
    emitter (event, data) {
      this.el['on_' + this.pre + '_' + event](data)
    },
    uploadProgress (oEvent) {
      let vm = this
      if (oEvent.lengthComputable) {
        let percentComplete = Math.round(oEvent.loaded * 100 / oEvent.total)
        vm.emitter('progress', percentComplete)
      } else {
        vm.emitter('progress', false)
      }
    },
    select (opts) {
      this.el = opts.el
      this.pre = opts.pre || 'default'
      this.opts = {
        uri: opts.uri || 'upload/file',
        accept: opts.accept || 'image/*',
        multiple: opts.multiple || false,
        maxlength: opts.maxlength || 1024 * 8 * 1024
      }
      this.$refs.simple_upload_input.accept = this.opts.accept
      this.$refs.simple_upload_input.multiple = this.opts.multiple
      this.$refs.simple_upload_input.click()
    },
    exec (opts) {
      this.el = opts.el
      this.pre = opts.pre || 'default'
      this.post(opts.data)
    },
    post (form) {
      let vm = this
      var xhr = new XMLHttpRequest()
      xhr.open('POST', this.el.$http.gateway)
      xhr.setRequestHeader('authkey', this.el.$cache.get('access_token'))
      this.$refs.simple_upload_input.value = ''
      xhr.onloadstart = function (e) {
        vm.emitter('start', e)
      }
      xhr.onloadend = function (e) {
        let res = JSON.parse(xhr.responseText)
        if (res.code !== 0) {
          vm.emitter('error', res.msg)
        } else {
          vm.emitter('finish', res.data)
        }
      }
      xhr.upload.onprogress = vm.uploadProgress
      xhr.send(form)
    },
    onFileChange (e) {
      let vm = this
      let files = e.target.files || e.dataTransfer.files
      if (!files.length) {
        vm.emitter('error', '请选择文件')
        return
      }

      this.file = files[0]
      let formData = new FormData()
      formData.append('raw', JSON.stringify({
        'uri': this.opts.uri
      }))
      formData.append('file', this.file)
      this.post(formData)
    }
  }
}
</script>
