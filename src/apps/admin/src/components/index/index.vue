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
  metaInfo: {
    title: '首页 - 道达智装'
  },
  data () {
    return {}
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
