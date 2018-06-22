<template>
  <div>
    <sideBar/>
    <Head/>
    <index/>
    <chose/>
    <quality/>
    <Advert/>
    <strict/>
    <famous/>
    <standard/>
    <owner/>
    <foot/>
  </div>
</template>

<script>
import Head from './head.vue'
import Chose from './chose.vue'
import Strict from './strict.vue'
import Advert from './advert.vue'
import Famous from './famous.vue'
import Owner from './owner.vue'
import Quality from './quality.vue'
import Standard from './standard.vue'
import Index from './index2.vue'
import Foot from './foot.vue'
import sideBar from './sidebar'
export default {
  name: 'Header',
  metaInfo () {
    const title = '首页 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  sidebar: false,
  data () {
    return {
    }
  },
  components: {
    Head, Quality, Chose, Advert, Strict, Famous, Standard, Owner, Index, Foot, sideBar
  }
}
</script>
<style scoped>
</style>
