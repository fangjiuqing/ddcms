<template>
  <div>
    <Head></Head>
    <Foot></Foot>
  </div>
</template>
<script>
import Head from './head-nav'
import Foot from './footNav'
export default {
  name: 'serve',
  components: {
    Head, Foot
  }
}
</script>
<style scoped>
</style>
