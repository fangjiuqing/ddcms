<template>
  <div class="profile">
    <breadcrumbs :items="items"/>
    <div class="app_page">
      
    </div>
  </div>
</template>

<script>
export default {
  name: 'Profile',
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '我的资料', to: '/user/profile'},
        {text: '修改', href: '#'}
      ]
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/user'
  },
  activated: function () {
    this.$store.state.left_active_key = '/user'
  }
}
</script>
