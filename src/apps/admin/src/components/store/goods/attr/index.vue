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
                    <th class="text-left"   width="150"><small>名称</small></th>
                    <th class="text-center" width="100"><small>可筛选</small></th>
                    <th class="text-center" width="100"><small>输入方式</small></th>
                    <th class="text-left" width=""><small>取值</small></th>
                    <th class="text-center" width="60"><small>操作</small></th>
                  </tr>
              </thead>
              <tbody>
                <tr v-for="(v, k) in rows" :key="k">
                  <td class="text-left">
                    <a @click="modify(v.ga_id)"><small>{{v.ga_name}}</small></a>
                  </td>
                  <td>
                    <small>
                      <code v-if="v.ga_type === '2'">规格筛选</code>
                      <span v-if="v.ga_type === '1'" class="">普通属性</span>
                    </small>
                  </td>
                  <td>
                    <small>
                      <code v-if="v.ga_input_type === '2'">选择</code>
                      <span v-if="v.ga_input_type === '1'" class="">输入</span>
                    </small>
                  </td>
                  <td class="text-left"><small>{{v.ga_values.replace(/\s+/g, ', ')}}</small></td>
                  <td>
                    <btn class="btn btn-xs btn-danger" @click="remove(v.ga_id)"><i class="fa fa-trash-o"></i></btn>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </form>
    </div>

    <modal v-model="modalOpen" title="{modal_title}">
      <div slot="title" class="text-left">
        {{modalTitle}}
      </div>
      <div slot="default">
        <form action="" method="post" accept-charset="utf-8">
          <div>
            <div class="row">
                <label class="col-sm-2 label-on-left">名称</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <input class="form-control" v-model="form.ga_name" type="text" placeholder="类型名称">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">筛选</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <select v-model="form.ga_type" class="form-control">
                          <option value="" disabled="">请选择</option>
                          <option v-for="(v, k) in types" v-bind:key="k" :value="k">
                            {{v}}
                          </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">输入方式</label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <select v-model="form.ga_input_type" class="form-control">
                          <option value="" disabled="">请选择</option>
                          <option v-for="(v, k) in input" v-bind:key="k" :value="k">
                            {{v}}
                          </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" v-if="form.ga_input_type === '2'">
                <label class="col-sm-2 label-on-left">可选值</label>
                <div class="col-sm-9">
                    <div class="form-group">
                      <textarea class="form-control" style="height: 120px" v-model="form.ga_values" placeholder="一行一个"></textarea>
                    </div>
                </div>
            </div>
          </div>
        </form>
      </div>
      <div slot="footer">
        <btn type="success" @click="save" class="btn-sm">确认</btn>
      </div>
    </modal>
  </div>
</template>

<script>
export default {
  name: 'StoreGoodsAttrs',
  metaInfo () {
    return {
      title: '属性管理 - 商品类型 - 道达智装'
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
      type: this.$route.query['type'] || 0,
      rows: [],
      form: {},
      input: {},
      filter: {},
      modalOpen: false,
      modalTitle: '',
      types: {}
    }
  },
  methods: {
    // 删除属性
    remove (id) {
      this.$confirm({
        title: '操作提示',
        content: '确认删除该属性?',
        okText: '确认',
        cancelText: '取消'
      }).then(() => {
        this.$loading.show({
          msg: '加载中 ...'
        })
        this.$http.del('store/goods/attr', {id: id}).then(d => {
          this.$loading.hide()
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
      })
    },

    // 编辑
    modify (attrID) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('store/goods/attr', {id: attrID}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = d.data.row || {
            ga_id: 0,
            ga_type_id: this.type,
            ga_type: '',
            ga_input_type: '',
            ga_values: ''
          }
          this.input = d.data.input
          this.types = d.data.type
          this.modalOpen = true
          this.modalTitle = d.data.row ? '编辑属性' : '新增属性'
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

    // 刷新数据
    refresh () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('store/goods/attr', {type: this.type}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.items = [
            {text: '首页', to: '/'},
            {text: '商城', to: '/store'},
            {text: '商品类型', to: '/store/goods/type'},
            {text: d.data.type.gt_name + ' - 属性', href: '#'}
          ]
          this.rows = d.data.list || this.rows
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

    // 保存
    save () {
      this.$http.save('store/goods/attr', this.form).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = {}
          this.modalOpen = false
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
    }

  },
  mounted: function () {
    this.$store.state.left_active_key = '/store'
    if (!/^\d+$/.test(this.type)) {
      this.$alert({
        title: '系统提示',
        content: '未指定的商品类型'
      }, (msg) => {
        this.$router.go(-1)
      })
    }
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
<style scoped>
  .table>tbody>tr>td {
    vertical-align: middle;
  }
</style>
