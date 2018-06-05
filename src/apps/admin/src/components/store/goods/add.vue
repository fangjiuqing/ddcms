<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
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
            <div class="col-md-9">
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">商品名称</label>
                <div class="col-sm-10 input-label">
                  <input class="form-control" name="goods_name" v-model="form.goods_name" type="text" placeholder="商品名称">
                </div>
              </div>
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">所属分类</label>
                <div class="col-sm-10 input-label">
                  <select v-model="form.goods_cat_id"  name="goods_cat_id" class="form-control">
                    <option disabled value="">请选择所属分类</option>
                    <option v-for="(v) in categories" v-bind:key="v.cat_id" :value="v.cat_id" v-html="v.space">
                    </option>
                  </select>
                </div>
              </div>
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">所属品牌</label>
                <div class="col-sm-10 input-label">
                  <select v-model="form.goods_brand"  name="goods_brand" class="form-control">
                    <option disabled value="">请选择所属品牌</option>
                    <option v-for="(v) in brands" v-bind:key="v.pb_id" :value="v.pb_id">
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
            </div>
            <div class="col-md-3">
              <img class="preview_cover" style="width:200px;height:150px;" :src="cover" @click="upload_cover">
              <input type="hidden" name="mat_cover" v-model="form.mat_cover">
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
        <div class="form-block">
          <div class="row">
            <div class="col-md-12">
              <h5 class="block-h5">规格信息</h5>
            </div>
            <div class="col-md-9">
              <div class="row form-input-row">
                <label class="col-sm-2 field-label">商品类型</label>
                <div class="col-sm-10 input-label">
                  <select v-model="form.goods_type_id" @change="selectGoodsType" class="form-control">
                    <option disabled value="">请选择商品类型</option>
                    <option v-for="(v, k) in goodsTypes" v-bind:key="k" :value="k">
                      {{v.gt_name}}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="margin:0 auto; float: none">
            <btn type="success" v-on:click="save" class="btn btn-success pull-right">保存</btn>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  name: 'StoreGoodsAdd',
  metaInfo () {
    return {
      title: '商品管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '材料', to: '/material'},
        {text: '编辑', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      cover: require('@/assets/images/default_4x3.jpg'),
      form: {
        goods_brand: '',
        goods_cat_id: '',
        goods_type_id: ''
      },
      brands: {},
      categories: {},
      goodsTypes: {},
      baseAttrs: {}
    }
  },
  methods: {
    selectGoodsType () {
      this.baseAttrs = this.goodsTypes[this.form.goods_type_id].attrs
    },
    querySupplier (query, done) {
      this.$http.list('store/supplier', {key: query}).then(d => {
        if (d.code === 0) {
          done(d.data.list)
        }
      })
    },
    on_cover_error (msg) {
      this.$loading.hide()
      this.$notify({
        content: msg,
        duration: 2000,
        type: 'danger',
        dismissible: false
      })
    },
    on_cover_start (e) {
      this.$loading.show({
        msg: '文件上传中, 已发送 0 % ...'
      })
    },
    on_cover_finish (d) {
      this.$loading.hide()
      this.$notify({
        content: '上传成功',
        duration: 1000,
        type: 'success',
        dismissible: false
      })
      this.form.mat_cover = d.image
      this.mat_cover = d.thumb
    },
    on_cover_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },
    upload_cover () {
      this.$uploader.select({
        uri: 'upload/image',
        el: this,
        pre: 'cover'
      })
    },
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('store/goods', {id: this.id}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = d.data.row || this.form
          this.cover = this.form['goods_cover'] || this.cover
          this.categories = d.data.category || {}
          this.brands = d.data.brands
          this.goodsTypes = d.data.types || {}
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
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('material', {
        row: this.form,
        attr_key: this.fields,
        attr_val: this.rows
      }).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/material'
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
  mounted: function () {
    this.$store.state.left_active_key = '/store'
    this.modify()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/store'
  }
}
</script>
