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
                  <tr v-for="(v) in rows" :key="v.pc_id">
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
                      <small>{{v.pc_region0_label}} {{v.pc_region1_label}} {{v.pc_region2_label}} {{v.pc_addr}}</small>
                    </td>
                    <td class="text-center">
                      <small>{{v.pc_area}}</small>
                    </td>
                    <td class="text-center">
                      <btn class="btn btn-xs btn-success" @click="modify(v.pc_id)"><i class="fa fa-pencil"></i></btn>
                      <btn class="btn btn-xs btn-rose" @click="del(v.pc_id)"><i class="fa fa-trash-o"></i></btn>
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
              <label class="col-sm-3 label-on-left">客户编号</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" v-model="modal_data.pc_sn"  v-focus="modal_data.pc_sn" type="text" placeholder="客户编号">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 label-on-left">客户姓名</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" v-model="modal_data.pc_nick"  v-focus="modal_data.pc_nick" type="text" placeholder="客户姓名">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 label-on-left">电话</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" v-model="modal_data.pc_mobile"  v-focus="modal_data.pc_mobile"  type="text" placeholder="联系电话">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 label-on-left">所在地</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <v-distpicker :province="modal_data.pc_region0_label" :city="modal_data.pc_region1_label" :area="modal_data.pc_region2_label" @selected="onSelected"></v-distpicker>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 label-on-left">详细地址</label>
              <div class="col-sm-9">
                <input class="form-control" v-model="modal_data.pc_addr"  v-focus="modal_data.pc_addr"  type="text" placeholder="详细地址">
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 label-on-left">小区</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" v-model="modal_data.pc_co_id"  v-focus="modal_data.pc_co_id"  type="text" placeholder="小区">
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
import VDistpicker from 'v-distpicker'
export default {
  name: 'Customer',
  metaInfo () {
    return {
      title: '客户列表 - 道达智装'
    }
  },
  components: { VDistpicker },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '客户', to: '/customer'},
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
      this.modal_data.pc_region0_label = d.province.value
      this.modal_data.pc_region1_label = d.city.value
      this.modal_data.pc_region2_label = d.area.value
    },
    modify: function (id) {
      this.modal_open = true
      if (id === '0') {
        this.modal_title = '新增客户'
      } else {
        this.modal_title = '编辑客户'
      }
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('customer', {id: id, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_data = d.data
        } else {
          this.modal_data = []
        }
        this.modal_open = true
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('customer', this.modal_data).then(d => {
        console.log(this.modal_data)
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
      this.$http.list('customer', {pn: this.pn}).then(d => {
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
      this.$http.del('customer', {id: id}).then(d => {
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
    this.$store.state.left_active_key = '/customer'
    this.refresh()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/customer'
    this.refresh()
    this.onSelected()
  }
}
</script>
<style>
.distpicker-address-wrapper select {
  max-width: 115px!important;
}
</style>
