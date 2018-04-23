<template>
  <div class="brand">
    <div class="choice">
      <p class="title">精选国内外一线品牌</p>
      <p class="title">20+合作商 选材耐用环保</p>
    </div>
    <p class="content">道达智装拥有强大的供应链体系和严格的选材标准机制，所选用材以环保</p>
    <p class="content">健康为基础标准，精选国内外一线品牌，给业主更好的品质保证。</p>
    <div class="brand-img">
      <img src="../assets/material/brand.png" alt="" class="many">
      <img src="../assets/material/footbanner.png" alt="" class="banner">
    </div>
  </div>
</template>
<script>
export default {
  name: 'stand'
}
</script>
<style scoped>
.brand {
  display: flex;
  flex-direction: column;
}
.title {
  display: flex;
  justify-content: center;
  align-items: center;
  color: #111;
  font-size: 36px;
  line-height: 46px;
}
.content {
  display: flex;
  justify-content: center;
  font-size: 20px;
  line-height: 35px;
}
.choice {
  margin-bottom: 32px;
}
.brand-img {
  padding-top: 32px;
}
.many {
  width: 100%;
}
.banner {
  width: 100%;
}
</style>
