<template>
  <div class="customer">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <h5 class="block-h5">广告编辑</h5>
      <form action="" method="post" accept-charset="utf-8">
        <div class="row">
           <div class="col-sm-5">
              <label class="col-sm-3 label-on-left">广告名称</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="ad_name" placeholder="广告名称" v-model="rows.ad_name">
              </div>
            </div>
            <div class="form-group col-sm-5">
              <!-- <switches style="font-weight: 300" value="2" theme="bootstrap" color="success" text-enabled="发布" text-disabled="草稿"></switches> -->
              <select v-model="rows.ad_status" class="form-control">
                <option disabled value="0">未知状态</option>
                <option v-for="(v, index) in model" v-bind:key="index" :value="v" v-html="v">
                  {{v}}
                </option>
              </select>
            </div>
        </div>
        <div class="row">
          <div class="col-sm-5">
            <label class="col-sm-3 label-on-left">广告图片</label>
            <img class="preview_cover" style="width: 200px; height: 200px;" :src="cover" @click="upload_cover">
            <input type="hidden" v-model="cover">
          </div>
        </div>
        <div class="row">
          <div class="col-md-10" style="margin:0 auto; float: none">
            <btn type="success" v-on:click="save" class="btn btn-success pull-right">保存</btn>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
// import Switches from 'vue-switches'
export default {
  name: 'AdvertAdd',
  metaInfo () {
    return {
      title: '广告新增 - 道达智装'
    }
  },
  // components: {Switches},
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '广告', to: '/advert'},
        {text: '编辑', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      rows: {
        ad_status: ''
      },
      model: [],
      cover: require('@/assets/images/default_1x1.jpg'),
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
      this.rows.ad_desc.image = d.image
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
    modifi (id) {
      this.$router.push({
        path: '/advert/add',
        query: {id}
      })
    },
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('advert', {id: this.id || 0}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = this.id ? d.data.row : {}
          this.model = d.data.ad_status
          this.ad_status = this.model
          this.cover = this.rows.ad_desc.image
          console.log(d.data)
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        } else {
          this.form = []
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('advert', this.rows).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.refresh()
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'success',
            dismissible: false
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
<style>
.customer, .app_mask {
  background: #fff;
}
</style>
