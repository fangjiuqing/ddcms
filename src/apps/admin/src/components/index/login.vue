<template>
  <div class="login">
    <div class="login-wrapper">
      <div class="login-form">
        <form>
          <div class="form-group">
            <input type="email" class="form-control" v-model.lazy="account" placeholder="用户名">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" autocomplete="off" v-model.lazy="passwd" placeholder="密码" maxlength="32">
          </div>
          <button type="button" @click="submit" class="btn btn-primary btn-default">登录</button>
        </form>
      </div>
      <h3>&copy; 道达智装 业务管理平台 v1.0.0 </h3>
    </div>
</div>
</template>

<style scoped>
    .login {
      margin-top: 0;
      padding-top: 60px;
      background: #17a2b8;
      height: calc(100%);
      position: fixed;
      width: 100%;
      top: 0;
    }
    .login-wrapper .login-form {
      background-color: rgba(255, 255, 255, 0.3);
      padding: 30px 40px;
      border-radius: 5px;
      border-radius: 2px;
    }
    .login-wrapper h3 {
      font-size: 13px;
      font-weight: 200;
      color: #ccc;
      text-align: center;
    }

    .login-wrapper .login-form .form-group label {
      font-size: 14px;
      font-weight: 350;
      color: #353535;
    }

    .login-wrapper .login-form .form-group input[type="password"] {
      letter-spacing: 10px;
    }
</style>

<script>
export default {
  name: 'Login',
  metaInfo: {
    title: '登录 - 道达智装'
  },
  props: {
    verify: 123333
  },
  data () {
    return {
      account: '',
      account_focus: false,
      passwd: '',
      passwd_focus: false
    }
  },
  methods: {
    submit: function (e) {
      if (this.account === '') {
        this.$notify({
          content: '请输入您的用户名',
          duration: 2000,
          type: 'info',
          dismissible: false
        })
        this.account_focus = true
      } else if (this.passwd === '') {
        this.$notify({
          content: '请输入您的密码',
          duration: 2000,
          type: 'info',
          dismissible: false
        })
        this.passwd_focus = true
      } else {
        this.exec_login()
      }
    },

    exec_login: function () {
      this.$loading.show({
        'msg': '请求中, 请稍后 ...',
        left_offset: '0px',
        type: 'loading'
      })
      this.$http.post('index/login', {
        account: this.account,
        passwd: this.passwd
      }).then(d => {
        if (d.code !== 0) {
          this[d.data.via + '_focus'] = true
          this.$loading.hide()
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'danger',
            dismissible: false
          })
        } else {
          this.$loading.show({
            msg: '获取信息中 ...',
            type: 'info',
            left_offset: '0px'
          })
          this.$cache.set('access_token', d.data['access_token'])
          this.$http.post('user/info', {}).then(d => {
            this.$loading.hide()
            if (d.code !== 0) {
              this.$notify({
                content: d.msg,
                duration: 2000,
                type: 'danger',
                dismissible: false
              })
            } else {
              this.$cache.set('login', d.data)
              location.href = '/'
            }
          })
        }
      })
    }
  }
}
</script>
