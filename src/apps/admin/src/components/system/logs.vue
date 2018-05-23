<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="content table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th class="text-left" width="18%">时间</th>
                  <th class="text-center" width="15%">IP</th>
                  <th class="text-center" width="15%">操作人</th>
                  <th class="text-center" width="20%">动作</th>
                  <th class="text-left">描述</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(v) in rows" :key="v.al_id">
                  <td class="text-left">
                    <small>{{v.al_adate|time('yyyy-mm-dd HH:MM:ss')}}</small>
                  </td>
                  <td class="text-center">
                    <small>{{v.al_ip}}</small>
                  </td>
                  <td class="text-center">
                    <code>{{v.al_name}}</code>
                  </td>
                  <td class="text-center">
                    <small>{{v.al_url}}</small>
                  </td>
                  <td class="text-left">
                    <small>{{v.al_memo}}</small>
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
  name: 'Logs',
  metaInfo () {
    return {
      title: '资讯管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '系统', to: '/system'},
        {text: '日志', href: '#'}
      ],
      rows: [],
      attrs: {},
      pn: 1,
      total: 12
    }
  },
  methods: {
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('system', {pn: this.pn}).then(d => {
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
    this.$store.state.left_active_key = '/system'
    this.refresh()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/system'
    this.refresh()
  }
}
</script>
