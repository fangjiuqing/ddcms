<template>
  <div class="passwd">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="reps" style="width:60%">
      <h2 class="repswd col-sm-12 col-sm-pull-5">修改密码</h2>
      <form class="form">
        <div class="row">
          <div class="form-group">
            <label for="passwd" class="col-sm-2 label-on-left">*旧 &nbsp;密 &nbsp;码：</label>
            <div class="col-sm-4">
              <input type="password" class="form-control" id="passwd" placeholder="请输入旧密码" v-model.lazy="passwd" v-focus="passwd_focus">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <label for="newpasswd" class="control-label col-sm-2 label-on-left">*设置密码：</label>
            <div class="col-sm-4">
              <input type="password" class="form-control" id="newpasswd" placeholder="请输入新密码"  autocomplete="off" v-model.lazy="newpasswd" v-focus="newpasswd_focus">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <label for="renewpasswd" class="control-label col-sm-2 label-on-left">*确认密码：</label>
            <div class="col-sm-4">
              <input type="password" class="form-control" id="renewpasswd" placeholder="两次输入的新密码保持一致" v-model.lazy="renewpasswd" v-focus="renewpasswd_focus">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-sm btn-info" @click.prevent="submit">确认修改</button>
            </div>
          </div>
        </div>
      </form>
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
.reps {
  padding-left: 50px;
}
.row {
  margin-bottom: 20px;
}
h2 {
  color: #337ab7;
}
label {
  font-size: 14px;
}
input {
  font-size: 12px;
}
</style>
