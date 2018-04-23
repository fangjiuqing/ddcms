<template>
  <div class="quality">
    <div class="quality-title">
      <h2>优选材料&nbsp;质量保证</h2>
      <p class="filter">用料考究，层层筛选，品质保证</p>
    </div>
    <div class="tile">
      <img src="../assets/material/tile.png" alt="">
    </div>
    <div class="standard">
      <h3>瓷砖质量标准</h3>
      <div class="line"></div>
      <p>ICOLOR选用的瓷砖</p>
      <p>(室内墙地面砖为釉面砖和通体砖)均高于国家、</p>
      <p>地方及行业标准,室内地砖表面</p>
      <p>必须具有优秀的防滑功能,室内墙面釉面每块瓷砖的平均相</p>
      <p>对工作尺寸的允许偏差不得大于±0.5%,厚度偏</p>
      <p>差控制在±10%、边直角控制在±0.2%、直角度控±0.3%,</p>
      <p>表面平整,釉质均匀,垂直</p>
      <p>观测无缺陷。</p>
    </div>
    <div class="floor">
      <img src="../assets/material/floor.png" alt="">
    </div>
    <div class="standard">
      <h3>地板质量标准 </h3>
      <div class="line"></div>
      <p>执行国家标准，</p>
      <p>精选全国优秀的供应商，严格执行国家标准，</p>
      <p>在全球范围内优选知名供应，所有地板环保等级均达到</p>
      <p>国标E1级或F★★★★级安装团队经过专</p>
      <p>业的培训，掌握严格的安装标准。为您打造舒适安</p>
      <p>心的家居环境</p>
    </div>
    <div class="tile">
      <img src="../assets/material/bathroom.png" alt="">
    </div>
    <div class="standard">
      <h3>卫浴质量标准</h3>
      <div class="line"></div>
      <p>道达智装一直秉持着</p>
      <p>环保的理念，选用的卫浴洁具均为节水型，</p>
      <p>在保证正常使用的同时最大程度的节约用水。合理的水</p>
      <p>封深度保证在极端的使用情况下不</p>
      <p>均无裂纹、棕眼、斑点、凹凸等缺陷，釉面均匀色差不等</p>
      <p>超过3，保证美观的同时，</p>
      <p>便于清理。</p>
    </div>
    <div class="floor">
      <img src="../assets/material/kitchen.png" alt="">
    </div>
    <div class="standard">
      <h3>厨房电器质量标准</h3>
      <div class="line"></div>
      <p>道达智装厨房电器的技术指标</p>
      <p>和性能满足但不限于GB4706.1-2005等国家标准。</p>
      <p>对厨房使用体验影响最大的是油烟机、炉具,</p>
      <p>故iColor要求油烟机风量≥10m³/min 风压≥100PA</p>
      <p>全压效率≥11%，</p>
      <p>声噪≤72Db，油脂分离度≥90%，</p>
      <p>气味降低度≥80%</p>
    </div>
  </div>
</template>
<script>
export default {
  name: 'quality'
}
</script>
<style scoped>
.quality {
  display: flex;
  height: 100%;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.quality-title {
  padding-top: 38px;
}
h2 {
  display: flex;
  justify-content: center;
  width: 100%;
  font-size: 36px;
  color: #111;
}
p {
  display: flex;
  padding-top: 10px;
  color: #595757;
  justify-content: center;
}
.filter {
  margin-bottom: 42px;
  font-size: 18px;
}
.tile, .floor {
  width: 531px;
  height: 355px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  box-shadow: 0px 6px 18px 0px;
  color: rgba(0, 0, 0, 0.15);
}
.tile img{
  width: 401px;
  height: 294px;
}
.floor img {
  width: 531px;
  height: 355px;
}
.standard {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 32px 0;
}
.standard h3 {
  font-size: 28px;
  color: #111;
}
.line {
  width: 80px;
  height: 1px;
  margin: 11px 0 15px 0;
  background-color: #a6a6a6;
}
.standard p {
  font-size: 24px;
  line-height: 36px;
  color: #595757;
}
</style>
