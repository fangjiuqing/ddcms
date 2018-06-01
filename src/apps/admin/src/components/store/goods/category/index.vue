<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <a @click="modify('0')" class="btn btn-xs btn-info pull-right">
          <i class="fa fa-plus-square"></i> 新增
        </a>
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="content table-responsive">
            <table class="table table-hover">
              <thead>
                  <tr>
                    <th class="text-left">名称</th>
                    <th class="text-center" width="120">状态</th>
                    <th class="text-center" width="100">排序</th>
                    <th class="text-center" width="80">操作</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.cat_id">
                      <td class="text-left" style="vertical-align: middle;">
                        <a @click="modify(v.cat_id)"><span :class="v.class"></span>{{v.cat_name}}</a>
                      </td>
                      <td class="text-center" style="vertical-align: middle;"><code><small>{{v.status}}</small></code></td>
                      <td class="text-center" style="vertical-align: middle;">{{v.cat_sort}}</td>
                      <td class="text-center" style="vertical-align: middle;">
                          <btn class="btn btn-xs btn-rose" @click="del(v.cat_id)"><i class="fa fa-trash-o"></i></btn>
                      </td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'StoreGoodsCategory',
  metaInfo () {
    return {
      title: '商品分类 - 商城管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '商城', to: '/store'},
        {text: '商品类型', to: '/store/goods/category'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      type: []
    }
  },
  methods: {
    modify: function (id) {
      this.$router.push({
        path: '/store/goods/category/add',
        query: {id}
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('store/goods/category', this.modal_data).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_open = false
          this.refresh()
        } else {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            if (d.code === 9999) {
              this.$router.go(-1)
            }
          })
        }
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('store/goods/category').then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data || []
        } else {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            if (d.code === 9999) {
              this.$router.go(-1)
            }
          })
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
        this.$http.del('store/goods/category', {id: id}).then(d => {
          if (d.code === 0) {
            this.$notify({
              type: 'success',
              content: '删除成功.'
            })
            this.refresh()
          } else {
            this.$alert({
              title: '系统提示',
              content: d.msg
            }, (msg) => {
              if (d.code === 9999) {
                this.$router.go(-1)
              }
            })
          }
        })
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
