<template>
  <div class="profile">
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
              <h5 class="block-h5">基本信息</h5>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-7">
                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                        <input class="form-control" name="des_name" v-model="form.des_name"  v-focus="form.des_name"  type="text" placeholder="设计师姓名">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                        <input class="form-control" name="des_title" v-model="form.des_title"  v-focus="form.des_title"  type="text" placeholder="设计师职位">
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" name="des_workyears" v-model="form.des_workyears"  v-focus="form.des_workyears"  type="number" placeholder="工作年数">
                            <span class="input-group-addon">年</span>
                        </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" name="des_price" v-model="form.des_price"  v-focus="form.des_price"  type="text" placeholder="设计价格">
                            <span class="input-group-addon">元/M²</span>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <input class="form-control" name="des_concept_tags" v-model="form.des_concept_tags"  v-focus="form.des_concept_tags"  type="text" placeholder="设计理念">
                </div>
                <div class="form-group">
                  <input class="form-control" name="des_slogan" v-model="form.des_slogan"  v-focus="form.des_slogan"  type="text" placeholder="设计标语">
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group text-left">
                      <v-distpicker :province="form.province" :city="form.city" hide-area @selected="onSelected"></v-distpicker>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <select v-model="form.des_case_id"  name="des_case_id" class="form-control">
                      <option value="0">选择代表案例</option>
                      <option v-for="(v) in cases" v-bind:key="v.case_id" :value="v.case_id" v-html="v.case_title">
                      </option>
                    </select>
                  </div>
                </div>
            </div>
            <div class="col-sm-5">
              <img class="preview_cover" style="width: 200px; height: 230px;" :src="cover" @click="upload_cover">
              <input type="hidden" name="des_cover" v-model="form.des_cover">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-block">
          <div class="row">
            <div class="col-md-5">
              <h5 class="block-h5">风格标签
                  <btn class="btn btn-info btn-xs pull-right" @click="add_style_tag">新增</btn>
              </h5>
              <table class="table table-striped">
                <tbody>
                  <tr v-for="(row, row_key) in stags" :key="row_key">
                    <td width="90%">
                      <input class="form-control material_field_input" v-model="stags[row_key]['val']" value="" placeholder="请输入标签名称" />
                    </td>
                    <td>
                      <btn class="btn btn-xs btn-danger" @click="del_stag(row_key)"><i class="fa fa-trash-o"></i></btn>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-7">
              <h5 class="block-h5">所获奖项
                <btn class="btn btn-info btn-xs pull-right" @click="add_attr">新增</btn>
              </h5>
              <table class="table table-striped">
                <tbody>
                  <tr v-for="(row, row_key) in attrs" :key="row_key">
                    <td width="90%">
                      <input class="form-control material_field_input" v-model="attrs[row_key]['val']" value="" placeholder="请输入奖项名称" />
                    </td>
                    <td>
                      <btn class="btn btn-xs btn-danger" @click="del_attr(row_key)"><i class="fa fa-trash-o"></i></btn>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="form-block">
          <h5 class="block-h5">设计师简介</h5>
          <vue-editor ref="editor" id="editor"
            useCustomImageHandler
            @imageAdded="upload_image" v-model="form.des_about">
          </vue-editor>
        </div>
        <div class="row">
          <div class="col-md-11" style="margin:0 auto; float: none">
            <btn type="success" v-on:click="save" class="btn btn-success pull-right">保存</btn>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import VDistpicker from 'v-distpicker'
import { VueEditor } from 'vue2-editor'
export default {
  name: 'DesignerAdd',
  components: { VDistpicker, VueEditor },
  metaInfo () {
    return {
      title: '新增设计师 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '设计师', to: '/designer'},
        {text: '编辑', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      form: {},
      cover: '',
      extra: {},
      styles: {},
      attrs: {
        key0: {
          val: ''
        }
      },
      stags: {
        key0: {
          val: ''
        }
      },
      cases: {}
    }
  },
  methods: {
    onSelected (d) {
      this.form.des_region0 = d.province.code
      this.form.des_region1 = d.city.code
    },
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
      this.form.des_cover = d.image
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
    del_attr (key) {
      this.$delete(this.$data.attrs, key)
    },
    add_attr () {
      this.$set(this.$data.attrs, this.$util.rand_str(16), {
        val: ''
      })
    },
    add_style_tag () {
      this.$set(this.$data.stags, this.$util.rand_str(20), {
        val: ''
      })
      console.log(this.$data.stags)
    },
    del_stag (key) {
      this.$delete(this.$data.stags, key)
    },
    modify (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('designer', {id: this.id || 0, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = this.id ? d.data.row : this.form
          this.cover = d.data.row.cover || ''
          this.styles = d.data.styles || []
          this.cases = d.data.cases || []
          this.attrs = d.data.attrs || this.attrs
          this.stags = d.data.stags || this.stags
        } else {
          this.form = []
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('designer', {
        base: this.form,
        attrs: this.attrs,
        stags: this.stags
      }).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/designer'
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
