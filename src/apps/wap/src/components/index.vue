<template>
  <div>
    <div class="banner"></div>
    <div class="topIntr">
      <h3>严苛标准只为您的健康</h3>
      <div class="content">
        <p>为了给业主一个健康安全的家,道达智装在家具板材以及涂料的选择与加工制作方面精益求精，追求实用性和安全性。所选橱柜、整屋定制柜供应商为国内或国际知名品牌。供应商具有"高精度、高效率，高质量"的智能化机器设备，贴心的设计安装团队以及专业的售后保障团队。</p>
      </div>
      <div class="strict">
        <p>所选家具板材甲醛含量均达到国标E1级标准。所选石英石台面均获得GREENGUARD（美国室内空气质量认证）、NSF（美国卫生食品安全认证）、ISFA（美国实体面材协会会员）认证。努力给您和您的家人一个健康的环境。</p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'banner'
}
</script>
<style scoped>
.banner {
  height: 374px;
  position: relative;
  margin-top: 88px;
  background: rgba(0, 0, 0, 0.1) url(../assets/material/banner.png) center/cover no-repeat;
}
.topIntr {
  width: 93.6%;
  height: 500px;
  padding-top: 37px;
  background-color: #fcfcfc;
  box-shadow: 0 15px 60px 0 rgba(0, 0, 0, 0.1);
  position: relative;
  top: -65px;
  left: 0;
  right: 0;
  margin: 0 auto;
}
h3 {
  text-align: center;
  font-size: 36px;
  color: #3e3a39;
  margin: 0 0 27px;
}
.content {
  width: 91%;
  font-size: 24px;
  margin: 0 auto 50px;
}
.content p {
  color: #898989;
  text-align: left;
  line-height: 36px;
}
.strict {
  width: 91%;
  margin: 0 auto 40px;
  font-size: 24px;
}
.strict p{
  color: #898989;
  text-align: left;
  line-height: 36px;
}
</style>
