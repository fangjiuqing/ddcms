<template>
  <div class="profile">
    <breadcrumbs :items="items"/>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
      <div class="app_content">
      <tabs>
        <tab title="资料">
          <div class="app_form" style="width:60%">
            <div class="row">
                <label class="col-sm-2 label-on-left">姓名</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <input class="form-control" v-model="form.admin_nick"  v-focus="focus.admin_nick" name="admin_nick" type="text" placeholder="姓名">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">邮箱地址</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <input class="form-control" v-model="form.admin_email" v-focus="focus.admin_email" name="admin_email" type="text" placeholder="姓名">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">手机号码</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <input class="form-control" v-model="form.admin_mobile" v-focus="focus.admin_mobile" name="admin_mobile" type="text" placeholder="手机号码">
                    </div>
                </div>
            </div>
          </div>
        </tab>
        <tab title="头像">
        </tab>

        <span slot="nav-right">
          <btn type="success" v-on:click="form_save" class="btn btn-sm btn-success btn-fill">保存</btn>
        </span>
      </tabs>
      </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Profile',
  metaInfo: {
    title: '我的资料 - 道达智装'
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '我的资料', to: '/user/profile'},
        {text: '更新', href: '#'}
      ],
      form: {},
      focus: {}
    }
  },
  methods: {
    form_save: function () {
      this.$loading.show()
      this.$http.save('user/profile', this.form).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
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
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/user'
    this.$loading.show({
      msg: '加载中 ...'
    })
    this.$http.get('user/profile').then(d => {
      this.$loading.hide()
      if (d.code === 0) {
        this.form = d.data
      }
    })
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/user'
  }
}
</script>
