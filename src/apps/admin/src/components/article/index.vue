<template>
  <div class="case">
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
            <table class="table table-hover">
              <thead>
                  <tr>
                    <th class="text-left"><small>标题</small></th>
                    <th class="text-center" width="120"><small>状态</small></th>
                    <th class="text-center" width="100"><small>浏览</small></th>
                    <th class="text-center" width="150"><small>发布时间</small></th>
                    <th class="text-center" width="100"></th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.article_id">
                      <td class="text-left">
                        <a @click="modify(v.article_id)" class="text-default">
                          <small class="text-success">「{{v.cat_name}}」</small>{{v.article_title}}
                        </a>
                      </td>
                      <td class="text-center">
                        <small v-if="v.article_status === '2'" class="text-success">发布</small>
                        <small v-if="v.article_status !== '2'" class="text-rose">草稿</small>
                      </td>
                      <td class="text-center">
                        <code>{{v.article_stat_view}}</code>
                      </td>
                      <td class="text-center">
                        <small>{{v.article_udate|time('yyyy-mm-dd HH:MM:ss')}}</small>
                      </td>
                      <td class="text-center">
                          <btn class="btn btn-xs btn-success" @click="modify(v.article_id)"><i class="fa fa-pencil"></i></btn>
                          <btn class="btn btn-xs btn-rose" @click="del(v.article_id)"><i class="fa fa-trash-o"></i></btn>
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
      pn: 1,
      total: 1
    }
  },
  methods: {
    modify (id) {
      this.$router.push({
        path: '/article/add',
        query: {id}
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('article', {pn: this.pn}).then(d => {
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
        this.$http.del('article', {id: id}).then(d => {
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
              dismissible: false,
              cancelText: '取消'
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
