<template>
  <div class="profile">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <router-link :to="{path:'/designer/add'}" class="btn btn-xs btn-info pull-right">
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
                    <th class="text-left" width="80">姓名</th>
                    <th class="text-left" width="80">职位</th>
                    <th class="text-center" width="60">工作年限</th>
                    <th class="text-center" width="100">设计价格</th>
                    <th class="text-left" width="100">所在地区</th>
                    <th class="text-left" width="200">风格标签</th>
                    <th class="text-center" width="100"></th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.des_id">
                      <td class="text-left">
                        <a @click="modify(v.des_id)">{{v.des_name}}</a>
                      </td>
                      <td class="text-left">
                        {{v.des_title}}
                      </td>
                      <td class="text-center">
                        <b class="text-warning">{{v.des_workyears}}</b>
                      </td>
                      <td class="text-center">
                        <b class="text-danger">{{v.des_price}}</b>元/M²
                      </td>
                      <td class="text-left">
                        <small>{{(attrs.region[v.des_region0]).region_name}} - {{(attrs.region[v.des_region1]).region_name}}</small>
                      </td>
                      <td class="text-left">
                        <span v-for="(sv) in v.stags" :key="sv" class="label label-info" style="margin-right:5px;">{{sv}}</span>
                      </td>
                      <td class="text-center">
                          <btn class="btn btn-xs btn-success" @click="modify(v.des_id)"><i class="fa fa-pencil"></i></btn>
                          <btn class="btn btn-xs btn-rose" @click="del(v.des_id)"><i class="fa fa-trash-o"></i></btn>
                          <btn class="btn btn-xs btn-info" @click="caselist(v.des_id)"><i class="fa fa-link"></i></btn>
                      </td>
                  </tr>
              </tbody>
            </table>
            <pagination v-model="pn" :total-page="total" @change="refresh" size="sm"/>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>

export default {
  name: 'designer',
  metaInfo () {
    return {
      title: '设计师管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '设计师', to: '/designer'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      attrs: {},
      pn: 1,
      total: 1
    }
  },
  methods: {
    caselist (desid) {
      this.$router.push({
        path: '/case',
        query: {desid}
      })
    },
    modify (id) {
      this.$router.push({
        path: '/designer/add',
        query: {id}
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('designer', {pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.pn = d.data.paging.pn
          this.total = d.data.paging.max
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
      this.$http.del('designer', {id: id}).then(d => {
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
    this.$store.state.left_active_key = '/operate'
    this.refresh()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/operate'
    this.refresh()
  }
}
</script>
