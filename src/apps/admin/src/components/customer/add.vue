<template>
  <div class="profile">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text }}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <div class="form-block">
        <tabs style="padding-top:15px;">
          <tab title="基本信息">
            <div class="form-block">
              <div class="row">
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">客户姓名</label>
                  <div class="form-group col-sm-9">
                    <input type="text" class="form-control" name="pc_nick" v-model="form.pc_nick" placeholder="客户姓名">
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">客户编号</label>
                  <div class="form-group col-sm-9">
                    <input type="text" class="form-control" name="pc_sn" v-model="form.pc_sn" placeholder="客户编号">
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">客户性别</label>
                  <div class="form-group col-sm-9 text-left" style="padding-top:10px;">
                    <p-check class="p-default p-round" v-model="form.pc_gender" true-value="1">先生</p-check>
                    <p-check class="p-default p-round p-fill" v-model="form.pc_gender" true-value="2">女士</p-check>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">身份证号</label>
                  <div class="form-group col-sm-9">
                    <input type="text" class="form-control" name="pc_sid" v-model="form.pc_sid" placeholder="身份证号">
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">手机号</label>
                  <div class="form-group col-sm-9">
                    <input type="text" class="form-control" name="pc_mobile" v-model="form.pc_mobile" placeholder="手机号" disabled>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">客户来源</label>
                  <div class="form-group col-sm-9">
                    <select v-model="form.pc_via" class="form-control">
                      <option disabled value="0">未知</option>
                      <option v-for="(v, k) in via" v-bind:key="k" :value="k">
                        {{v}}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">客户状态</label>
                  <div class="form-group col-sm-9">
                    <select v-model="form.pc_status" class="form-control">
                      <option disabled value="0">未知</option>
                      <option v-for="(v, k) in status" v-bind:key="k" :value="k">
                        {{v}}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">所在地</label>
                  <div class="form-group col-sm-9">
                    <v-distpicker :province="form.region0" :city="form.region1" :area="form.region2" @selected="onSelected"></v-distpicker>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">详细地址</label>
                  <div class="form-group col-sm-9">
                    <input type="text" class="form-control" name="pc_addr" v-model="form.pc_addr" placeholder="详细地址">
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">小区</label>
                  <div class="form-group col-sm-9">
                    <input type="text" class="form-control" name="pc_co_id" v-model="form.pc_co_id" placeholder="小区">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12" style="margin:0px auto;">
                  <h5 class="block-h5-btm">
                    <btn type="success" class="btn btn-success pull-right">保存</btn>
                  </h5>
                </div>
              </div>
            </div>
          </tab>
          <tab title="预约记录">
            <dropdown ref="dropdown" style="margin-top:0px;" class="pull-right">
              <btn type="success" class="btn dropdown-toggle btn-xs">
                <i class="fa fa-plus"></i> 新增预约 <span class="caret"></span>
              </btn>
              <template slot="dropdown">
                <li v-for="(v, k) in type" :key="k">
                  <a role="button" @click="addOrder(form.pc_id, k)"><small>新增<code>{{v}}</code>预约</small></a>
                </li>
              </template>
            </dropdown>
            <div class="form-block">

            </div>
          </tab>
          <tab title="方案管理">
            <p>Profile tab.</p>
          </tab>
          <tab title="操作记录">
            <p>Others tab.</p>
          </tab>
        </tabs>
      </div>
    </div>
  </div>
</template>
<script>
import 'pretty-checkbox/dist/pretty-checkbox.min.css'
import PrettyCheck from 'pretty-checkbox-vue/check'
import PrettyRadio from 'pretty-checkbox-vue/radio'

import VDistpicker from 'v-distpicker'
export default {
  name: 'Preview',
  metaInfo () {
    return {
      title: '客户预览 - 道达智装'
    }
  },
  components: {
    VDistpicker,
    'p-check': PrettyCheck,
    'p-radio': PrettyRadio
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '客户', to: '/customer'},
        {text: '预览', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      form: {},
      attrs: {
        key0: {
          key: '家庭成员',
          val: ''
        }
      },
      status: {},
      via: {},
      orders: [],
      type: {}
    }
  },
  methods: {
    addOrder (pcID, key) {
      console.log(pcID, key)
    },
    onSelected (d) {
      this.form.pc_region0 = d.province.code
      this.form.pc_region1 = d.city.code
      this.form.pc_region2 = d.area.code
    },
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('customer', {id: this.id || 0, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = this.id ? d.data.row : {}
          this.status = d.data.status
          this.via = d.data.via
          this.orders = d.data.orders
          this.type = d.data.type

          this.items = [
            {text: '首页', to: '/'},
            {text: '客户', to: '/customer'},
            {text: this.form.pc_nick, href: '#'}
          ]
        } else {
          this.rows = []
        }
      })
    },
    add_attr () {
      this.$set(this.$data.attrs, this.$util.rand_str(16), {
        key: '',
        val: ''
      })
    },
    del_attr (key) {
      this.$delete(this.$data.attrs, key)
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/customer'
    this.modify()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/customer'
  }
}
</script>
<style>
.distpicker-address-wrapper {
  text-align: left;
}
.distpicker-address-wrapper select {
  float: left;
  margin-right: 3px;
}
</style>
