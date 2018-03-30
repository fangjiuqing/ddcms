<template>
  <div class="customer">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <router-link :to="{path:'/material/add'}" class="btn btn-xs btn-info pull-right">
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
                  <th class="text-left" width="100">客户编号</th>
                  <th class="text-center" width="80">客户姓名</th>
                  <th class="text-center" width="80">电话</th>
                  <th class="text-center" width="80">客户来源</th>
                  <th class="text-center" width="80">客服姓名</th>
                  <th class="text-center" width="300">详细地址</th>
                  <th class="text-center" width="150">小区</th>
                  <th class="text-center" width="80">操作</th>
                </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.article_id">
                    <td class="text-left">
                      <span>{{v.pc_sn}}</span>
                    </td>
                    <td class="text-center">
                      <code>{{v.pc_nick}}</code>
                    </td>
                    <td class="text-center">
                      <small>{{v.pc_mobile}}</small>
                    </td>
                    <td class="text-center">
                      <small>{{v.pc_via}}</small>
                    </td>
                    <td class="text-center">
                      <small>{{v.pc_adm_nick}}</small>
                    </td>
                    <td class="text-center">
                      <small>{{v.pc_region00}} {{v.pc_region10}} {{v.pc_region20}} {{v.pc_addr}}</small>
                    </td>
                    <td class="text-center">
                      <small>{{v.pc_area}}</small>
                    </td>
                    <td class="text-center">
                      <btn class="btn btn-xs btn-success" @click="modify(v.article_id)"><i class="fa fa-pencil"></i></btn>
                      <btn class="btn btn-xs btn-rose" @click="del(v.article_id)"><i class="fa fa-trash-o"></i></btn>
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
  name: 'Customer',
  metaInfo () {
    return {
      title: '材料管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '客户', to: '/customer'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      pn: 1,
      total: 1
    }
  },

  methods: {
    modify (id) {
      this.$router.push({
        path: '/customer',
        query: {id}
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.post('customer/list', {pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.pn = d.data.paging.pn
          this.total = d.data.paging.max
        } else {
          this.rows = []
        }
      })
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/customer'
    this.refresh()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/customer'
    this.refresh()
  }
}
</script>
