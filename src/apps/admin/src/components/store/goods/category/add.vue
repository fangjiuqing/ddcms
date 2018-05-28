<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <div class="form-block">
        <div class="row">
          <div class="col-md-12">
            <h5 class="block-h5">基本信息</h5>
          </div>
          <div class="col-md-9">
            <div class="row">
                <label class="col-sm-2 label-on-left">名称</label>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input class="form-control" v-model="form.cat_name" type="text" placeholder="分类名称">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">排序</label>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input class="form-control" v-model="form.cat_sort" type="text" placeholder="分类排序">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">父级分类</label>
                <div class="col-sm-8">
                    <div class="form-group">
                        <select v-model="form.cat_parent" class="form-control">
                          <option v-for="(v) in form.parent_options" v-bind:key="v.cat_id" :value="v.cat_id" v-html="v.space">
                          </option>
                        </select>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-block">
        <div class="row">
          <div class="col-md-12">
            <h5 class="block-h5">筛选属性</h5>
          </div>
          <div class="col-md-9">
            <div class="row">
              <label class="col-sm-2 label-on-left">商品类型</label>
              <div class="col-sm-4">
                <div class="form-group">
                  <select v-model="curGoodsTypeID" @change="initAttrs" class="form-control">
                    <option value="" disabled="">请选择商品类型</option>
                    <option v-for="(v, key) in goodsType" v-bind:key="key" :value="v.gt_id">
                      {{v.gt_name}}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <select v-model="curGoodsAttrsID" class="form-control">
                  <option value="" disabled="">请选择可筛选的属性</option>
                  <option v-for="(v, key) in goodsTypeAttrs" :key="key" :value="v.ga_id">
                    {{v.ga_name}}
                  </option>
                </select>
              </div>
              <div class="col-sm-2 text-left">
                <button class="btn btn-info" @click="setAttr">添加</button>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-2 label-on-left">已选择</label>
              <div class="col-sm-8 text-left">
                <btn class="btn btn-xs btn-default" @click="delAttr(v.ga_id)" v-for="(v, k) in attrs" :key="k" style="margin-right: 5px;">
                  {{v.ga_name}}
                </btn>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12" style="margin:0 auto; float: none">
            <btn type="success" v-on:click="save" class="btn btn-success pull-right">保存</btn>
          </div>
        </div>
      </div>
    </div>
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
        {text: '详情', href: '#'}
      ],
      form: {
        cat_id: this.$route.query['id'] || 0
      },
      curGoodsTypeID: '',
      curGoodsAttrsID: '',
      goodsType: {},
      goodsTypeAttrs: {},
      attrs: {}
    }
  },
  methods: {
    initAttrs (d) {
      this.goodsTypeAttrs = this.goodsType[this.curGoodsTypeID]['attrs']
    },
    delAttr (id) {
      this.$delete(this.$data.attrs, id)
    },
    setAttr (d) {
      if (this.curGoodsAttrsID) {
        this.$set(this.$data.attrs, this.curGoodsAttrsID, this.goodsTypeAttrs[this.curGoodsAttrsID])
      }
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('store/goods/category', {id: this.form.cat_id, parent: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = d.data || this.form
          this.goodsType = d.data.type || {}
          this.attrs = d.data.attrs || {}
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
      this.form['attrs'] = this.attrs
      this.$http.save('store/goods/category', this.form).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/store/goods/category'
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
