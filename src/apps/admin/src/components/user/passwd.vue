<template>
  <div class="passwd">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <form class="form-horizontal">
      <div class="form-group">
        <label for="passwd" class="col-sm-1 control-label">旧密码：</label>
        <div class="col-sm-2">
          <input type="password" class="form-control" id="passwd" placeholder="请输入旧密码" v-model.lazy="passwd" v-focus="passwd_focus">
        </div>
      </div>
      <div class="form-group">
        <label for="newpasswd" class="col-sm-1 control-label">设置密码：</label>
        <div class="col-sm-2">
          <input type="password" class="form-control" id="newpasswd" placeholder="请输入新密码"  autocomplete="off" v-model.lazy="newpasswd" v-focus="newpasswd_focus">
        </div>
      </div>
      <div class="form-group">
        <label for="renewpasswd" class="col-sm-1 control-label">确认密码：</label>
        <div class="col-sm-2">
          <input type="password" class="form-control" id="renewpasswd" placeholder="两次输入的新密码保持一致" v-model.lazy="renewpasswd" v-focus="renewpasswd_focus">
        </div>
      </div>
      <div>
        <div class=" col-sm-4">
          <button type="submit" class="btn btn-primary btn-default" @click.prevent="submit">确认修改</button>
        </div>
      </div>
    </form>
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
        this.passwd = d.data.newpasswd
        this.$cache.set('access_token', d.data['access_token'])
        if (d.code === 0) {
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'danger',
            dismissible: false
          })
          this.$sess.logout(this.$cache)
          this.$store.state.is_login = false
          this.$router.push({path: '/login'})
          this.passwd = d.data.passwd
          this.newpasswd = ''
          this.renewpasswd = ''
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
          type: 'info',
          dismissible: false
        })
        this.passwd_focus = true
      } else if (this.newpasswd === '') {
        this.$notify({
          content: '请输入您新的密码',
          duration: 2000,
          type: 'info',
          dismissible: false
        })
        this.newpasswd_focus = true
      } else if (this.renewpasswd === '') {
        this.$notify({
          content: '请两次输入的密码保持一致',
          duration: 2000,
          type: 'info',
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
  height: calc(100%);
  position: fixed;
  width: 100%;
  background: url("../../assets/themes/v1/images/image_placeholder.jpg") center/cover no-repeat;
}
label {
  float: left;
  font-size: 18px;
  margin: 0;
  color: yellowgreen;
}
.form-horizontal {
  width: 1700px;
  padding: 100px 0 0 50px;
}
.btn {
  font-size: 16px;
}
</style>
