<template>
  <div class="case">
    <breadcrumbs :items="items"/>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
      <div class="app_content">
        <div class="form-block">
          <div class="row">
            <div class="col-md-12">
              <h5 class="block-h5">我的信息</h5>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-8">
              <div class="row">
                  <label class="col-sm-2 label-on-left">手机号码</label>
                  <div class="col-sm-10">
                      <div class="form-group">
                          <input class="form-control" v-model="form.admin_mobile" v-focus="focus.admin_mobile" name="admin_mobile" type="text" placeholder="手机号码" >
                      </div>
                  </div>
              </div>
              <div class="row">
                <label class="col-sm-2 label-on-left">微信</label>
                <div class="col-sm-10">
                  <div class="form-group">
                    <input class="form-control" v-model="form.admin_wechat" type="text" placeholder="请输入微信号">
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 label-on-left">当前密码</label>
                <div class="col-sm-10">
                  <div class="form-group">
                    <input class="form-control" v-model="form.passwd" type="text" placeholder="请输入当前密码 (留空不做修改)">
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 label-on-left">新密码</label>
                <div class="col-sm-10">
                  <div class="form-group">
                    <input class="form-control" v-model="form.passwd1" type="text" placeholder="请再次输入密码">
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 label-on-left">确认密码</label>
                <div class="col-sm-10">
                  <div class="form-group">
                    <input class="form-control" v-model="form.passwd2" type="text" placeholder="请再次输入新密码">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <img class="preview_cover" style="width: 240px; height: 180px;" :src="avatar" @click="upload_avatar">
              <input type="hidden" v-model="form.admin_avatar">
            </div>
            <div class="clearfix"></div>
            <btn type="success" @click="form_save" class="btn btn-success">保存</btn>
          </div>
        </div>
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
      focus: {},
      avatar: require('@/assets/images/default_4x3.jpg')
    }
  },
  methods: {
    on_avatar_error (msg) {
      this.$loading.hide()
      this.$notify({
        content: msg,
        duration: 2000,
        type: 'danger',
        dismissible: false
      })
    },
    on_avatar_start (e) {
      this.$loading.show({
        msg: '文件上传中, 已发送 0 % ...'
      })
    },
    on_avatar_finish (d) {
      this.$loading.hide()
      this.$notify({
        content: '上传成功',
        duration: 1000,
        type: 'success',
        dismissible: false
      })
      this.form.case_avatar = d.image
      this.avatar = d.thumb
    },
    on_avatar_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },
    upload_avatar () {
      this.$uploader.select({
        uri: 'upload/image',
        el: this,
        pre: 'avatar'
      })
    },
    form_save () {
      this.$loading.show()
      this.$http.save('user/profile', this.form).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'success',
            dismissible: false
          }).then(() => {
            if (d.data.relogin) {
              this.$sess.logout(this.$cache)
              this.$store.state.is_login = false
              this.$router.push({path: '/login'})
            }
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
  destroyed () {
    this.$loading.hide()
  },
  activated () {
    this.$store.state.left_active_key = '/user'
  }
}
</script>
