<template>
  <div class="designteam">
    <div class="mid">
      <p>设计团队结合30000多家客户的真实需求</p>
      <p>总结、提炼，打造标准化家装</p>
      <span>客户真实需求提炼、实施经验总结，打造标准化家装</span>
      <img src="../assets/scheme/demand.png" alt="">
    </div>
  </div>
</template>
<script>
export default {
  name: 'team'
}
</script>
<style scoped>
.designteam {
  width: 100%;
  height: 940px;
  background-color: #f7f7f7;
  padding-top: 83px;
  margin-bottom: 86px;
  background-color: #f7f7f7;
}
.mid {
  width: 1200px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
}
p {
  color: #333333;
  line-height: 54px;
  font-size: 36px;
  text-align: center;
}
span {
  line-height: 54px;
  color: #666666;
  text-align: center;
  margin-bottom: 66px;
}
</style>
