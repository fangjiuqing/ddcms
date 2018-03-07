<template>
  <div id="app">
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
</template>

<script>
export default {
  name: 'App'
}
</script>
