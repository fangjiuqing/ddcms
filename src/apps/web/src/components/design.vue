<template>
  <div class="design">
    <Head></Head>
    <designList></designList>
    <foot></foot>
    <sideBar></sideBar>
  </div>
</template>
<script>
import Head from './head.vue'
import designList from './designList'
import foot from './foot'
import sideBar from './sidebar'
export default {
  name: 'design',
  metaInfo () {
    const title = '设计名家 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  components: {
    Head, foot, designList, sideBar
  }
}
</script>
<style scoped>
</style>
