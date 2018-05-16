<template>
  <div class="user">
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
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center" width="120">姓名</th>
                  <th class="text-center" width="150">管理员类型</th>
                  <th class="text-center" width="">账号</th>
                  <th class="text-center" width="150">手机</th>
                  <th class="text-center" width="150">邮箱</th>
                  <th class="text-center" width="150">微信</th>
                  <th class="text-center" width="150">最近登录</th>
                  <th class="text-center" width="40"></th>
                </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.pc_id">
                    <td class="text-center">
                      <a href="javascript:;" @click="modify(v.admin_id)"><span>{{v.admin_nick}}</span></a>
                    </td>
                    <td class="text-center">
                      <small>{{v.admin_group_name}}</small>
                    </td>
                    <td class="text-center">
                      <code>{{v.admin_account}}</code>
                    </td>
                    <td class="text-center">
                      <small>{{v.admin_mobile}}</small>
                    </td>
                    <td class="text-center">
                      <small>{{v.admin_email}}</small>
                    </td>
                    <td class="text-center">
                      <small>{{v.admin_wechat}}</small>
                    </td>
                    <td class="text-center">
                      <small>{{v.admin_date_login|time('yyyy-mm-dd HH:MM:ss')}}</small>
                    </td>
                    <td class="text-center">
                      <btn class="btn btn-xs btn-rose" @click="del(v.admin_id)"><i class="fa fa-trash-o"></i></btn>
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
              <label class="col-sm-3 label-on-left">真实姓名</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" v-model="modal_data.admin_nick" type="text" placeholder="请输入您的真实姓名">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 label-on-left">管理员</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control" v-model="modal_data.admin_group_id" v-focus="modal_data.admin_group_id">
                    <option v-for="g in group" :key="g.pag_id" :value="g.pag_id">{{g.pag_name}}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 label-on-left">登录账号</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" v-model="modal_data.admin_account" type="text" placeholder="请输入您的账号">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 label-on-left">手机号码</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <input class="form-control" v-model="modal_data.admin_mobile"  type="text" placeholder="联系电话">
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
  name: 'Manager',
  metaInfo () {
    return {
      title: '管理账号 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '管理', to: '/system/admin'},
        {text: '账号', href: '#'}
      ],
      rows: [],
      pn: 1,
      total: 1,
      attrs: {},
      modal_open: false,
      modal_title: '',
      modal_data: {},
      group: []
    }
  },
  methods: {
    onSelected (d) {
      this.modal_data.pc_region0 = d.province.code
      this.modal_data.pc_region1 = d.city.code
      this.modal_data.pc_region2 = d.area.code
    },
    modify: function (id) {
      this.modal_open = true
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('system/admin', {id: id, attrs: 1}).then(d => {
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
        }
        this.modal_open = true
      })
      this.$http.list('system/admin/group', this.group).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.group = d.data.list
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        }
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
      this.$http.save('system/admin', this.modal_data).then(d => {
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
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
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
      this.$http.list('system/admin', {pn: this.pn}).then(d => {
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
        this.$http.del('system/admin', {id: id}).then(d => {
          if (d.code === 0) {
            this.$notify({
              type: 'success',
              content: '删除成功.',
              duration: 2000,
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
      }).catch(() => {
        this.$notify('取消删除.')
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
    this.onSelected()
  }
}
</script>
<style>
.distpicker-address-wrapper select {
  max-width: 115px!important;
}
.user {
  background: #fff;
}
</style>
