<template>
  <div class="passwd">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="reps">
      <div class="form-block">
        <div class="row">
          <div class="col-md-12">
            <h5 class="block-h5">修改密码</h5>
          </div>
          <div class="clearfix"></div>
          <div class="col-sm-3">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input type="password" class="form-control" id="passwd" placeholder="请输入旧密码" v-model.lazy="passwd" v-focus="passwd_focus">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <input class="form-control" type="password" id="newpasswd" placeholder="请输入新密码"  autocomplete="off" v-model.lazy="newpasswd" v-focus="newpasswd_focus">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input type="password" class="form-control" id="renewpasswd" placeholder="两次输入的新密码保持一致" v-model.lazy="renewpasswd" v-focus="renewpasswd_focus">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group btn-g">
                  <button type="submit" class="btn btn-sm btn-info col-sm-push-12" @click.prevent="submit">确认修改</button>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'Passwd',
  metaInfo () {
    return {
      title: '修改密码 - 道达智装'
    }
  },
  props: {
    verify: 123333
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: 'user', to: '/user/profile'},
        {text: '密码', href: '#'}
      ],
      passwd: '',
      newpasswd: '',
      renewpasswd: '',
      passwd_focus: false,
      newpasswd_focus: false,
      renewpasswd_focus: false
    }
  },
  methods: {
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.post('admin/passwd', {
        passwd: this.passwd,
        newpasswd: this.newpasswd,
        renewpasswd: this.renewpasswd
      }).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'success',
            dismissible: false
          })
          setTimeout(() => {
            this.$sess.logout(this.$cache)
            this.$store.state.is_login = false
            this.$router.push({path: '/login'})
          }, 1500)
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
    submit: function (e) {
      if (this.passwd === '') {
        this.$notify({
          content: '请您输入旧密码',
          duration: 2000,
          type: 'danger',
          dismissible: false
        })
        this.passwd_focus = true
      } else if (this.newpasswd === '') {
        this.$notify({
          content: '请输入您新的密码',
          duration: 2000,
          type: 'danger',
          dismissible: false
        })
        this.newpasswd_focus = true
      } else if (this.renewpasswd === '') {
        this.$notify({
          content: '请两次输入的密码保持一致',
          duration: 2000,
          type: 'danger',
          dismissible: false
        })
        this.renewpasswd_focus = true
      } else {
        this.refresh()
      }
    }
  }
}
</script>
<style scoped>
.passwd {
  background: #fff;
}
label {
  font-size: 14px;
}
input {
  font-size: 12px;
}
</style>
