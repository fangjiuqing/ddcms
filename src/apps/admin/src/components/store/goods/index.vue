<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <router-link :to="{path:'/store/goods/add'}" class="btn btn-xs btn-info pull-right">
          <i class="fa fa-plus-square"></i> 新增
        </router-link>
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <div class="app_content">
        <div class="row goods-row" v-for="(v) in rows" :key="v.goods_id">
          <div class="col-md-2">
              <img :src="attrs.image_url + v.goods_cover" class="cover">
          </div>
          <div class="col-md-10">
            <h5 class="text-left">
              <btn class="btn btn-xs btn-rose pull-right" @click="del(v.goods_id)"><i class="fa fa-trash-o"></i></btn>
              <btn class="btn btn-xs btn-primary pull-right" @click="config(v.goods_id)" style="margin-right: 7px;"><i class="fa fa-cog"></i></btn>
              <small :class="v.status_class">「 {{v.status}} 」</small>
              <a title="编辑" @click="modify(v.goods_id)" :class="v.status_class">
                {{v.goods_name}}
              </a>
            </h5>
            <div class="row">
              <div class="col-md-4">
                <dl class="dl-horizontal dl-common">
                  <dt><small>类别</small></dt>
                  <dd>
                    <a @click="setFilter('cat', v.goods_cat_id)">
                      <small>{{attrs.categories[v.goods_cat_id]['cat_name']}}</small>
                    </a>
                  </dd>
                  <dt><small>供应商</small></dt>
                  <dd>
                    <a @click="setFilter('supplier', v.goods_supplier_id)" class="common-cutstr">
                      <small>{{attrs.suppliers[v.goods_supplier_id]['sup_realname']}}</small>
                    </a>
                  </dd>
                  <dt><small>规格数</small></dt>
                  <dd>
                    <span class="">{{v.goods_stat_count}}</span>
                    <a class="pull-right" @click="v.spec_show = !v.spec_show">
                      <small class="text-success">{{v.spec_show ? '收起' : '查看'}}</small>
                    </a>
                  </dd>
                </dl>
              </div>
              <div class="col-md-4">
                <dl class="dl-horizontal dl-common">
                  <dt><small>品牌</small></dt>
                  <dd>
                    <a @click="setFilter('brand', v.goods_brand)">
                      <small>{{attrs.brands[v.goods_brand]['pb_name']}}</small>
                    </a>
                  </dd>
                  <dt><small>售价</small></dt>
                  <dd>
                    <span class="text-rose">
                      <small>￥</small>
                      {{v.goods_price}}
                    </span>
                  </dd>
                  <dt><small>库存</small></dt>
                  <dd>
                    <span class="">{{v.goods_stock}}</span>
                    <small>{{v.goods_unit}}</small>
                  </dd>
                </dl>
              </div>
              <div class="col-md-4">
                <dl class="dl-horizontal dl-common">
                  <dt><small>已售出</small></dt>
                  <dd>
                    <span class="">{{v.goods_stat_sale}}</span>
                  </dd>
                  <dt><small>浏览数</small></dt>
                  <dd>
                    <span class="">{{v.goods_stat_view}}</span>
                  </dd>
                  <dt><small>维护人</small></dt>
                  <dd>
                    <a @click="setFilter('admin', v.goods_admin_id)">
                      <small>{{attrs.admins[v.goods_admin_id]['admin_nick']}}</small>
                    </a>
                    <small> ( {{v.goods_udate|time('yy-mm-dd HH:MM')}} )</small>
                  </dd>
                </dl>
              </div>
            </div>
          </div>
          <div class="col-md-12" style="margin-top:15px;">
            <transition name="slide-fade">
              <div v-show="v.spec_show">
                <hr v-if="v.specs">
                <div class="media" v-for="(s, sk) in v.specs" :key="sk">
                  <div class="media-left">
                    <a href="#">
                      <img class="media-object" :src="attrs.image_url + s.gs_cover" style="width: 64px; height: 64px;border-radius: 3px;">
                    </a>
                  </div>
                  <div class="media-body">
                    <h6 class="media-heading text-left">
                      <small :class="s.status_class">「 {{s.status}} 」</small>
                      {{s.attrs.join('  ')}}
                    </h6>
                    <p class="text-left" style="margin-bottom: 3px">
                      <small>售价</small>
                      <span class="text-rose">
                        <small>￥</small>
                        {{s.gs_price}}
                      </span>
                    </p>
                    <p class="text-left">
                      <small>库存</small>
                      <span class="text-info">
                        {{s.gs_stat_sale}} / {{s.gs_stock}}
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </transition>
            <hr >
            <div class="clearfix"></div>
          </div>
        </div>
        <pagination v-model="pn" v-if="total > 1" :total-page="total" @change="refresh" size="sm"/>
      </div>
    </div>

    <modal v-model="modal.open" title="{modal_title}" size="lg">
      <div slot="title" class="text-left">
        {{modal.title}}
      </div>
      <div slot="default">
        <div class="row">
            <label class="col-sm-2 label-on-left">商品名称</label>
            <label class="col-sm-9 label-on-left" style="text-align: left;color: #353535;padding-left: 15px;">
                {{modal.row['goods_name'] || ''}}
            </label>
        </div>
        <div class="row">
            <label class="col-sm-2 label-on-left">状态</label>
            <div class="col-sm-9">
                <div class="form-group">
                    <select v-model="modal.row.goods_status" class="form-control">
                      <option value="" disabled="">请选择</option>
                      <option v-for="(v, k) in status" v-bind:key="k" :value="k">
                        {{v}}
                      </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12"><hr></div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-left" width=""><small>规格名称</small></th>
                  <th class="text-center" width="10%"><small>成本价</small></th>
                  <th class="text-center" width="10%"><small>售价</small></th>
                  <th class="text-center" width="10%"><small>库存</small></th>
                  <th class="text-center" width="10%"><small>状态</small></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(v, k) in modal.row.specs" :key="k">
                  <td class="text-left common-cutstr"><small>{{v.gs_name.join('-')}}</small></td>
                  <td>
                    <input class="form-control-xs" v-model="modal.row.specs[k].gs_price_cost" type="text" placeholder="成本价">
                  </td>
                  <td>
                    <input class="form-control-xs" v-model="modal.row.specs[k].gs_price" type="text" placeholder="售价">
                  </td>
                  <td>
                    <input class="form-control-xs" v-model="modal.row.specs[k].gs_stock" type="text" placeholder="库存">
                  </td>
                  <td>
                    <select v-model="modal.row.specs[k].gs_status" class="form-control-xs">
                      <option value="" disabled="">请选择</option>
                      <option v-for="(sv, sk) in status" :key="sk" :value="sk">
                        {{sv}}
                      </option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div slot="footer">
        <btn type="success" @click="saveConfig" class="btn-sm">确认</btn>
      </div>
    </modal>
  </div>
</template>

<script>

export default {
  name: 'StoreGoods',
  metaInfo () {
    return {
      title: '商品管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '商城', to: '/store'},
        {text: '商品', href: '/store/goods'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      attrs: {},
      pn: 1,
      total: 1,
      modal: {
        open: false,
        title: '快速设置',
        row: {}
      },
      status: {}
    }
  },
  methods: {

    // 编辑记录
    modify (id) {
      this.$router.push({
        path: '/store/goods/add',
        query: {id}
      })
    },

    // 设置过滤条件
    setFilter (key, val) {
      console.log(key, val)
    },

    // 快速设置上下架及价格
    config (goodsId) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('store/goods', {
        id: goodsId,
        action: 'config'
      }).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal.row = d.data.row
          this.status = d.data.status
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        } else {
          this.modal = {
            open: false,
            title: '快速设置',
            row: {}
          }
        }
      })
      this.modal.open = true
    },

    saveConfig () {},

    // 刷新数据
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('store/goods', {pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.rows || null
          this.pn = d.data.attrs['paging']['pn'] || 1
          this.total = d.data.attrs['paging']['max'] || 1
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

    // 删除商品记录
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
        this.$http.del('material', {id: id}).then(d => {
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
    }
  },

  // 挂载完毕
  mounted: function () {
    this.$store.state.left_active_key = '/store'
    this.refresh()
  },

  // 销毁
  destroyed: function () {
    this.$loading.hide()
  },

  // 激活
  activated: function () {
    this.$store.state.left_active_key = '/store'
    this.refresh()
  }
}
</script>
<style scoped>
  .goods-row .cover {
    margin-top: 5px;
    max-width: 110%;
    max-height: 100%;
    border-radius: 3px;
  }
  .goods-row h5 {
    margin-top: 0;
    padding-top: 0;
    line-height: normal;
  }
  .slide-fade-enter-active {
    transition: all .3s ease;
  }
  .slide-fade-leave-active {
    transition: all .1s ease;
  }
  .slide-fade-enter, .slide-fade-leave-to {
    transform: translateX(5px);
    opacity: 0;
  }
  .media {
    border-bottom: 1px dashed #d3d3d3;
    padding-bottom: 15px;
  }
  .media:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }
  .media .media-body {
    border-left: 1px dashed #d3d3d3;
    padding-left: 10px;
  }
</style>
