<template>
  <div class="case">
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
                    <th class="text-left">名称</th>
                    <th class="text-center" width="300">供应商</th>
                    <th class="text-center" width="300">类型</th>
                    <th class="text-center" width="80">操作</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.cat_id">
                      <td class="text-left">
                        <a @click="modify(v.pb_id)">{{v.pb_name}}</a>
                      </td>
                      <td class="text-center">
                        <router-link :to="{path: '/supplier/' + v.pb_sup_id}">{{attrs.supplier[v.pb_sup_id].sup_realname}}</router-link>
                      </td>
                      <td class="text-center">{{attrs.type[v.pb_type]}}</td>
                      <td class="text-center">
                          <btn class="btn btn-xs btn-rose" @click="del(v.pb_id)"><i class="fa fa-trash-o"></i></btn>
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
        <div style="padding-right:30px;">
          <div class="row">
              <label class="col-sm-3 label-on-left">名称</label>
              <div class="col-sm-9">
                  <div class="form-group">
                      <input class="form-control" v-model="modal_data.pb_name" type="text" placeholder="品牌名称">
                  </div>
              </div>
          </div>
          <div class="row">
              <label class="col-sm-3 label-on-left">类型</label>
              <div class="col-sm-9">
                  <div class="form-group">
                      <select v-model="modal_data.pb_type" class="form-control">
                        <option v-for="(v, k) in attrs.type" v-bind:key="k" :value="k">
                          {{v}}
                        </option>
                      </select>
                  </div>
              </div>
          </div>
          <div class="row">
            <label class="col-sm-3 label-on-left">所属供应商</label>
            <div class="col-sm-9  input-label">
              <input id="input-5" class="form-control" type="text" placeholder="所属供应商">
              <typeahead v-model="modal_data.pb_sup_id" target="#input-5" :async-function="querySupplier" item-key="sup_realname" />
            </div>
          </div>
        </div>
      </div>
      <div slot="footer">
        <btn @click="save" type="success" class="btn-sm">确认</btn>
      </div>
    </modal>
  </div>
</template>

<script>
export default {
  name: 'Brand',
  metaInfo () {
    return {
      title: '品牌管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '品牌', to: '/material/brand'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      attrs: {},
      modal_open: false,
      modal_title: '',
      modal_data: {
        pb_sup_id: {}
      },
      suppliers: []
    }
  },
  methods: {
    // 搜搜供应商
    querySupplier (query, done) {
      this.$http.list('store/supplier', {key: query}).then(d => {
        if (d.code === 0) {
          done(d.data.list)
        }
      })
    },
    modify: function (id) {
      this.modal_open = true
      if (id === '0') {
        this.modal_title = '新增品牌'
      } else {
        this.modal_title = '编辑品牌'
      }
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('material/brand', {id: id}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_data = d.data.row || {pb_sup_id: null}
        } else {
          this.modal_data = {pb_sup_id: null}
        }
        this.modal_open = true
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('material/brand', this.modal_data).then(d => {
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
        this.modal_open = false
        this.refresh()
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('material/brand').then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
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
      this.$loading.hide()
      this.$confirm({
        title: '操作提示',
        content: '此项将被永久删除。继续?',
        okText: '确认',
        cancelText: '取消'
      }).then(() => {
        this.$http.del('material/brand', {id: id}).then(d => {
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
