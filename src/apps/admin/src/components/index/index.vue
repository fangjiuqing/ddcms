<template>
    <div class="app_wrap">
      <div class="app_layer">
        <Topbar/>
        <Leftbar/>
        <section class="app_main">
            <router-view/>
        </section>
      </div>
    </div>
</template>

<script>
export default {
  name: 'Index',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
