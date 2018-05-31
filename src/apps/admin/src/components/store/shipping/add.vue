<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="" method="post" accept-charset="utf-8" class="form-block ">
        <div class="col-sm-5">
          <div class="row">
            <div class="col-md-12">
              <h5 class="block-h5">基本信息</h5>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <input class="form-control" v-model="form.shipping_name" type="text" placeholder="配送名称">
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <div class="input-group">
                  <input class="form-control" name="des_workyears" v-model="form.shipping_price" type="number" placeholder="配送价格">
                  <span class="input-group-addon">元</span>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <div class="input-group">
                  <input class="form-control" name="des_workyears" v-model="form.shipping_free" type="number" placeholder="免费额度">
                  <span class="input-group-addon">元</span>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <label class="col-sm-2 label-on-left">启用状态</label>
              <div class="col-sm-10">
                <div class="form-group">
                  <select v-model="form.shipping_status" class="form-control">
                    <option value="1">启用</option>
                    <option value="0">关闭</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-7">
          <div class="row">
            <div class="col-md-12">
              <h5 class="block-h5">
                配送区域
              </h5>
            </div>
            <div class="form-group text-left">
              <v-distpicker :province="form.province" :city="form.city" hide-area @selected="onSelected"></v-distpicker>
            </div>
            <div class="shipping-area">
              <span class="label label-info" v-for="(row, row_key) in areas" :key="row_key">
                <b>{{areas[row_key]['areaName']}}</b>
                <b class="remove" @click="removeArea(row_key)">x</b>
              </span>
            </div>
          </div>
        </div>

        <div class="clearfix"></div>
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
import VDistpicker from 'v-distpicker'
export default {
  components: { VDistpicker },
  name: 'ShippingAdd',
  metaInfo () {
    return {
      title: '新增配送方式 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '商城', to: '/store'},
        {text: '配送管理', to: '/store/shipping'},
        {text: '编辑', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      form: {},
      areas: {}
    }
  },
  methods: {
    onSelected (d) {
      this.$set(this.$data.areas, d.city.code, {
        areaName: d.province.value + '-' + d.city.value
      })
    },
    removeArea (areaId) {
      this.$delete(this.$data.areas, areaId)
    },
    modify (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('store/shipping/shipping', {id: this.id || 0, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = this.id ? d.data.row : this.form
          this.areas = this.id ? d.data.areas : this.areas
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        } else {
          this.form = []
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('store/shipping/shipping', {
        base: this.form,
        areas: this.areas
      }).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/store/shipping'
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
<style>
.shipping-area {
  text-align: left;
}
.shipping-area .remove {
  cursor: pointer;
}
.shipping-area .label {
  display: inline-block;
  padding: 5px 10px;
  background-color: #d81b60;
  margin-right: 10px;
  margin-bottom: 10px
}
</style>
