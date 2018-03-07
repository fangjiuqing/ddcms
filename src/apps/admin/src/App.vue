<template>
  <div id="app">
    <div v-if="$store.state.is_login">
      <div class="app_mask"></div>
      <vue-progress-bar></vue-progress-bar>
      <transition name="bounce">
        <keep-alive>
        <div class="app_wrap">
          <div class="app_layer">
            <Topbar/>
            <Leftbar/>
            <section class="app_main">
                <router-view/>
            </section>
          </div>
        </div>
        </keep-alive>
      </transition>
    </div>
    <div v-else>
      <div class="app_mask"></div>
      <vue-progress-bar></vue-progress-bar>
      <router-view/>
    </div>
  </div>
</template>

<script>
import store from '@/store'

export default {
  name: 'App',
  store,
  beforeMount: function () {
    this.$http.post('user/info', {}).then(d => {
      if (d.code === 0) {
        this.$store.state.is_login = true
        this.$cache.set('login', d.data)
      } else {
        this.$router.push({path: '/login'})
      }
    })
  }
}
</script>
