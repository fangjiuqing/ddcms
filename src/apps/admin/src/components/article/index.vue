<template>
  <div class="profile">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <router-link :to="{path:'/article/add'}" class="btn btn-xs btn-info pull-right">
          <i class="fa fa-plus-square"></i> 新增
        </router-link>
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="content table-responsive">
            <table class="table table-striped">
              <thead>
                  <tr>
                    <th class="text-left">名称</th>
                    <th class="text-center" width="300">供应商</th>
                    <th class="text-center" width="300">类型</th>
                    <th class="text-center" width="80">操作</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.cat_id">
                      <td class="text-left">
                        <a @click="modify(v.pb_id)">{{v.pb_name}}</a>
                      </td>
                      <td class="text-center">
                        <router-link :to="{path: '/supplier/' + v.pb_sup_id}">{{attrs.supplier[v.pb_sup_id].sup_realname}}</router-link>
                      </td>
                      <td class="text-center">{{attrs.type[v.pb_type]}}</td>
                      <td class="text-center">
                          <btn class="btn btn-xs btn-rose" @click="del(v.pb_id)"><i class="fa fa-trash-o"></i></btn>
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
  name: 'Article',
  metaInfo () {
    return {
      title: '资讯管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '资讯', to: '/article'},
        {text: '列表', href: '#'}
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
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('article').then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.attrs = d.data.attrs
        } else {
          this.rows = []
        }
      })
    },
    del: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.del('article', {id: id}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'success',
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
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/article'
    this.refresh()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/article'
    this.refresh()
  }
}
</script>
