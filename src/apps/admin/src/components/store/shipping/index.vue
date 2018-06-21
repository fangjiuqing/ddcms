<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <router-link :to="{path:'/store/shipping/add'}" class="btn btn-xs btn-info pull-right">
          <i class="fa fa-plus-square"></i> 新增
        </router-link>
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="content table-responsive">
            <table class="table table-hover">
              <thead>
                  <tr>
                    <th class="text-left"><small>配送名称</small></th>
                    <th class="text-left" width="140"><small>配送价格</small></th>
                    <th class="text-left" width="140"><small>免费额度</small></th>
                    <th class="text-center" width="120"><small>操作</small></th>
                  </tr>
              </thead>
              <tbody>
                <tr v-for="(v) in rows" :key="v.shipping_id">
                  <td class="text-left">
                    <a @click="modify(v.shipping_id)">{{v.shipping_name}}</a>
                  </td>
                  <td class="text-left">￥{{v.shipping_price}}</td>
                  <td class="text-left">￥{{v.shipping_free}}</td>
                  <td class="text-center">
                    <btn class="btn btn-xs btn-rose" @click="del(v.shipping_id)" title="删除记录"><i class="fa fa-trash-o"></i></btn>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination v-model="pn" v-if="total > 1" :total-page="total" @change="refresh" size="sm"/>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Shipping',
  metaInfo () {
    return {
      title: '配送管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '商城', to: '/store'},
        {text: '配送管理', to: '/store/shipping'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      total: ''
    }
  },
  methods: {
    modify (id) {
      this.$router.push({
        path: '/store/shipping/add',
        query: {id}
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
        this.$http.del('store/shipping/shipping', {id: id}).then(d => {
          if (d.code === 0) {
            this.$notify({
              type: 'success',
              content: d.msg
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
        this.$notify({
          type: 'info',
          content: '取消删除.'
        })
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('store/shipping/shipping', {pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.pn = d.data.paging.pn
          this.total = d.data.paging.max
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
