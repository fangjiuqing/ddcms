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
                        <input class="form-control" name="admin_nick" type="text" value="" placeholder="姓名">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">邮箱地址</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <input class="form-control" name="admin_email" type="text" value="" placeholder="姓名">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 label-on-left">手机号码</label>
                <div class="col-sm-10">
                    <div class="form-group">
                        <input class="form-control" name="admin_mobile" type="text" value="" placeholder="姓名">
                    </div>
                </div>
            </div>
          </div>
        </tab>
        <tab title="头像">
        </tab>

        <span slot="nav-right">
          <btn type="success" class="btn btn-sm btn-success btn-fill">保存</btn>
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
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '我的资料', to: '/user/profile'},
        {text: '更新', href: '#'}
      ]
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/user'
    this.$loader.show({
      msg: '加载中 ...'
    })
  },
  destroyed: function () {
    this.$loader.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/user'
  }
}
</script>
