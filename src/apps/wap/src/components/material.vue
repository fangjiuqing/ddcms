<template>
  <div>
    <headNav></headNav>
      <banner></banner>
      <quality></quality>
      <brand></brand>
      <footNav></footNav>
    </div>
</template>
<script>
import headNav from './head-nav'
import Banner from './index'
import Quality from './quality'
import Brand from './brand'
import FootNav from './footNav'
export default {
  name: 'material',
  components: {
    headNav, Banner, Quality, Brand, FootNav
  }
}
</script>
<style scoped>
</style>
