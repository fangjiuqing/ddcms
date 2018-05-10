<template>
  <div class="community">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="" method="post" accept-charset="utf-8">
        <div class="form-block">
          <div class="row">
            <div class="col-md-12">
              <h5 class="block-h5">编辑户型</h5>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-7">
              <div class="row">
                <label class="col-sm-4 label-on-left">户型名称</label>
                <div class="col-md-8">
                  <div class="form-group">
                    <input class="form-control" name="pu_name" v-model="form.pu_name" type="text" placeholder="户型名称">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group">
                      <input class="form-control" name="pu_area0" v-model="form.pu_area0" type="number" placeholder="总面积">
                      <span class="input-group-addon">M²</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group">
                      <input class="form-control" name="pu_area1" v-model="form.pu_area1" type="text" placeholder="可用面积">
                      <span class="input-group-addon">M²</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group">
                      <input class="form-control" name="pu_room0" v-model="form.pu_room0" type="text" placeholder="卧室">
                      <span class="input-group-addon">室</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group">
                      <input class="form-control" name="pu_room1" v-model="form.pu_room1" type="text" placeholder="客厅">
                      <span class="input-group-addon">厅</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group">
                      <input class="form-control" name="pu_room2" v-model="form.pu_room2" type="text" placeholder="厨房">
                      <span class="input-group-addon">厨</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group">
                      <input class="form-control" name="pu_room3" v-model="form.pu_room3" type="text" placeholder="卫生间">
                      <span class="input-group-addon">卫</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <div class="col-sm-5">
          <img class="preview_cover" style="width: 200px; height: 230px;" :src="cover" @click="upload_cover">
          <input type="hidden" name="pu_cover" v-model="form.pu_cover">
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
      <div class="row">
        <div class="col-md-11" style="margin:0 auto; float: none">
          <btn type="success" @click="save" class="btn btn-success pull-right">保存</btn>
        </div>
      </div>
    </form>
    </div>
  </div>
</template>
<script>
import { VueEditor } from 'vue2-editor'
export default {
  name: 'TypeAdd',
  components: { VueEditor },
  metaInfo () {
    return {
      title: '编辑户型 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '小区管理', to: '/community'},
        {text: '编辑户型', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      form: {
        pu_co_id: this.$route.query['id'] || 0
      },
      cover: '',
      attrs: 1,
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
      this.form.pu_cover = d.image
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
    refresh: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('unit', {id: this.id || 0, attrs: 1, pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = this.id ? d.data.list : {}
          this.pn = d.data.paging.pn
          this.total = d.data.paging.max
        } else {
          this.form = []
        }
      })
    },
    modify (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('unit', {id: this.id || 0, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = this.id ? d.data : this.form
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        } else {
          this.form = this.form || {}
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('unit', this.form).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/community/type',
            query: {id: this.id}
          })
          this.refresh()
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
            duration: 1500,
            type: 'danger',
            dismissible: false
          })
        }
      })
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/operate'
    this.modify()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/operate'
  }
}
</script>
<style scoped>
  /* #editor {
  } */
  .quillWrapper {
    position: relative;
  }
  .quillWrapper .ql-snow.ql-toolbar {
    width: 100%;
  }
  .ql-editor {
    min-height: 360px;
  }
  .ql-toolbar {
    text-align: left;
  }

  [v-cloak] {
      display: none;
  }

  .hintsbox-mark {
      position: relative;
      z-index:9999;
  }

  .hintsbox-mark input{
      width: 100%;
  }

  .hintsbox {
      width: 100%;
      border: 1px solid #ddd;

  }

  .hintslist .hint {
      padding: 4px 2px 4px 8px;
      list-style-type : none;
      text-align:left;
  }

  .hintslist .hint:hover {
      background-color: #DDD8E5;
      cursor: pointer;
  }

  .hintslist .hint.active {
      background-color: #DDD8E5;
  }
</style>
