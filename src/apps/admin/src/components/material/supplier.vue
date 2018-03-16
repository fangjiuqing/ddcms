<template>
  <div class="profile">
    <breadcrumbs :items="items"/>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="content table-responsive">
            <h4 class="card-title">
              <btn class="btn btn-xs btn-success pull-right" @click="modify('0')">
                <i class="fa fa-plus-square"></i> 新增
              </btn>
            </h4>
            <table class="table table-striped">
              <thead class="text-primary">
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
                <label class="col-sm-3 label-on-left">名称</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <input class="form-control" v-model="modal_data.sup_realname"  v-focus="modal_data.sup_realname"  type="text" placeholder="供应商名称">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 label-on-left">类型</label>
                <div class="col-sm-9">
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
                <label class="col-sm-3 label-on-left">联系人</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <input class="form-control" v-model="modal_data.sup_contact"  v-focus="modal_data.sup_contact"  type="text" placeholder="联系人">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 label-on-left">联系电话</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <input class="form-control" v-model="modal_data.sup_mobile"  v-focus="modal_data.sup_mobile"  type="text" placeholder="联系电话">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 label-on-left">所在地</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <v-distpicker></v-distpicker>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 label-on-left">详细地址</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <input class="form-control" v-model="modal_data.sup_address"  v-focus="modal_data.sup_address"  type="text" placeholder="详细地址">
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
      suppliers: []
    }
  },
  methods: {
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
      this.$http.list('material/supplier').then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.attrs = d.data.attrs
        } else {
          this.rows = []
        }
      })
    },
    del: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.del('material/supplier', {id: id}).then(d => {
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
