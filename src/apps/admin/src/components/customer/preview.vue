<template>
  <div class="profile">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="col-sm-7" style="padding-left:0">
            <div class="row" style="margin:0 auto;">
                <div class="form-group">
                  <label class="col-sm-3 label-on-left">客户编号</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" v-model="form.pc_sn"  v-focus="form.pc_sn" type="text" placeholder="客户编号" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 label-on-left">客户姓名</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" v-model="form.pc_nick"  v-focus="form.pc_nick" type="text" placeholder="客户姓名" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 label-on-left">性别</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" v-model="form.pc_gender"  v-focus="form.pc_gender" type="text" placeholder="性别" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 label-on-left">身份证号</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" v-model="form.pc_sid"  v-focus="form.pc_sid" type="text" placeholder="身份证号" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 label-on-left">电话</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" v-model="form.pc_mobile"  v-focus="form.pc_mobile"  type="text" placeholder="联系电话" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 label-on-left">客户来源</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" v-model="form.pc_via"  v-focus="form.pc_via"  type="text" placeholder="客户来源" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 label-on-left">客服姓名</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" v-model="form.pc_adm_nick"  v-focus="form.pc_adm_nick"  type="text" placeholder="客服姓名" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 label-on-left">详细地址</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" v-model="form.pc_addr"  v-focus="form.pc_addr"  type="text" placeholder="详细地址" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 label-on-left">小区</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" v-model="form.pc_co_id"  v-focus="form.pc_co_id"  type="text" placeholder="小区" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 label-on-left">添加时间</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" v-model="form.pc_atime"  v-focus="form.pc_atime"  type="text" placeholder="添加时间" disabled>
                    </div>
                  </div>
                </div>
              <!-- <div class="content table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th class="text-left" width="100">客户编号</th>
                      <th class="text-center" width="80">客户姓名</th>
                      <th class="text-center" width="80">电话</th>
                      <th class="text-center" width="80">客户来源</th>
                      <th class="text-center" width="80">客服姓名</th>
                      <th class="text-center" width="300">详细地址</th>
                      <th class="text-center" width="150">小区</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(v) in rows" :key="v.pc_id">
                      <td class="text-left">
                        <span>{{v.pc_sn}}</span>
                      </td>
                      <td class="text-center">
                        <code>{{v.pc_nick}}</code>
                      </td>
                      <td class="text-center">
                        <small>{{v.pc_mobile}}</small>
                      </td>
                      <td class="text-center">
                        <small>{{v.pc_via}}</small>
                      </td>
                      <td class="text-center">
                        <small>{{v.pc_adm_nick}}</small>
                      </td>
                      <td class="text-center">
                        <small>{{v.pc_region0}} {{v.pc_region1}} {{v.pc_region2}} {{v.pc_addr}}</small>
                      </td>
                      <td class="text-center">
                        <small>{{v.pc_area}}</small>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div> -->
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Preview',
  metaInfo () {
    return {
      title: '客户预览 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '客户', to: '/customer'},
        {text: '预览', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      form: {}
      // rows: []
    }
  },
  methods: {
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('customer', {id: this.id || 0, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          // this.rows = d.data
          // console.log(this.rows)
          this.form = this.id ? d.data : {}
        } else {
          this.rows = []
        }
      })
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
