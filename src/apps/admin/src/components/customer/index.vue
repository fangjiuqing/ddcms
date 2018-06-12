<template>
  <div class="customer">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <a @click="modifi('0')" class="btn btn-xs btn-info pull-right">
          <i class="fa fa-plus-square"></i> 新增
        </a>
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="customer-row" v-for="(v) in rows" :key="v.pc_id">
            <div class="row">
              <div class="col-md-4">
                <dl class="dl-horizontal dl-common">
                  <dt><small>姓名</small></dt>
                  <dd>
                    <span class="text-rose">{{v.pc_nick}}</span>
                    <span v-if="v.gender"><span class="separator"></span> <small>{{v.gender}}</small></span>
                  </dd>
                  <dt><small>编号</small></dt>
                  <dd><span>{{v.pc_sn}}</span></dd>
                  <dt><small>来源</small></dt>
                  <dd><small class="text-default">{{v.via}}</small></dd>
                  <dt><small>入库时间</small></dt>
                  <dd><small>{{v.pc_atime|time('yyyy-mm-dd HH:MM')}}</small></dd>
                  <dt><small>最近更新</small></dt>
                  <dd><small>{{v.pc_utime|time('yyyy-mm-dd HH:MM')}}</small></dd>
                </dl>
              </div>
              <div class="col-md-4">
                <dl class="dl-horizontal dl-common">
                  <dt><small>状态</small></dt>
                  <dd><small :class="v.status_style">{{v.status}}</small></dd>
                  <dt><small>电话</small></dt>
                  <dd><span>{{v.pc_mobile}}</span></dd>
                  <dt><small>地区</small></dt>
                  <dd><small class="">{{v.pc_region0_label || 'unknown'}} {{v.pc_region1_label}}</small></dd>
                  <dt><small>地址</small></dt>
                  <dd><small>{{v.pc_region2_label || 'unknown'}}</small></dd>
                  <dt><small>小区</small></dt>
                  <dd><small>{{v.pc_area}}</small></dd>
                </dl>
              </div>
              <div class="col-md-4">
                <dl class="dl-horizontal dl-common">
                  <dt><small>电话</small></dt>
                  <dd><span>{{v.pc_mobile}}</span></dd>
                  <dt><small>地区</small></dt>
                  <dd><small class="">{{v.pc_region0_label || 'unknown'}} {{v.pc_region1_label}}</small></dd>
                  <dt><small>地址</small></dt>
                  <dd><small>{{v.pc_region2_label || 'unknown'}}</small></dd>
                  <dt><small>小区</small></dt>
                  <dd><small>{{v.pc_area}}</small></dd>
                  <dt><small></small></dt>
                  <dd>
                    <div class="text-right">
                      <btn class="btn btn-xs btn-success" @click="modifi(v.pc_id)"><i class="fa fa-pencil"></i> 编辑</btn>
                      <btn class="btn btn-xs btn-warning" @click="modifi(v.pc_id)"><i class="fa fa-sticky-note-o"></i> 方案</btn>
                      <btn class="btn btn-xs btn-rose" @click="del(v.pc_id)"><i class="fa fa-trash-o"></i> 删除</btn>
                    </div>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <pagination v-model="pn" v-if="total > 1" :total-page="total" @change="refresh" size="sm"/>
        </div>
      </form>
    </div>
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
      form: {},
      rows: [],
      pn: 1,
      total: 1,
      attrs: {}
    }
  },
  methods: {
    onSelected (d) {
      this.form.pc_region0 = d.province.code
      this.form.pc_region1 = d.city.code
      this.form.pc_region2 = d.area.code
    },
    modifi (id) {
      this.$router.push({
        path: '/customer/add',
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
          this.form = d.data
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('customer', this.form).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
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
          this.rows = {}
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
<style scoped>
.distpicker-address-wrapper select {
  max-width: 115px!important;
}
.customer-row {
  margin-bottom: 20px;
  border: 1px solid #eee;
  border-radius: 3px;
  border-left: none;
}
</style>
