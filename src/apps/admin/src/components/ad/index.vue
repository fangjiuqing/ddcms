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
            <table class="table">
              <thead>
                <tr>
                  <th class="text-left" width="25%">广告名称</th>
                  <th class="text-left" width="30%">链接</th>
                  <th class="text-left" width="5%">广告状态</th>
                  <th class="text-left" width="15%">添加时间</th>
                  <th class="text-left" width="5%">操作</th>
                </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.ad_id">
                    <td class="text-left">
                      <a @click="modify(v.ad_id)" class="text-default">
                        <span>{{v.ad_name}}</span>
                      </a>
                    </td>
                    <td class="text-left">
                      <code class="text-info">{{v.ad_url}}</code>
                    </td>
                    <td class="text-left">
                      <small :class="v.ad_status_style">{{v.ad_status}}</small>
                    </td>
                    <td class="text-left">
                      <small>{{v.ad_adate|time('yyyy-mm-dd HH:MM')}}</small>
                    </td>
                    <td class="text-left">
                      <btn class="btn btn-xs btn-rose" @click="del(v.ad_id)"><i class="fa fa-trash-o"></i></btn>
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
  name: 'Advert',
  metaInfo () {
    return {
      title: '广告管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '广告', to: '/advert'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      pn: 1,
      total: 1,
      attrs: {}
    }
  },
  methods: {
    modify (id) {
      this.$router.push({
        path: '/advert/add',
        query: {id}
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('advert', {pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.pn = d.data.paging.pn
          this.total = d.data.paging.max
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
        this.$http.del('advert', {id: id}).then(d => {
          if (d.code === 0) {
            this.$notify({
              type: 'success',
              content: '删除成功.'
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
