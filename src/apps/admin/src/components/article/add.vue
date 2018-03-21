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
                      <input class="form-control" v-model="modal_data.pb_name"  v-focus="modal_data.pb_name"  type="text" placeholder="资讯标题">
                  </div>
              </div>
            </div>

            <div class="row">
              <label class="col-sm-2 label-on-left">内容来源</label>
              <div class="col-sm-10">
                  <div class="form-group">
                      <input class="form-control" v-model="modal_data.pb_name"  v-focus="modal_data.pb_name"  type="text" placeholder="资讯来源">
                  </div>
              </div>
            </div>

            <div class="row">
              <label class="col-sm-2 label-on-left">所属分类</label>
              <div class="col-sm-10">
                  <div class="form-group">
                      <input class="form-control" v-model="modal_data.pb_name"  v-focus="modal_data.pb_name"  type="text" placeholder="资讯来源">
                  </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <img class="preview_article_cover" style="width: 200px; height: 120px;" src="">
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Brand',
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
      rows: [],
      attrs: {},
      modal_open: false,
      modal_title: '',
      modal_data: {},
      suppliers: []
    }
  },
  methods: {
    modify: function (id) {
      this.modal_open = true
      if (id === '0') {
        this.modal_title = '新增品牌'
      } else {
        this.modal_title = '编辑品牌'
      }
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('material/brand', {id: id, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_data = d.data
          this.suppliers = d.data.attrs.supplier
        } else {
          this.modal_data = []
        }
        this.modal_open = true
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('material/brand', this.modal_data).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_data = d.data
        }
        this.modal_open = false
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
