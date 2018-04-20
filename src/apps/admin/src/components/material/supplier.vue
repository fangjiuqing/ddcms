<template>
  <div class="profile">
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
              <thead class="">
                  <tr>
                    <th class="text-left">名称</th>
                    <th class="text-center" width="150">所在地</th>
                    <th class="text-center" width="150">联系人</th>
                    <th class="text-center" width="150">电话</th>
                    <th class="text-center" width="150">类型</th>
                    <th class="text-center" width="80">操作</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.sup_id">
                      <td class="text-left">
                        <a @click="modify(v.sup_id)">{{v.sup_realname}}</a>
                      </td>
                      <td class="text-center">{{attrs.region[v.sup_region1] ? attrs.region[v.sup_region1]['region_name'] : ''}}</td>
                      <td class="text-center">{{v.sup_contact}}</td>
                      <td class="text-center">{{v.sup_mobile}}</td>
                      <td class="text-center">{{attrs.type[v.sup_type]}}</td>
                      <td class="text-center">
                          <btn class="btn btn-xs btn-rose" @click="del(v.sup_id)"><i class="fa fa-trash-o"></i></btn>
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
        {{modal_title}}
      </div>
      <div slot="default">
        <form action="" method="post" accept-charset="utf-8">
          <div style="padding-right:80px">
            <div class="row">
                <label class="col-sm-2 label-on-left">名称</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <input class="form-control" v-model="modal_data.sup_realname"  v-focus="modal_data.sup_realname"  type="text" placeholder="供应商名称">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">类型</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <select v-model="modal_data.sup_type" class="form-control">
                          <option v-for="(v, k) in attrs.type" v-bind:key="k" :value="k">
                            {{v}}
                          </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">联系人</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <input class="form-control" v-model="modal_data.sup_contact"  v-focus="modal_data.sup_contact"  type="text" placeholder="联系人">
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                    <label class="col-sm-4 label-on-left">电话</label>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <input class="form-control" v-model="modal_data.sup_mobile"  v-focus="modal_data.sup_mobile"  type="text" placeholder="联系电话">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-4 label-on-left">微信</label>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <input class="form-control" v-model="modal_data.sup_wechat"  v-focus="modal_data.sup_wechat"  type="text" placeholder="微信">
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                    <label class="col-sm-4 label-on-left">邮箱</label>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <input class="form-control" v-model="modal_data.sup_email"  v-focus="modal_data.sup_email"  type="text" placeholder="邮箱">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-4 label-on-left">QQ</label>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <input class="form-control" v-model="modal_data.sup_qq"  v-focus="modal_data.sup_qq"  type="text" placeholder="QQ">
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">所在地</label>
                <div class="col-sm-6">
                    <div class="form-group text-left">
                        <v-distpicker :province="modal_data.province" :city="modal_data.city" :area="modal_data.area" @selected="onSelected"></v-distpicker>
                    </div>
                </div>
                <div class="col-sm-4">
                    <input class="form-control" v-model="modal_data.sup_address"  v-focus="modal_data.sup_address"  type="text" placeholder="详细地址">
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">备注</label>
                <div class="col-sm-10">
                    <textarea class="form-control" v-model="modal_data.sup_desc"  v-focus="modal_data.sup_desc"  type="text" placeholder="备注信息"></textarea>
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
  name: 'Supplier',
  metaInfo () {
    return {
      title: '供应商管理 - 道达智装'
    }
  },
  components: { VDistpicker },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '供应商', to: '/material/supplier'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      attrs: {},
      modal_open: false,
      modal_title: '',
      modal_data: {},
      suppliers: [],
      pn: 1,
      total: 1
    }
  },
  methods: {
    onSelected (d) {
      this.modal_data.sup_region0 = d.province.code
      this.modal_data.sup_region1 = d.city.code
      this.modal_data.sup_region2 = d.area.code
    },
    modify: function (id) {
      this.modal_open = true
      if (id === '0') {
        this.modal_title = '新增供应商'
      } else {
        this.modal_title = '编辑供应商'
      }
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('material/supplier', {id: id, attrs: 1}).then(d => {
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
          this.modal_data = []
        }
        this.modal_open = true
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('material/supplier', this.modal_data).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_open = false
          this.refresh()
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
      this.$http.list('material/supplier', {pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.attrs = d.data.attrs
          this.pn = d.data.attrs['paging']['pn'] || 1
          this.total = d.data.attrs['paging']['max'] || 1
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
        this.$http.del('material/supplier', {id: id}).then(d => {
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
    this.$store.state.left_active_key = '/material'
    this.refresh()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/material'
    this.refresh()
  }
}
</script>
