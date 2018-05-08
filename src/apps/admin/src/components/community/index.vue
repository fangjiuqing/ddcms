<template>
  <div class="community">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}">
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
          <div class="customer-row" v-for="(v) in rows" :key="v.pco_id" style="width:45%;">
            <div class="row">
              <div class="col-md-10">
                <dl class="dl-horizontal dl-common">
                  <dt><small>省</small></dt>
                  <dd><small>{{v.pco_region0_label || 'unknown'}}</small></dd>
                  <dt><small>市</small></dt>
                  <dd><small>{{v.pco_region1_label || 'unknown'}}</small></dd>
                  <dt><small>县/区</small></dt>
                  <dd><span>{{v.pco_region2_label || 'unknown'}}</span></dd>
                  <dt><small>小区</small></dt>
                  <dd><a href="javascript:;" class="text-info" @click="modify(v.pco_id)">{{v.pco_name}}</a></dd>
                  <dt><small>详细地址</small></dt>
                  <dd><span>{{v.pco_addr || '暂无'}}</span></dd>
                </dl>
              </div>
              <div class="col-md-2">
                <btn class="btn btn-xs btn-success" @click="modifi(v.pco_id)"><i class="fa fa-pencil"></i></btn>
                <btn class="btn btn-xs btn-rose" @click="del(v.pco_id)"><i class="fa fa-trash-o"></i></btn>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <pagination v-model="pn" :total-page="total" @change="refresh" size="sm"/>
        </div>
      </form>
    </div>
    <modal v-model="modal_open" title="{modal_title}">
      <div slot="title" class="text-left">
        {{modal_title}}
      </div>
      <div slot="default">
        <form action="" method="post" accept-charset="utf-8">
          <div class="row">
            <label class="col-sm-2 label-on-left">所在地</label>
            <div class="col-sm-10">
              <div class="form-group text-left">
                <v-distpicker :province="modal_data.region0_label" :city="modal_data.region1_label" :area="modal_data.region2_label" @selected="onSelected"></v-distpicker>
              </div>
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 label-on-left">所在小区</label>
            <div class="col-sm-10">
              <input class="form-control" v-model="modal_data.pco_name" type="text" placeholder="所在小区">
            </div>
          </div>
          <div class="row">
            <label class="col-sm-2 label-on-left">详细地址</label>
            <div class="col-sm-10">
              <textarea class="form-control" v-model="modal_data.pco_addr" type="text" placeholder="详细地址"></textarea>
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
  name: 'Community',
  metaInfo () {
    return {
      title: '小区管理 - 道达智装'
    }
  },
  components: { VDistpicker },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '小区管理', to: '/community'},
        {text: '小区', href: '#'}
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
      this.modal_data.pco_region0 = d.province.code
      this.modal_data.pco_region1 = d.city.code
      this.modal_data.pco_region2 = d.area.code
    },
    modifi (id) {
      this.$router.push({
        path: '/community/type',
        query: {id}
      })
    },
    modify: function (id) {
      this.modal_open = true
      if (id === '0') {
        this.modal_title = '新增小区'
      } else {
        this.modal_title = '编辑小区'
      }
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('community', {id: id, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_data = d.data
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        } else {
          this.modal_data = {}
        }
        this.modal_open = true
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('community', this.modal_data).then(d => {
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
      this.$http.list('community', {pn: this.pn}).then(d => {
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
        this.$http.del('customer', {id: id}).then(d => {
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
      }).catch(() => {
        this.$notify('取消删除.')
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
    this.onSelected()
  }
}
</script>
<style scoped>
.distpicker-address-wrapper select {
  max-width: 115px!important;
}
.community {
  background: #fff;
}
.customer-row {
  margin-bottom: 20px;
  border: 1px solid #eee;
  border-radius: 3px;
  border-left: none;
}
.app_content .customer-row:nth-child(2n-1) {
  float: left;
}
.app_content .customer-row:nth-child(2n) {
  float: right;
}
</style>
