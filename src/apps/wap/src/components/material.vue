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
  metaInfo () {
    const title = '国际优材 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  components: {
    headNav, Banner, Quality, Brand, FootNav
  }
}
</script>
<style scoped>
</style>
