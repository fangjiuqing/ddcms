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
                <div class="form-group">
                    <input class="form-control" name="case_title" v-model="form.case_title"  v-focus="form.case_title"  type="text" placeholder="案例名称">
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <select v-model="form.case_cat_id"  name="case_cat_id" class="form-control">
                          <option disabled value="">请选择分类</option>
                          <option v-for="(v) in categories" v-bind:key="v.cat_id" :value="v.cat_id" v-html="v.space">
                          </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select v-model="form.case_space_id" name="case_space_id" class="form-control">
                          <option value="0">默认空间</option>
                          <option v-for="(v) in space" v-bind:key="v.cat_id" :value="v.cat_id" v-html="v.space || v.cat_name">
                          </option>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <select v-model="form.case_style_id"  name="case_style_id" class="form-control">
                          <option disabled value="0">默认风格</option>
                          <option v-for="(v) in style" v-bind:key="v.cat_id" :value="v.cat_id" v-html="v.space || v.cat_name">
                          </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select v-model="form.case_layout_id" name="case_layout_id" class="form-control">
                          <option value="0">默认布局</option>
                          <option v-for="(v) in layout" v-bind:key="v.cat_id" :value="v.cat_id" v-html="v.space || v.cat_name">
                          </option>
                        </select>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-sm-5">
              <img class="preview_cover" style="width: 200px; height: 120px;" :src="cover" @click="upload_cover">
              <input type="hidden" name="cover" v-model="form.cover">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-block">
          <div class="row">
            <div class="col-md-5">
              <h5 class="block-h5">项目信息
              </h5>
              <div class="form-group text-left">
                <v-distpicker :province="form.province" :city="form.city" hide-area @selected="onSelected"></v-distpicker>
              </div>
              <div class="form-group">
                  <input class="form-control" name="case_community" v-model="form.case_community"  v-focus="form.case_community"  type="text" placeholder="小区">
              </div>
              <div class="form-group">
                  <input class="form-control" name="case_area" v-model="form.case_area"  v-focus="form.case_area"  type="text" placeholder="面积">
              </div>
              <div class="form-group">
                  <input class="form-control" name="case_price" v-model="form.case_price"  v-focus="form.case_price"  type="text" placeholder="造价">
              </div>
            </div>
            <div class="col-md-7">
              <h5 class="block-h5">背景信息
                <btn class="btn btn-info btn-xs pull-right" @click="add_attr">新增</btn>
              </h5>
              <table class="table table-striped">
                <tbody>
                  <tr v-for="(row, row_key) in attrs" :key="row_key">
                    <td width="35%">
                      <input class="form-control material_field_input" v-model="attrs[row_key]['key']" placeholder="请输入项名称"/>
                    </td>
                    <td width="55%">
                      <input class="form-control material_field_input" v-model="attrs[row_key]['val']" value="" placeholder="请输入项取值" />
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
          <div class="row">
            <div class="col-md-12">
              <h5 class="block-h5">案例图片
              </h5>
              <div v-for="(row, row_key) in space" :key="row_key" class="case-block">
                <h6 class="title-h6">{{row.cat_name}}
                  <btn class="btn btn-xs pull-right btn-info" style="margin-right:5px;" @click="upload_image(row.cat_id)">
                    <i class="fa fa-plus-square"></i>
                  </btn>
                </h6>
                <div class="case-image" v-for="(img, image_key) in images" v-if="img.cat_id === row.cat_id" :key="image_key">
                    <div class="case-image-wrap">
                      <btn class="btn btn-xs btn-info" title="设为封面" @click="set_cover(image_key)"><i class="fa fa-image"></i></btn>
                      <img :src="img.url">
                      <btn class="btn btn-xs btn-danger" title="移除" @click="rm_image(image_key)"><i class="fa fa-trash-o"></i></btn>
                    </div>
                    <textarea v-model="images[image_key]['desc']" placeholder="图片说明"></textarea>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
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
export default {
  name: 'CaseAdd',
  components: { VDistpicker },
  metaInfo () {
    return {
      title: '新增案例 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '案例', to: '/case'},
        {text: '编辑', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      form: {
        case_cat_id: '',
        case_style_id: 0,
        case_space_id: 0,
        case_layout_id: 0
      },
      attrs: {
        key0: {
          key: '家庭成员',
          val: ''
        },
        key1: {
          key: '生活习惯',
          val: ''
        },
        key2: {
          key: '风格喜好',
          val: ''
        },
        key3: {
          key: '其他要求',
          val: ''
        }
      },
      cover: '',
      extra: {},
      categories: [],
      style: [],
      type: [],
      layout: [],
      space: [],
      images: {}
    }
  },
  methods: {
    onSelected (d) {
      this.form.case_region0 = d.province.code
      this.form.case_region1 = d.city.code
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
      this.form.case_cover = d.image
      this.cover = d.thumb
    },
    on_cover_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },
    on_image_error (msg) {
      this.$loading.hide()
      this.$notify({
        content: msg,
        duration: 2000,
        type: 'danger',
        dismissible: false
      })
    },
    on_image_start (e) {
      this.$loading.show({
        msg: '文件上传中, 已发送 0 % ...'
      })
    },
    on_image_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },
    on_image_finish (d) {
      this.$loading.hide()
      this.$notify({
        content: '上传成功',
        duration: 1000,
        type: 'success',
        dismissible: false
      })
      let key = this.$util.rand_str(16)
      this.$set(this.$data.images, key, {
        desc: '',
        image: d.image,
        url: d.url,
        cat_id: this.catID
      })
    },
    set_cover (key) {
      if (this.images[key]) {
        this.form.case_cover = this.images[key].image
        this.cover = this.images[key].url
        this.$notify({
          content: '设置成功',
          duration: 1000,
          type: 'success',
          dismissible: false
        })
      }
    },
    rm_image (key) {
      this.$delete(this.$data.images, key)
    },
    upload_image (catID) {
      this.catID = catID
      this.$uploader.select({
        uri: 'upload/image',
        el: this,
        pre: 'image'
      })
    },
    upload_cover () {
      this.$uploader.select({
        uri: 'upload/image',
        el: this,
        pre: 'cover'
      })
    },
    del_attr (key) {
      this.$delete(this.$data.attrs, key)
    },
    add_attr () {
      this.$set(this.$data.attrs, this.$util.rand_str(16), {
        key: '',
        val: ''
      })
    },
    modify (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('case', {id: this.id || 0, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = this.id ? d.data.row : this.form
          this.images = d.data.images || {}
          this.attrs = d.data.attrs || this.attrs
          this.cover = d.data.row['cover'] || ''
          this.categories = d.data.category || []
          this.style = d.data.style || []
          this.space = d.data.space || []
          this.type = d.data.type || []
          this.layout = d.data.layout || []
        } else {
          this.form = []
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('case', {
        base: this.form,
        images: this.images,
        attrs: this.attrs
      }).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/case'
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
  .case-image {
    width: 49%;
    height: 120px;
    float: left;
    margin: 10px 10px 10px 0;
    background: #f0f0f0;
    border-radius: 3px;
    padding: 10px;
    text-align: left;
  }
  .case-image .case-image-wrap {
    width: 40%;
    position: relative;
    height: 100%;
    float: left;
  }
  .case-image .case-image-wrap img {
    max-height: 100px;
    position: absolute;
    margin: auto;
    left: 0;
    right: 0;
  }
  .case-image .case-image-wrap .btn {
    display: none;
  }
  .case-image .case-image-wrap .btn-danger {
    position: absolute;
    bottom: 5px;
    margin: auto;
    left: 0;
    right: 0;
    width: 20px;
    height: 20px;
  }
  .case-image .case-image-wrap .btn-info {
    position: absolute;
    top: 5px;
    margin: auto;
    left: 0;
    right: 0;
    padding: 0;
    z-index: 10;
    width: 20px;
    height: 20px;
  }
  .case-image .case-image-wrap:hover .btn {
    display: block;
  }
  .case-image textarea {
    height: 100px;
    width: 60%;
    float: right;
    border: 1px solid #ccc;
    border-radius: 3px;
    padding: 5px;
    resize: none;
  }
</style>
