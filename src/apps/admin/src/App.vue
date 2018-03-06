<template>
  <div id="app">
    <div class="app_mask"></div>
    <vue-progress-bar></vue-progress-bar>
    <transition name="right-fade">
      <keep-alive>
        <router-view></router-view>
      </keep-alive>
    </transition>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>
