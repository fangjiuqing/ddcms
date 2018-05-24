<template>
  <div class="customer">
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
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-left" width="100">广告名称</th>
                  <th class="text-center" width="80">广告状态</th>
                  <th class="text-center" width="100">广告内容</th>
                  <th class="text-center" width="150">添加时间</th>
                  <th class="text-center" width="120">操作</th>
                </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.pc_id">
                    <td class="text-left">
                      <span>{{v.pco_pc_name}}</span>
                    </td>
                    <td class="text-center">
                      <code>{{v.pco_type_name}}</code>
                    </td>
                    <td class="text-center">
                      <small>{{v.pco_admin_name}}</small>
                    </td>
                    <td class="text-center">
                      <small>{{v.pco_atime|time('yyyy-mm-dd HH:MM:ss')}}</small>
                    </td>
                    <td class="text-center">
                      <btn class="btn btn-xs btn-success" @click="modifi(v.pc_id)"><i class="fa fa-pencil"></i></btn>
                    </td>
                  </tr>
              </tbody>
            </table>
            <pagination v-model="pn" :total-page="total" @change="refresh" size="sm"/>
          </div>
        </div>
      </form>
    </div>
    <modal v-model="modal_open" title="{modal_title}">
      <div slot="title" class="text-left">
        {{modal_title}}
      </div>
      <div slot="default">
        <form action="" method="post" accept-charset="utf-8">
          <div style="padding-right:80px;">
            <div class="row">
              <label class="col-sm-3 label-on-left">广告名称</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" v-model="modal_data.pc_sn" type="text" placeholder="广告名称">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 label-on-left">广告状态</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" v-model="modal_data.pc_nick" type="text" placeholder="广告状态">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 label-on-left">广告内容</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" v-model="modal_data.pc_mobile" type="text" placeholder="广告内容">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div slot="footer">
        <btn @click="save" type="success" class="btn-sm">确认</btn>
      </div>
    </modal>
  </div>
</template>

<script>
export default {
  name: 'Advert',
  metaInfo () {
    return {
      title: '客户预约 - 道达智装'
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
      attrs: {},
      modal_open: false,
      modal_title: '',
      modal_data: {}
    }
  },
  methods: {
    onSelected (d) {
      this.modal_data.pc_region0 = d.province.code
      this.modal_data.pc_region1 = d.city.code
      this.modal_data.pc_region2 = d.area.code
    },
    modifi (id) {
      this.$router.push({
        path: '/customer/preview',
        query: {id}
      })
    },
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('customer', {id: id, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_data = d.data
        }
        this.modal_open = true
      })
      if (id === '0') {
        this.modal_title = '新增账号'
        this.modal_data = {}
      } else {
        this.modal_title = '编辑账号'
      }
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('customer', this.modal_data).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_open = false
          this.refresh()
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'success',
            dismissible: false
          })
        } else {
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'danger',
            dismissible: false
          })
        }
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('order', {pn: this.pn}).then(d => {
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
    this.$store.state.left_active_key = '/advert'
    this.refresh()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/advert'
    this.refresh()
    this.onSelected()
  }
}
</script>
<style>
.distpicker-address-wrapper select {
  max-width: 115px!important;
}
.customer {
  background: #fff;
}
</style>
