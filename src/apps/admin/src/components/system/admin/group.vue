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
                  <th class="text-center" width="120">名称</th>
                  <th class="text-center" width="">权限</th>
                  <th class="text-center" width="40"></th>
                </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.pc_id">
                    <td class="text-center">
                      <a href="javascript:;" @click="modify(v.pag_id)"><code>{{v.pag_name}}</code></a>
                    </td>
                    <td class="text-left">
                      <small>{{v.desc}}</small>
                    </td>
                    <td class="text-center">
                      <btn class="btn btn-xs btn-rose" @click="del(v.pag_id)"><i class="fa fa-trash-o"></i></btn>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
      </form>
    </div>
    <modal v-model="modal_open" title="{modal_title}" size="lg">
      <div slot="title" class="text-left">
        {{modal_title}}
      </div>
      <div slot="default">
        <form action="" method="post" accept-charset="utf-8">
          <div style="padding-right:0px;">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <input class="form-control" v-model="modal_data.pag_name" v-focus="modal_data.pag_name" type="text" placeholder="请输入权限组名称">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div v-for="(item, key) in modal_data.rules" :key="key" class="items text-left">
                  <h6>{{item.name}}</h6>
                  <span v-for="(act, akey) in item.actions" :key="akey">
                    <label class="item-checbox">
                      <input type="checkbox" v-model="modal_data.details[akey]" :value="1"> {{act}}
                    </label>
                  </span>
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
  name: 'Group',
  metaInfo () {
    return {
      title: '管理权限 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '管理', to: '/system/group'},
        {text: '权限', href: '#'}
      ],
      rows: [],
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
    modify: function (id) {
      this.modal_open = true
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('system/admin/group', {id: id}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_data = d.data
          this.modal_data.details = this.modal_data.details || {}
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
      this.$http.save('system/admin/group', {
        pag_id: this.modal_data['pag_id'] || 0,
        pag_name: this.modal_data.pag_name,
        details: this.modal_data.details
      }).then(d => {
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
      this.$http.list('system/admin/group', {pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
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
        title: 'Confirm',
        content: '此项将被永久删除。继续?'
      }).then(() => {
        this.$http.del('system/admin/group', {id: id}).then(d => {
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
<style scoped>
  .app_content {
    background: #fff;
  }
  h6 {
    font-size: 13px;
    font-weight: 300;
    color: #666;
  }
  .items {
    margin-bottom: 10px;
    background: #f5f5f5;
    padding: 5px 15px 15px 15px;
    border-radius: 3px;
  }
  .item-checbox {
    font-weight: normal;
    font-size: 13px;
    display: inline-block;
    margin-right: 15px;
    color: #555;
    cursor: pointer;
  }
</style>
