<template>
  <div class="container">
    <Head></Head>
    <entityBanner></entityBanner>
    <example></example>
    <chinamap></chinamap>
    <foot></foot>
    <sideBar></sideBar>
  </div>
</template>
<script>
import Head from './head'
import entityBanner from './entity-banner'
import example from './example'
import Chinamap from './Chinamap'
import foot from './foot'
import sideBar from './sidebar'
export default {
  name: 'experience',
  metaInfo () {
    const title = '实体网点 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  components: {
    Head, entityBanner, example, Chinamap, foot, sideBar
  }
}
</script>
<style scoped>
  .container {
    width: 100%;
    height: 100%;
  }
</style>
