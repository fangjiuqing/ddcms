<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <router-link :to="{path:'/store/goods/add'}" class="btn btn-xs btn-info pull-right">
          <i class="fa fa-plus-square"></i> 新增
        </router-link>
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="case-list">
            <div class="media case-row" v-for="(v) in rows" :key="v.mat_id">
              <div class="media-left">
                <img :src="attrs.upload_url + v.mat_cover" alt="" class="case-list-cover">
              </div>
              <div class="media-body">
                <h5>
                  <btn class="btn btn-xs btn-rose pull-right" @click="del(v.mat_id)"><i class="fa fa-trash-o"></i></btn>
                  <a title="编辑材料" @click="modify(v.mat_id)">{{v.mat_name}}</a>
                </h5>
                <p class="text-left">
                  <span>
                    <small>价格 : </small>
                    <code>{{v.mat_min_price}}</code>
                    <small> ~ </small>
                    <code>{{v.mat_min_price}}</code>
                  </span>
                  <span class="separator"></span>
                  <span>
                    <small>库存 : </small> <code>{{v.mat_stocks}}</code>
                  </span>
                </p>
                <p class="text-left">
                  <span>
                    <small>类别/品牌 : </small> <code>{{attrs.cat[v.mat_cat_id]['cat_name']}}</code>
                  </span>
                  <span class="separator"></span>
                  <span>
                    <code>{{attrs.brands[v.mat_brand_id]['pb_name']}}</code>
                  </span>
                </p>
                <p class="text-left">
                  <span>
                    <code>{{attrs.admins[v.mat_buyer_id]['admin_nick']}}</code>
                  </span>
                  <span class="separator"></span>
                  <small>{{v.mat_atime|time('yyyy-mm-dd HH:MM:ss')}}</small>
                </p>
              </div>
            </div>
          </div>
          <pagination v-model="pn" :total-page="total" @change="refresh" size="sm"/>
        </div>
      </form>
    </div>
  </div>
</template>

<script>

export default {
  name: 'StoreGoods',
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
        {text: '列表', href: '#'}
      ],
      rows: [],
      attrs: {},
      pn: 1,
      total: 1
    }
  },
  methods: {
    modify (id) {
      this.$router.push({
        path: '/material/add',
        query: {id}
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('material', {pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.pn = d.data.attrs['paging']['pn'] || 1
          this.total = d.data.attrs['paging']['max'] || 1
          this.attrs = d.data.attrs
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        } else {
          this.rows = []
        }
      })
    },
    del: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$loading.hide()
      this.$confirm({
        title: '操作提示',
        content: '此项将被永久删除。继续?',
        okText: '确认',
        cancelText: '取消'
      }).then(() => {
        this.$http.del('material', {id: id}).then(d => {
          if (d.code === 0) {
            this.$notify({
              type: 'success',
              content: '删除成功.',
              duration: 2000,
              dismissible: false
            })
            this.refresh()
          } else {
            this.$notify({
              content: d.msg,
              duration: 2000,
              type: 'danger',
              dismissible: false
            })
          }
        })
      }).catch(() => {
        this.$notify('取消删除.')
      })
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/store'
    this.refresh()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/store'
    this.refresh()
  }
}
</script>
