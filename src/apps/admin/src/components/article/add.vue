<template>
  <div class="profile">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <a class="btn btn-xs btn-info pull-right">
          <i class="fa fa-plus-square"></i> 新增
        </a>
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page" style="padding-right:15px">
      <form action="" method="post" accept-charset="utf-8">
        <div class="row">
          <div class="col-sm-8">
            <div class="row">
              <label class="col-sm-2 label-on-left">资讯标题</label>
              <div class="col-sm-10">
                  <div class="form-group">
                      <input class="form-control" v-model="form.article_title"  v-focus="form.article_title"  type="text" placeholder="资讯标题">
                  </div>
              </div>
            </div>

            <div class="row">
              <label class="col-sm-2 label-on-left">内容来源</label>
              <div class="col-sm-10">
                  <div class="form-group">
                      <input class="form-control" v-model="form.article_via"  v-focus="form.article_via"  type="text" placeholder="资讯来源">
                  </div>
              </div>
            </div>

            <div class="row">
              <label class="col-sm-2 label-on-left">所属分类</label>
              <div class="col-sm-10">
                  <div class="form-group">
                      <input class="form-control" v-model="form.article_cat_id"  v-focus="form.article_cat_id"  type="text" placeholder="所属分类">
                  </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <img class="preview_article_cover" style="width: 200px; height: 120px;" :src="article_cover" @click="foo">
            <input type="hidden" name="" v-model="form.article_cover">
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ArticleAdd',
  metaInfo () {
    return {
      title: '品牌管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '品牌', to: '/article'},
        {text: '编辑', href: '#'}
      ],
      form: {},
      article_cover: ''
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
    foo () {
      this.$uploader.select({
        onselect: this.onselect,
        uri: 'upload/image',
        el: this,
        pre: 'cover'
      })
    },
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('material/brand', {id: id, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = d.data
          this.suppliers = d.data.attrs.supplier
        } else {
          this.form = []
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('material/brand', this.form).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = d.data
        }
        this.refresh()
      })
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/article'
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/article'
  }
}
</script>
