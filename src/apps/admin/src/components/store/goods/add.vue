<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" :key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="" method="post" accept-charset="utf-8">
        <div class="form-block">
          <div class="row">
            <div class="col-md-12">
              <h5 class="block-h5">基本信息</h5>
            </div>
            <div class="col-md-8">
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">商品名称</label>
                <div class="col-sm-10 input-label">
                  <input class="form-control" name="goods_name" v-model="form.goods_name" type="text" placeholder="商品名称">
                </div>
              </div>
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">商品编号</label>
                <div class="col-sm-10 input-label">
                  <input class="form-control" name="goods_sn" v-model="form.goods_sn" type="text" placeholder="商品编号">
                </div>
              </div>
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">所属分类</label>
                <div class="col-sm-10 input-label">
                  <select v-model="form.goods_cat_id"  name="goods_cat_id" class="form-control">
                    <option disabled value="">请选择所属分类</option>
                    <option v-for="(v) in categories" :key="v.cat_id" :value="v.cat_id" v-html="v.space">
                    </option>
                  </select>
                </div>
              </div>
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">上下架</label>
                <div class="col-sm-10 input-label">
                  <select v-model="form.goods_status"  name="goods_brand" class="form-control">
                    <option disabled value="">请选择售卖状态</option>
                    <option v-for="(v, k) in goodsStatus" :key="k" :value="k">
                      {{v}}
                    </option>
                  </select>
                </div>
              </div>
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">所属品牌</label>
                <div class="col-sm-10 input-label">
                  <select v-model="form.goods_brand"  name="goods_brand" class="form-control">
                    <option disabled value="">请选择所属品牌</option>
                    <option v-for="(v) in brands" :key="v.pb_id" :value="v.pb_id">
                      {{v.pb_name}}
                    </option>
                  </select>
                </div>
              </div>
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">所属供应商</label>
                <div class="col-sm-10 input-label">
                  <input id="input-5" class="form-control" type="text" placeholder="所属供应商">
                  <typeahead v-model="form.goods_supplier_id" target="#input-5" :async-function="querySupplier" item-key="sup_realname" />
                </div>
              </div>
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">商品单位</label>
                <div class="col-sm-10 input-label">
                  <input class="form-control" name="goods_unit" v-model="form.goods_unit" type="text" placeholder="商品单位">
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <img class="preview_cover" style="width:240px;height:240px;" :src="form.goods_cover_url || cover" @click="upload_cover">
              <input type="hidden" name="mat_cover" v-model="form.goods_cover">
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
        <div class="form-block">
          <div class="row">
            <div class="col-md-12">
              <h5 class="block-h5">规格属性</h5>
            </div>
            <div class="col-md-9">
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">商品类型</label>
                <div class="col-sm-10 input-label">
                  <select v-model="form.goods_type_id" @change="selectGoodsType" class="form-control">
                    <option disabled value="">请选择商品类型</option>
                    <option v-for="(v, k) in goodsTypes" :key="k" :value="k">
                      {{v.gt_name}}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-block" v-show="hasBaseAttrs">
          <div class="row">
            <div class="col-md-12">
              <h5 class="block-h5">商品属性</h5>
            </div>
            <div class="col-md-9">
              <div class="row form-input-row" v-for="(v, k) in baseAttrs" :key="k">
                <label class="col-sm-2 field-label">{{v.name}}</label>
                <div class="col-sm-10 input-label">
                  <select v-model="baseAttrs[k]['value']" v-if="v.input_type === 'select'" class="form-control">
                    <option disabled value="">请选择{{v.name}}</option>
                    <option v-for="(opt, optKey) in v.values" :key="optKey" :value="opt">
                      {{opt}}
                    </option>
                  </select>
                  <input class="form-control" v-if="v.input_type === 'input'" v-model="baseAttrs[k]['value']" type="text" placeholder="请输入">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-block" v-show="hasFilterAttrs">
          <div class="row">
            <div class="col-md-12">
              <h5 class="block-h5">商品规格
                <btn class="btn btn-xs btn-info pull-right" @click="addGoodsSpecRow">添加</btn>
                <div class="clearfix"></div>
              </h5>
            </div>
            <div class="col-md-12">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="text-center" :width="filterAttrs[v]['width'] || ''" v-for="(v, k) in sortFilterAttrs" v-if="filterAttrs[v].input_type !== 'none'" :key="k">{{filterAttrs[v].name}}</th>
                    <th width="80"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(gsv, gsk) in goodsSpecs" :key="gsk">
                    <td v-for="(v, k) in Object.keys(gsv).sort()" :key="k" class="text-center" style="vertical-align: middle;" v-if="filterAttrs[v].input_type !== 'none'">
                      <select v-model="goodsSpecs[gsk][v]" v-if="filterAttrs[v].input_type === 'select'" class="form-control-xs">
                        <option disabled value="">请选择{{filterAttrs[v].name}}</option>
                        <option v-for="(opt, optKey) in filterAttrs[v].values" :key="optKey" :value="opt">
                          {{opt}}
                        </option>
                      </select>
                      <input class="form-control-xs" v-if="filterAttrs[v].input_type === 'input'" v-model="goodsSpecs[gsk][v]" type="text" :placeholder="filterAttrs[v].name">
                      <div v-if="filterAttrs[v].input_type === 'image'">
                        <img class="preview_cover" style="width: 100px; height: 100px;" :src="goodsSpecs[gsk][v + '_url'] || cover" @click="uploadGoodsCover(gsk, v)">
                      </div>
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                      <btn class="btn btn-xs btn-danger" @click="rmGoodsSpec(gsk)">
                        <i class="fa fa-trash-o"></i>
                      </btn>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="form-block">
          <div class="col-md-12">
              <h5 class="block-h5">商品描述
                <div class="clearfix"></div>
              </h5>
            </div>
          <div class="row">
            <div class="col-md-12" style="padding-top: 15px;">
              <vue-editor ref="editor" id="editor"
                useCustomImageHandler
                @imageAdded="uploadEditorImage" v-model="form.goods_desc">
              </vue-editor>
            </div>
          </div>
        </div>
        <div class="form-block">
          <div class="row">
            <div class="col-md-12" style="margin:15px auto; float: none">
              <btn type="success" @click="save" class="btn btn-success pull-right">保存</btn>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {VueEditor} from 'vue2-editor'
export default {
  name: 'StoreGoodsAdd',
  components: {VueEditor},
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
        {text: '商品', to: '/store/goods'},
        {text: '编辑', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      cover: require('@/assets/images/default_1x1.jpg'),
      form: {
        goods_brand: '',
        goods_cat_id: '',
        goods_type_id: '',
        goods_status: ''
      },
      brands: {},
      categories: {},
      goodsTypes: {},
      baseAttrs: {},
      hasBaseAttrs: false,
      filterAttrs: {},
      hasFilterAttrs: false,
      goodsSpecs: {},
      curGoodsSpecKey: null,
      goodsStatus: {},
      specStatus: {}
    }
  },

  // computed
  computed: {
    sortFilterAttrs () {
      return Object.keys(this.filterAttrs).sort()
    }
  },

  // 方法
  methods: {
    // 上传商品封面图片
    uploadGoodsCover (parentKey, key) {
      this.curGoodsSpecKey = {
        parentKey, key
      }
      this.$uploader.select({
        uri: 'upload/image',
        el: this,
        pre: 'cover'
      })
    },

    // 删除列
    rmGoodsSpec (key) {
      this.$confirm({
        title: '操作提示',
        content: '确认删除该种商品?',
        okText: '确认',
        cancelText: '取消'
      }).then(() => {
        this.$delete(this.$data.goodsSpecs, key)
      })
    },

    // 选择商品类型
    selectGoodsType () {
      let attrs = this.goodsTypes[this.form.goods_type_id].attrs
      this.filterAttrs = {
        'id': {
          name: '编号',
          value: 0,
          input_type: 'none'
        },
        'sale': {
          name: '售出数',
          value: 0,
          input_type: 'none'
        },
        '0cover': {
          name: '封面',
          value: '',
          input_type: 'image',
          width: '100'
        },
        '0cover_url': {
          name: '预览图',
          value: '',
          input_type: 'none',
          width: '100'
        },
        'status': {
          name: '状态',
          value: '',
          input_type: 'select',
          width: '100',
          values: this.specStatus
        },
        'sn': {
          name: '编号',
          value: '',
          input_type: 'input',
          width: '200'
        }
      }
      this.baseAttrs = {}
      this.titles = {}
      for (let k of Object.keys(attrs)) {
        if (attrs[k]['type'] === '1') {
          this.baseAttrs[k] = attrs[k]
        } else {
          this.filterAttrs[k] = attrs[k]
        }
      }

      this.hasBaseAttrs = Object.keys(this.baseAttrs).length > 0
      this.hasFilterAttrs = Object.keys(this.filterAttrs).length > 4
      if (this.hasFilterAttrs) {
        this.filterAttrs['stocks'] = {
          name: '库存',
          value: '',
          input_type: 'input',
          width: '90'
        }
        this.filterAttrs['price_cost'] = {
          name: '成本价',
          value: '',
          input_type: 'input',
          width: '90'
        }
        this.filterAttrs['price_sale'] = {
          name: '售价',
          value: '',
          input_type: 'input',
          width: '90'
        }
        this.goodsSpecs = {}
        this.addGoodsSpecRow()
      }
    },

    initGoodsSpec () {
      // a
    },

    // 初始化商品规格
    addGoodsSpecRow () {
      let item = {}
      for (let k of Object.keys(this.filterAttrs).sort()) {
        item[k] = ''
      }
      console.log(item)
      this.$set(this.$data.goodsSpecs, this.$util.rand_str(16), item)
    },

    // 搜搜供应商
    querySupplier (query, done) {
      this.$http.list('store/supplier', {key: query}).then(d => {
        if (d.code === 0) {
          done(d.data.list)
        }
      })
    },

    // 上传错误时
    on_cover_error (msg) {
      this.$loading.hide()
      this.$notify({
        content: msg,
        duration: 2000,
        type: 'danger',
        dismissible: false
      })
    },

    // 上传开始时
    on_cover_start (e) {
      this.$loading.show({
        msg: '文件上传中, 已发送 0 % ...'
      })
    },

    // 上传完成时
    on_cover_finish (d) {
      this.$loading.hide()
      this.$notify({
        content: '上传成功',
        duration: 1000,
        type: 'success',
        dismissible: false
      })
      // 子商品封面上传
      if (this.curGoodsSpecKey !== null) {
        let item = this.goodsSpecs[this.curGoodsSpecKey.parentKey]
        item[this.curGoodsSpecKey.key] = d.image
        item[this.curGoodsSpecKey.key + '_url'] = d.url
        this.$set(this.$data.goodsSpecs, this.curGoodsSpecKey.parentKey, item)
        this.curGoodsSpecKey = null
      } else {
        this.form.goods_cover = d.image
        this.$set(this.$data.form, 'goods_cover_url', d.url)
      }
    },

    // 上传处理时
    on_cover_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },

    on_editor_error (msg) {
      this.$loading.hide()
      this.$notify({
        content: msg,
        duration: 2000,
        type: 'danger',
        dismissible: false
      })
    },
    on_editor_start (e) {
      this.$loading.show({
        msg: '文件上传中, 已发送 0 % ...'
      })
    },
    on_editor_finish (d) {
      this.$loading.hide()
      this.$notify({
        content: '上传成功',
        duration: 1000,
        type: 'success',
        dismissible: false
      })
      this.extra.Editor.insertEmbed(this.extra.cursorLocation, 'image', d.url)
      this.extra.resetUploader()
    },
    on_editor_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },
    // 上传商品封面图
    upload_cover () {
      this.curGoodsSpecKey = null
      this.$uploader.select({
        uri: 'upload/image',
        el: this,
        pre: 'cover'
      })
    },

    // 上传富文本编辑器内容
    uploadEditorImage (file, Editor, cursorLocation, resetUploader) {
      let formData = new FormData()
      formData.append('raw', JSON.stringify({
        'uri': 'upload/image',
        'access_token': this.$sess.access_token
      }))
      formData.append('file', file)
      this.extra = {Editor, cursorLocation, resetUploader}
      this.$uploader.exec({
        uri: 'upload/image',
        el: this,
        pre: 'editor',
        data: formData
      })
    },

    // 获取商品信息, 初始化编辑数据
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('store/goods', {id: this.id}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = d.data.row || this.form
          this.cover = this.form['goods_cover'] || this.cover
          this.categories = d.data.categories || {}
          this.brands = d.data.brands
          this.goodsTypes = d.data.types || {}
          this.goodsStatus = d.data.status || {}
          this.specStatus = d.data.spec_status || {}
          if (this.form.goods_type_id) {
            this.selectGoodsType()
            this.baseAttrs = d.data.attrs
            this.goodsSpecs = d.data.specs
          }
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        }
      })
    },

    // 保存数据
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('store/goods', {
        goods: this.form,
        specs: this.goodsSpecs,
        attrs: this.baseAttrs
      }).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/store/goods'
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
            duration: 1500,
            type: 'danger',
            dismissible: false
          })
        }
      })
    }
  },

  // 挂载时
  mounted: function () {
    this.$store.state.left_active_key = '/store'
    this.modify()
  },

  // 析构时
  destroyed: function () {
    this.$loading.hide()
  },

  // 激活时
  activated: function () {
    this.$store.state.left_active_key = '/store'
  }
}
</script>
<style scoped>
.quillWrapper {
  max-width: 1000px;
}
</style>
