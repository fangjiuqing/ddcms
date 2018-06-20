<template>
  <div class="customer">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text }}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <div class="form-block">
        <tabs style="padding-top:15px;" @change="onTabChange">
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
                  <label class="col-sm-3 label-on-left">手机号</label>
                  <div class="form-group col-sm-9">
                    <input type="text" class="form-control" name="pc_mobile" v-model="form.pc_mobile" placeholder="手机号" >
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
                <div class="row address">
                  <div class="col-sm-6">
                    <label class="col-sm-3 label-on-left">所在地</label>
                    <div class="form-group col-sm-9">
                      <v-distpicker :province="form.region0" :city="form.region1" :area="form.region2" @selected="onSelected"></v-distpicker>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label class="col-sm-3 label-on-left">乡镇/街道</label>
                    <select v-model="form.pc_region3" class="form-control street">
                      <option v-for="(item, index) in this.street" :key="index" :value="item.region_code">{{item.region_name}}</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">详细地址</label>
                  <div class="form-group col-sm-9">
                    <input type="text" class="form-control" name="pc_addr" v-model="form.pc_addr" placeholder="详细地址">
                  </div>
                </div>
                <div class="col-sm-6">
                  <section>
                    <label for="input-5" class="label-on-left col-sm-3 ">小区</label>
                    <div class="form-group col-sm-9">
                      <input id="input-5" class="form-control" type="text" placeholder="请选择小区" v-model="queryString">
                      <typeahead :value="form.pc_co_name" target="#input-5" :async-function="baseInfo" item-key="pco_id">
                        <template slot="item" slot-scope="props">
                          <li v-for="(item, index) in props.items" :class="{active:props.activeIndex===index}" :key="index">
                            <a role="button" @click="typeHeadSelect(item, props)">
                              <span>{{item.pco_name}}</span>
                            </a>
                          </li>
                        </template>
                      </typeahead>
                    </div>
                  </section>
                </div>
                <div class="col-sm-6">
                  <label class="col-sm-3 label-on-left">身份证</label>
                  <div class="form-group col-sm-9">
                    <input type="text" class="form-control" name="pc_sid" v-model="form.pc_sid" placeholder="身份证码">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10" style="margin:0px auto;">
                  <h5 class="block-h5-btm">
                    <btn type="success" class="btn btn-success pull-right" @click="save">保存</btn>
                  </h5>
                </div>
              </div>
            </div>
          </tab>
          <tab title="房型信息">
            <div class="form-block">
              <div class="col-sm-5">
                <label class="col-sm-3 label-on-left">房型</label>
                <div class="form-group col-sm-9">
                  <select v-model="house.pch_mode" class="form-control">
                    <option disabled value="0">未知</option>
                    <option v-for="(v, k) in mode" v-bind:key="k" :value="k">
                      {{v}}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-sm-5">
                <label class="col-sm-3 label-on-left">户型</label>
                <div class="form-group col-sm-9">
                  <select v-model="house.pch_type" class="form-control">
                    <option disabled value="0">未知</option>
                    <option v-for="(v, k) in type" v-bind:key="k" :value="k">
                      {{v}}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-sm-5">
                <label class="col-sm-3 label-on-left">风格</label>
                <div class="form-group col-sm-9">
                  <select v-model="house.pch_style" class="form-control">
                    <option disabled value="0">未知</option>
                    <option v-for="(v, k) in style" v-bind:key="k" :value="k">
                      {{v}}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-sm-5">
                <label class="col-sm-3 label-on-left">总面积</label>
                <div class="form-group col-sm-9">
                  <input type="text" class="form-control" name="pch_area" v-model="house.pch_area" placeholder="总面积">
                </div>
              </div>
              <div class="col-sm-5">
                <label class="col-sm-3 label-on-left">可用面积</label>
                <div class="form-group col-sm-9">
                  <input type="text" class="form-control" name="pch_area_use" v-model="house.pch_area_use" placeholder="可用面积">
                </div>
              </div>
              <div class="col-sm-5">
                <label class="col-sm-3 label-on-left">楼层</label>
                <div class="form-group col-sm-9">
                  <input type="text" class="form-control" name="pch_floor" v-model="house.pch_floor" placeholder="楼层">
                </div>
              </div>
              <div class="col-sm-5">
                <label class="col-sm-3 label-on-left">是否现房</label>
                <div class="form-group col-sm-9">
                  <select v-model="house.pch_exists" class="form-control">
                    <option disabled value="0">未知</option>
                    <option v-for="(v, k) in exists" v-bind:key="k" :value="k">
                      {{v}}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-sm-5">
                <label class="col-sm-3 label-on-left">拿房时间</label>
                <div class="form-group col-sm-9">
                  <input type="text" class="form-control" name="pch_gtime" v-model="house.pch_gtime" placeholder="拿房时间">
                </div>
              </div>
              <div class="col-sm-5">
                <label class="col-sm-3 label-on-left">预算</label>
                <div class="form-group col-sm-9">
                  <input type="text" class="form-control" name="pch_budget" v-model="house.pch_budget" placeholder="预算">
                </div>
              </div>
              <div class="row">
                <div class="col-md-10" style="margin:0px auto;">
                  <h5 class="block-h5-btm">
                    <btn type="success" class="btn btn-success pull-right" @click="savehouse">保存</btn>
                  </h5>
                </div>
              </div>
            </div>
          </tab>
          <tab title="预约记录">
            <btn type="success" class="btn btn-xs pull-right" @click="addOrder">
              <i class="fa fa-plus"></i> 新增预约
            </btn>
            <div class="form-block">
              <div class="content table-responsive">
                <table class="table table-hover">
                  <thead>
                      <tr>
                        <th class="text-center" width="25%"><small>发布时间</small></th>
                        <th class="text-center" width="25%"><small>预约类型</small></th>
                        <th class="text-center" width="25%"><small>预约时间</small></th>
                        <th class="text-center" width="25%"><small>短信通知</small></th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(v) in sortOrders" :key="v.pco_id">
                          <td class="text-center">
                            <small>{{v.pco_atime|time('yyyy-mm-dd HH:MM')}}</small>
                          </td>
                          <td class="text-center">
                              <code>{{type[v.pco_type]}}</code>
                          </td>
                          <td class="text-center">
                            <code><small>{{v.pco_stime|time('yyyy-mm-dd HH:MM')}}</small></code>
                          </td>
                          <td class="text-center">
                            <small class="text-success" v-if="v.pco_sms_send === '1'">
                              已通知
                            </small>
                            <small class="text-warning" v-if="v.pco_sms_send === '0'">
                              未通知
                            </small>
                          </td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </tab>
          <tab title="方案管理">
            <p>Profile tab.</p>
          </tab>
          <tab title="操作记录">
            <div class="form-block">
              <div class="content table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th class="text-center" width="20%"><small>客服姓名</small></th>
                      <th class="text-center" width="20%"><small>客户姓名</small></th>
                      <th class="text-center" width="20%"><small>录入时间</small></th>
                      <th class="text-center" width="40%"><small>备注</small></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(v) in rows" :key="v.pct_id">
                      <td class="text-center">
                        <small>{{v.pct_adm_nick}}</small>
                      </td>
                      <td class="text-center">
                        <code>{{v.pc_nick}}</code>
                      </td>
                      <td class="text-center">
                        <code><small>{{v.pct_atime|time('yyyy-mm-dd HH:MM')}}</small></code>
                      </td>
                      <td class="text-center">
                        <small class="text-success">
                          {{v.pct_memo}}
                        </small>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </tab>
        </tabs>
      </div>
    </div>
    <modal v-model="addModalOpen" title="新增预约">
      <div slot="title" class="text-left">
        新增预约
      </div>
      <div slot="default">
        <form action="" method="post" accept-charset="utf-8">
          <div style="padding-right:30px;">
            <div class="row">
                <label class="col-sm-2 label-on-left">预约类型</label>
                <div class="col-sm-5">
                  <div class="form-group">
                    <select v-model="order.pco_type" class="form-control">
                      <option disabled value="">请选择预约类型</option>
                      <option v-for="(v, k) in type" :key="k" :value="k">
                        {{v}}服务
                      </option>
                    </select>
                  </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">预约日期</label>
                <div class="col-sm-5">
                  <dropdown class="form-group">
                    <div class="input-group">
                      <input class="form-control" type="text" v-model="order.date" placeholder="请选择预约日期">
                      <div class="input-group-btn">
                        <btn class="dropdown-toggle"><i class="fa fa-calendar"></i></btn>
                      </div>
                    </div>
                    <template slot="dropdown">
                      <li>
                        <date-picker v-model="order.date" :limit-from="dateLimitFrom"/>
                      </li>
                    </template>
                  </dropdown>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                      <time-picker v-model="order.time" :max="timeMax" :min="timeMin" :controls="false" :show-meridian="false"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">短信通知</label>
                <div class="col-sm-5 text-left">
                  <div class="form-group">
                    <p-check class="p-icon p-curve" v-model="order.pco_sms_send" color="success" style="top:11px;font-size: 16px">
                        <i slot="extra" class="icon fa fa-check"></i>
                    </p-check>
                  </div>
                </div>
            </div>
          </div>
        </form>
      </div>
      <div slot="footer">
        <btn type="success" @click="saveOrder" class="btn-sm">确认</btn>
      </div>
    </modal>
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
    var d = new Date()
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
      house: {},
      status: {},
      rows: [],
      via: {},
      street: [],
      orders: [],
      style: {},
      mode: {},
      exists: {},
      type: {},
      addModalOpen: false,
      dateLimitFrom: d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate(),
      timeMin: new Date('2017/01/01 07:00'),
      timeMax: new Date('2017/01/01 22:00'),
      order: {
        pco_id: 0,
        pco_type: '',
        pco_stime: '',
        pco_etime: '',
        pco_pc_id: 0,
        pco_atime: 0,
        pco_sms_send: false,
        type: '',
        date: '',
        time: new Date()
      },
      queryString: ''
    }
  },
  computed: {
    sortOrders () {
      return this.orders.slice().sort((a, b) => {
        return a.pco_atime < b.pco_atime
      })
    }
  },
  methods: {
    // 选项卡切换
    onTabChange (i) {
      if (i === 1 && this.orders.length === 0) {
        this.getOrders()
      }
    },
    // 获取预约记录
    getOrders () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('customer/order', {id: this.form.pc_id || 0}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.orders = d.data.orders || this.orders
        } else {
          this.$alert({
            title: '操作提示',
            content: d.msg
          }, (msg) => {
            if (d.code === 9999) {
              this.$router.go(-1)
            }
          })
        }
      })
    },
    // 新增预约订单
    addOrder () {
      this.order = {
        pco_id: 0,
        pco_type: 0,
        pco_stime: '',
        pco_etime: '',
        pco_pc_id: this.form.pc_id,
        pco_atime: 0,
        pco_sms_send: false,
        date: '',
        time: new Date()
      }
      this.addModalOpen = true
    },
    saveOrder () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      var data = this.order
      data['timestr'] = this.order.date + ' ' + this.order.time.getHours() + ':' + this.order.time.getMinutes() + ':00'
      this.$http.save('customer/order', {data}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.orders.push(d.data.order)
          this.addModalOpen = false
        } else {
          this.$alert({
            title: '操作提示',
            content: d.msg
          }, (msg) => {
            if (d.code === 9999) {
              this.$router.go(-1)
            }
          })
        }
      })
    },
    onSelected (d) {
      this.form.pc_region0 = d.province.code
      this.form.pc_region1 = d.city.code
      this.form.pc_region2 = d.area.code
      this.Selected()
    },
    Selected () {
      if (this.form.pc_region2) {
        this.$http.post('misc/street', {region_id: this.form.pc_region2}).then(d => {
          if (d.code === 0) {
            this.street = d.data
          }
        })
      }
    },
    typeHeadSelect (item, props) {
      this.form.pc_co_id = item.pco_id
      this.queryString = item.pco_name
    },
    baseInfo (query, done) {
      this.$http.get('customer/region', {region_name: query}).then(d => {
        if (d.code === 0) {
          var data = []
          for (var key in d.data) {
            if (d.data.hasOwnProperty(key)) {
              data.push(d.data[key])
            }
          }
          done(data)
        }
      })
    },
    logInfo: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('customer/log', {id: this.id}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data
        } else {
          this.rows = []
        }
      })
    },
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('customer', {id: this.id || 0, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = this.id ? d.data.row : {}
          this.queryString = this.form.pc_co_name
          this.status = d.data.status
          this.via = d.data.via
          this.type = d.data.type
          this.items = [
            {text: '首页', to: '/'},
            {text: '客户', to: '/customer'},
            {text: this.form.pc_nick, href: '#'}
          ]
        } else {
          this.$alert({
            title: '操作提示',
            content: d.msg
          }, (msg) => {
            if (d.code === 9999) {
              this.$router.go(-1)
            }
          })
        }
      })
    },
    modihouse: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('customer/house', {id: this.id || 0, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.house = this.id ? d.data : {}
          this.mode = this.id ? d.data.mode : {}
          this.exists = this.id ? d.data.exists : {}
          this.style = this.id ? d.data.style : {}
          this.type = this.id ? d.data.type : {}
        } else {
          this.$alert({
            title: '操作提示',
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
      this.$http.save('customer', this.form).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/customer'
          })
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'success',
            dismissible: false
          })
        } else {
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'danger',
            dismissible: false
          })
        }
      })
    },
    savehouse: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('customer/house', this.house).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/customer'
          })
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'success',
            dismissible: false
          })
        } else {
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'danger',
            dismissible: false
          })
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
    this.modihouse()
    this.logInfo()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/customer'
  }
}
</script>
<style scoped>
.dropdown-menu li{
  width: 100%;
}
.distpicker-address-wrapper {
  text-align: left;
}
.distpicker-address-wrapper select {
  float: left;
  margin-right: 3px;
}
.street {
  width: 70%;
  height: 40px;
  padding: 5px;
  float: left;
  margin-left: 7px;
  border-radius: 5px;
  border: 1px solid rgba(0, 0, 0, 0.15);
}
.address {
  margin-left: 0px;
}
</style>
