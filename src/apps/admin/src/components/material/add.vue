<template>
  <div class="profile">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page" style="padding-right:15px">
      <form action="" method="post" accept-charset="utf-8">
        <div class="row" style="width: 91.66666667%;margin:0 auto;">
          <div class="col-sm-7" style="padding-left:0">
              <div class="row">
                <label class="col-sm-2 field-label">名称</label>
                <div class="col-sm-10 input-label">
                  <input class="form-control" name="mat_name" v-model="form.mat_name"  v-focus="form.mat_name"  type="text" placeholder="材料名称">
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 field-label">品牌</label>
                <div class="col-sm-10 input-label">
                  <select v-model="form.mat_brand_id"  name="mat_brand_id" class="form-control">
                    <option disabled value="">请选择</option>
                    <option v-for="(v) in brands" v-bind:key="v.pb_id" :value="v.pb_id">
                      {{v.pb_name}}
                    </option>
                  </select>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 field-label">类型</label>
                <div class="col-sm-10 input-label">
                  <select v-model="form.mat_type" class="form-control">
                    <option disabled value="">请选择</option>
                    <option v-for="(v, k) in mat_type" v-bind:key="k" :value="k">
                      {{v}}
                    </option>
                  </select>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 field-label">分类</label>
                <div class="col-sm-10 input-label">
                  <select v-model="form.mat_cat_id"  name="mat_cat_id" class="form-control">
                    <option disabled value="">请选择</option>
                    <option v-for="(v) in categories" v-bind:key="v.cat_id" :value="v.cat_id" v-html="v.space">
                    </option>
                  </select>
                </div>
              </div>
          </div>
          <div class="col-sm-5">
            <img class="preview_article_cover" style="width: 200px; height: 120px;" :src="mat_cover" @click="upload_cover">
            <input type="hidden" name="mat_cover" v-model="form.mat_cover">
          </div>
        </div>

        <div style="width: 91.66666667%;margin:15px auto; float: none;background:#f3f3f3;border-radius:3px;padding:15px;">
          <h3 style="font-size: 13px;">材料规格</h3>
        </div>

        <div class="row">
          <div class="col-md-12" style="margin:0 auto; float: none">
            <btn type="success" v-on:click="save" class="btn btn-success pull-right">保存</btn>
          </div>
        </div>
        <IBox title="asdfas">
          <slot name="icon"><i class="fa fa-pencil"></i></slot>
        </IBox>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  name: 'ArticleAdd',
  metaInfo () {
    return {
      title: '材料管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '材料', to: '/material'},
        {text: '编辑', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      form: {
        mat_type: '',
        mat_cat_id: '',
        mat_brand_id: ''

      },
      mat_cover: '',
      extra: {},
      categories: [],
      mat_type: [],
      brands: [],
      selected: ''
    }
  },
  methods: {
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
      this.form.article_cover = d.image
      this.article_cover = d.thumb
    },
    on_cover_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },
    upload_cover () {
      this.$uploader.select({
        uri: 'upload/image',
        el: this,
        pre: 'cover'
      })
    },
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('material', {id: this.id, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = d.data.row.length > 0 ? d.data.row : this.form
          this.article_cover = this.form['article_cover_thumb'] || ''
          this.categories = d.data.category
          this.mat_type = d.data.type
          this.brands = d.data.brands
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('material', this.form).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/material'
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
    this.$store.state.left_active_key = '/material'
    this.modify()
    console.log(this.form.mat_type)
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/material'
  }
}
</script>

<style>
  #editor {
  }
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
</style>
