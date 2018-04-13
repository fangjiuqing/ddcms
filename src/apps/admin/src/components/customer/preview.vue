<template>
  <div class="profile">
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
            <div class="clearfix"></div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">客户编号</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="pc_sn" v-model="form.pc_sn"  v-focus="form.pc_sn" placeholder="客户编号">
              </div>
            </div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">客户姓名</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="pc_nick" v-model="form.pc_nick"  v-focus="form.pc_nick" placeholder="客户姓名">
              </div>
            </div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">客户性别</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="pc_gender" v-model="form.pc_gender"  v-focus="form.pc_gender" placeholder="客户性别">
              </div>
            </div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">身份证号</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="pc_sid" v-model="form.pc_sid"  v-focus="form.pc_sid" placeholder="身份证号">
              </div>
            </div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">手机号</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="pc_mobile" v-model="form.pc_mobile"  v-focus="form.pc_mobile" placeholder="手机号" disabled>
              </div>
            </div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">客户状态</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="pc_status" v-model="form.pc_status"  v-focus="form.pc_status" placeholder="客户状态" disabled>
              </div>
            </div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">所属客服</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="pc_adm_id" v-model="form.pc_adm_id"  v-focus="form.pc_adm_id" placeholder="所属客服" disabled>
              </div>
            </div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">客服姓名</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="pc_adm_nick" v-model="form.pc_adm_nick"  v-focus="form.pc_adm_nick" placeholder="客服姓名">
              </div>
            </div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">客户来源</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="pc_via" v-model="form.pc_via"  v-focus="form.pc_via" placeholder="客户来源">
              </div>
            </div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">所在地</label>
              <div class="form-group col-sm-9">
                <v-distpicker :province="form.province" :city="form.city" :area="form.area" @selected="onSelected"></v-distpicker>
              </div>
            </div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">详细地址</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="pc_addr" v-model="form.pc_addr"  v-focus="form.pc_addr" placeholder="详细地址">
              </div>
            </div>
            <div class="col-sm-6">
              <label class="col-sm-3 label-on-left">小区</label>
              <div class="form-group col-sm-9">
                <input type="text" class="form-control" name="pc_co_id" v-model="form.pc_co_id"  v-focus="form.pc_co_id" placeholder="小区">
              </div>
            </div>
          </div>
        </div>
        <div class="form-block">
          <div class="row">
            <div class="col-md-12">
              <div class="history-title">
                <div class="history">
                  <h5 class="block-h5">
                    预约历史
                  </h5>
                  <h5 class="add">
                    <btn class="btn btn-info btn-xs pull-right" @click="add_attr">新增</btn>
                  </h5>
                </div>
                <table class="table table-striped">
                  <tbody>
                    <tr v-for="(row, row_key) in attrs" :key="row_key">
                      <td width="35%">
                        <input class="form-control material_field_input" v-model="attrs[row_key]['key']" placeholder="请输入项名称"/>
                      </td>
                      <td width="55%">
                        <input class="form-control material_field_input" v-model="attrs[row_key]['val']" value="" placeholder="请输入项取值" />
                      </td>
                      <td>
                        <btn class="btn btn-xs btn-danger" @click="del_attr(row_key)"><i class="fa fa-trash-o"></i></btn>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="form-block">
          <div class="row">
            <div class="col-md-12">
              <div class="history-title">
                <div class="history">
                  <h5 class="block-h5">
                    操作历史
                  </h5>
                  <h5 class="add">
                    <btn class="btn btn-info btn-xs pull-right" @click="add_attr">新增</btn>
                  </h5>
                </div>
                <div class="btnss">
                  <div class="col-sm-6">
                    <label class="col-sm-3 label-on-left">添加时间</label>
                    <div class="form-group col-sm-9">
                      <input type="text" class="form-control" name="pc_atime" v-model="form.pc_atime"  v-focus="form.pc_atime" placeholder="添加时间">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label class="col-sm-3 label-on-left">更新时间</label>
                    <div class="form-group col-sm-9">
                      <input type="text" class="form-control" name="pc_utime" v-model="form.pc_utime"  v-focus="form.pc_utime" placeholder="更新时间">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import VDistpicker from 'v-distpicker'
export default {
  name: 'Preview',
  metaInfo () {
    return {
      title: '客户预览 - 道达智装'
    }
  },
  components: { VDistpicker },
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
        },
        key1: {
          key: '生活习惯',
          val: ''
        },
        key2: {
          key: '风格喜好',
          val: ''
        },
        key3: {
          key: '其他要求',
          val: ''
        }
      }
    }
  },
  methods: {
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
          this.form = this.id ? d.data : {}
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
.history {
  display: flex;
  color: #333;
  text-align: left;
  text-decoration: none;
}
.active .history {
  color: purple;
}
.add {
  position: absolute;
  right: 50px;
}
</style>
