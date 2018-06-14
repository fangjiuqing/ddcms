<template>
  <div class="advert">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <div class="form-block">
        <div class="row">
          <h5 class="block-h5">广告内容</h5>
        </div>
      </div>
      <div class="form-block">
        <div class="row">
          <div class="col-sm-5">
            <label class="col-sm-3 label-on-left">广告名称</label>
            <div class="form-group col-sm-9">
              <input type="text" class="form-control" name="ad_name" placeholder="广告名称" v-model="form.ad_name">
            </div>
          </div>
          <div class="col-sm-5">
            <label class="col-sm-3 label-on-left">链接</label>
            <div class="form-group col-sm-9">
              <input type="text" class="form-control" name="ad_url" placeholder="链接" v-model="form.ad_url">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-5">
            <label class="col-sm-3 label-on-left">广告状态</label>
            <div class="form-group col-sm-5">
              <select v-model="form.ad_status" class="form-control status">
                <option disabled value="0">未知状态</option>
                <option v-for="(v, index) in model" :key="index" :value="index">
                  {{v}}
                </option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-5">
            <label class="col-sm-3 label-on-left">广告图片</label>
            <img class="preview_cover" style="width: 300px; height: 200px;" :src="cover" @click="upload_cover">
            <input type="hidden" v-model="form.ad_image">
          </div>
        </div>
      </div>
      <div class="form-block">
        <div class="row">
          <div class="col-md-12" style="margin:15px auto; float: none">
            <btn type="success" v-on:click="save" class="btn btn-success pull-right">保存</btn>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdvertAdd',
  metaInfo () {
    return {
      title: '广告新增 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '广告', to: '/advert'},
        {text: '编辑', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      form: {},
      model: {},
      cover: require('@/assets/images/default_4x3.jpg'),
      extra: {}
    }
  },
  methods: {
    upload_cover () {
      this.$uploader.select({
        uri: 'upload/image',
        el: this,
        pre: 'cover'
      })
    },
    on_cover_error (msg) {
      this.$loading.hide()
      this.$notify({
        content: msg,
        duration: 2000,
        type: 'danger',
        dismissible: false
      })
    },
    on_cover_start (e) {
      this.$loading.show({
        msg: '文件上传中, 已发送 0 % ...'
      })
    },
    on_cover_finish (d) {
      this.$loading.hide()
      this.$notify({
        content: '上传成功',
        duration: 1000,
        type: 'success',
        dismissible: false
      })
      this.form.ad_image = d.image
      this.cover = d.thumb
    },
    on_cover_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },
    on_editor_error (msg) {
      this.$loading.hide()
      this.$notify({
        content: msg,
        duration: 2000,
        type: 'danger',
        dismissible: false
      })
    },
    on_editor_start (e) {
      this.$loading.show({
        msg: '文件上传中, 已发送 0 % ...'
      })
    },
    on_editor_finish (d) {
      this.$loading.hide()
      this.$notify({
        content: '上传成功',
        duration: 1000,
        type: 'success',
        dismissible: false
      })
      let url = d.url
      this.extra.Editor.insertEmbed(this.extra.cursorLocation, 'image', url)
      this.extra.resetUploader()
    },
    on_editor_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },
    upload_image (file, Editor, cursorLocation, resetUploader) {
      let formData = new FormData()
      formData.append('raw', JSON.stringify({
        'uri': 'upload/image',
        'access_token': this.$sess.access_token
      }))
      formData.append('file', file)
      this.extra = {Editor, cursorLocation, resetUploader}
      this.$uploader.exec({
        uri: 'upload/image',
        el: this,
        pre: 'editor',
        data: formData
      })
    },
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('advert', {id: this.id || 0}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = d.data.row || this.form
          this.model = d.data.ad_status
          this.cover = this.form.ad_image
        } else {
          this.$alert({
            title: '操作提示',
            content: d.msg
          }, (msg) => {
            if (d.code === 9999) {
              this.$router.go(-1)
            }
          })
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('advert', this.form).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/advert'
          })
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'success',
            dismissible: false
          })
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        } else {
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'danger',
            dismissible: false
          })
        }
      })
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/advert'
    this.modify()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/advert'
    this.modify()
  }
}
</script>
<style scoped>
.advert {
  background: #fff;
}
.status {
  width: 190%;
}
.preview_cover {
  float: left;
  margin-left: 15px;
}
</style>
