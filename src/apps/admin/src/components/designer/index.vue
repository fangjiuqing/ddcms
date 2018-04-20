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
                    <th class="text-left" width="180"><small>姓名</small></th>
                    <th class="text-center" width="100"><small>职位</small></th>
                    <th class="text-center" width="80"><small>年限</small></th>
                    <th class="text-center" width="100"><small>价格</small></th>
                    <th class="text-center" width="150"><small>地区</small></th>
                    <th class="text-left"><small>风格</small></th>
                    <th class="text-center" width="80"></th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.des_id">
                      <td class="text-left">
                        <a @click="modify(v.des_id)">{{v.des_name}}</a>
                      </td>
                      <td class="text-center">
                        <small>{{v.des_title}}</small>
                      </td>
                      <td class="text-center">
                        <small><b class="text-warning">{{v.des_workyears}}</b></small>
                      </td>
                      <td class="text-center">
                        <small><b class="text-danger">{{v.des_price}}</b> 元/M²</small>
                      </td>
                      <td class="text-center">
                        <small>
                          {{(attrs.region[v.des_region0]).region_name}} - {{(attrs.region[v.des_region1]).region_name}}
                        </small>
                      </td>
                      <td class="text-left">
                        <span v-for="(sv) in v.stags" :key="sv" class="label label-info" style="margin-right:5px;">{{sv}}</span>
                      </td>
                      <td class="text-center">
                          <btn class="btn btn-xs btn-rose" @click="del(v.des_id)"><i class="fa fa-trash-o"></i></btn>
                          <btn class="btn btn-xs btn-info" @click="caseList(v.des_id)"><i class="fa fa-link"></i></btn>
                      </td>
                  </tr>
              </tbody>
            </table>
            <pagination v-model="pn" :total-page="total" @change="refresh" size="sm"/>
          </div>
        </div>
      </form>
    </div>

    <modal v-model="modal_open" title="{modal_title}" size="lg">
      <div slot="title" class="text-left">
        {{modal_title}} <small style="font-weight: 300"> - 代表作设置</small>
      </div>
      <div slot="default">
        <form action="" method="post" accept-charset="utf-8">
          <div style="padding-right:80px;text-align:left">
            <div v-for="(v, k) in cases" :key="k" class="case-row">
              <label style="font-weight: 300;width:100%;cursor:pointer">
                <input type="checkbox" v-model="cases[k]['case_is_primary']"> &nbsp;{{v.case_title}}
              </label>
            </div>
          </div>
        </form>
      </div>
      <div slot="footer">
        <btn @click="caseSet" type="success" class="btn-sm">确认</btn>
      </div>
    </modal>
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
      total: 1,
      modal_open: false,
      modal_title: '',
      cases: {}
    }
  },
  methods: {
    caseSet () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.set('designer/case', {
        'rows': this.cases
      }).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_open = false
          this.cases = {}
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        }
      })
    },
    caseList (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('designer/case', {id}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_title = d.data.des['des_name']
          this.modal_open = true
          this.cases = d.data.list
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        }
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

<style scoped>
  .case-row {
    display: inline-block;
    width: 30%;
    margin-right: 1%;
  }
</style>
