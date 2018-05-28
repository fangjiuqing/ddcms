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
                    <th class="text-left"><small>名称</small></th>
                    <th class="text-center" width="300"><small>类型</small></th>
                    <th class="text-center" width="120"><small>操作</small></th>
                  </tr>
              </thead>
              <tbody>
                <tr v-for="(v) in rows" :key="v.gt_id">
                  <td class="text-left">
                    <a @click="modify(v.gt_id)">{{v.gt_name}}</a>
                  </td>
                  <td class="text-center">{{mtype[v.gt_type]}}</td>
                  <td class="text-center">
                    <btn class="btn btn-xs btn-info" @click="attrs(v.gt_id)" title="属性配置"><i class="fa fa-cog"></i></btn>
                    <btn class="btn btn-xs btn-rose" @click="del(v.gt_id)" title="删除记录"><i class="fa fa-trash-o"></i></btn>
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
          <div>
            <div class="row">
                <label class="col-sm-2 label-on-left">名称</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <input class="form-control" v-model="modal_data.gt_name" type="text" placeholder="类型名称">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">类型</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <select v-model="modal_data.gt_type" class="form-control">
                          <option value="" disabled="">请选择</option>
                          <option v-for="(v, k) in mtype" v-bind:key="k" :value="k">
                            {{v}}
                          </option>
                        </select>
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
  name: 'StoreGoodsType',
  metaInfo () {
    return {
      title: '品牌管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '商城', to: '/store'},
        {text: '商品管理', to: '/store/goods'},
        {text: '类型', href: '#'}
      ],
      rows: [],
      modal_open: false,
      modal_title: '',
      modal_data: {
        gt_id: 0,
        gt_type: ''
      },
      mtype: {}
    }
  },
  methods: {
    attrs (id) {
      this.$router.push({
        path: '/store/goods/attr',
        query: {type: id}
      })
    },
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.modal_title = id === '0' ? '新增类型' : '编辑类型'
      this.$http.get('store/goods/type', {id: id}).then(d => {
        if (d.code === 0) {
          this.modal_data = d.data.row || this.modal_data
        } else {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            if (d.code === 9999) {
              this.$router.go(-1)
            }
          })
        }
        this.modal_open = true
        this.$loading.hide()
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('store/goods/type', this.modal_data).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_open = false
          this.modal_data = {
            gt_id: 0,
            gt_type: ''
          }
          this.refresh()
        } else {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            if (d.code === 9999) {
              this.$router.go(-1)
            }
          })
        }
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('store/goods/type').then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.rows || this.rows
          this.mtype = d.data.mtype || this.mtype
        } else {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            if (d.code === 9999) {
              this.$router.go(-1)
            }
          })
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
        this.$http.del('store/goods/type', {id: id}).then(d => {
          if (d.code === 0) {
            this.$notify({
              type: 'success',
              content: '删除成功.',
              duration: 2000,
              dismissible: false
            }, () => {
              this.refresh()
            })
          } else {
            this.$alert({
              title: '系统提示',
              content: d.msg
            }, (msg) => {
              if (d.code === 9999) {
                this.$router.go(-1)
              }
            })
          }
        })
      })
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/store'
    this.refresh()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/store'
    this.refresh()
  }
}
</script>
