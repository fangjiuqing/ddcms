<template>
  <div class="app_topbar">
    <nav class="navbar navbar-default">
      <router-link class="navbar-brand" slot="brand" :to="{path: '/', exact: true}">
        道达智装
      </router-link>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <dropdown ref="dropdown">
              <img src="@/assets/images/avatar.jpg" class="dropdown-toggle topbar_avatar">
              <template slot="dropdown">
                <li><router-link :to="{path: '/', extra: true}">管理主页</router-link></li>
                <li role="separator" class="divider"></li>
                <li><router-link :to="{path: '/user/profile', extra: true}">我的资料</router-link></li>
                <li><router-link :to="{path: '/user/passwd', extra: true}">修改密码</router-link></li>
                <li role="separator" class="divider"></li>
                <li><a v-on:click="logout">注销登录</a></li>
              </template>
            </dropdown>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
import store from '@/store'
export default {
  name: 'topbar',
  store,
  methods: {
    logout: function () {
      this.$sess.logout(this.$cache)
      this.$store.state.is_login = false
      this.$router.push({path: '/login'})
    }
  }
}
</script>
