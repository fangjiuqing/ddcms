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
              <thead>
                  <tr>
                    <th class="text-left">名称</th>
                    <th class="text-center" width="120">状态</th>
                    <th class="text-center" width="100">排序</th>
                    <th class="text-center" width="80">操作</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="(v) in rows" :key="v.cat_id">
                      <td class="text-left">
                        <a @click="modify(v.cat_id)"><span :class="v.class"></span>{{v.cat_name}}</a>
                      </td>
                      <td class="text-center"><code><small>{{v.status}}</small></code></td>
                      <td class="text-center">{{v.cat_sort}}</td>
                      <td class="text-center">
                          <btn class="btn btn-xs btn-rose" @click="del(v.cat_id)"><i class="fa fa-trash-o"></i></btn>
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
          <div style="padding-right:30px;">
            <div class="row">
                <label class="col-sm-2 label-on-left">名称</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <input class="form-control" v-model="modal_data.cat_name" type="text" placeholder="分类名称">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">排序</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <input class="form-control" v-model="modal_data.cat_sort" type="text" placeholder="分类排序">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">父级分类</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <select v-model="modal_data.cat_parent" class="form-control">
                          <option v-for="(v) in modal_data.parent_options" v-bind:key="v.cat_id" :value="v.cat_id" v-html="v.space">
                          </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">商品类型</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <select v-model="modal_data.cat_extra" class="form-control">
                          <option value="" disabled="">请选择</option>
                          <option v-for="(v, key) in type" v-bind:key="key" :value="v.gt_id">
                            {{v.gt_name}}
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
  name: 'StoreGoodsCategory',
  metaInfo () {
    return {
      title: '商品分类 - 商城管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '商城', to: '/store'},
        {text: '商品类型', to: '/store/goods/category'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      modal_open: false,
      modal_title: '',
      modal_data: {},
      type: []
    }
  },
  methods: {
    modify: function (id) {
      this.modal_open = true
      if (id === '0') {
        this.modal_title = '新增分类'
      } else {
        this.modal_title = '编辑分类'
      }
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('store/goods/category', {id: id, parent: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_data = d.data || this.modal_data
          this.type = d.data.type || this.type
          this.modal_open = true
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
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('store/goods/category', this.modal_data).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_open = false
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
      this.$http.list('store/goods/category').then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data || []
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
        this.$http.del('goods/store/category', {id: id}).then(d => {
          if (d.code === 0) {
            this.$notify({
              type: 'success',
              content: '删除成功.'
            })
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
