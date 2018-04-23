<template>
  <div class="standard">
    <h3>智装工艺标准化</h3>
    <p class="subhead">专业装修，全面审核，明星工长任意挑选</p>
    <ul class="list">
      <li>
        <p class="title">84项工程标准规范</p>
        <p class="con">确保施工品质</p>
      </li>
      <li></li>
    </ul>
    <ul class="line">
      <li></li>
      <li>
        <p class="title">强弱电分开走线</p>
        <p class="con">避免影响信号</p>
      </li>
    </ul>
    <ul class="more">
      <li>
        <p class="title">兼容行业标准</p>
        <p class="con">升级扩张更方便</p>
      </li>
      <li></li>
    </ul>
  </div>
</template>
<script>
export default {
  name: 'standard'
}
</script>
<style scoped>
.standard {
  width: 100%;
  height: 896px;
  background-color: #f3f3f3;
}
.standard h3 {
  padding-top: 49px;
  margin-bottom: 11px;
  font-size: 36px;
  text-align: center;
  color: #3e3a39;
}
.subhead {
  color: #595757;
  text-align: center;
  font-size: 18px;
  margin-bottom: 51px;
}
.list, .line, .more {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}
.list li:nth-child(2) {
  background: url(../assets/home/paint.png) center/cover no-repeat;
}
.line li:nth-child(1) {
  background: url(../assets/home/ddzzh.png) center/cover no-repeat;
}
.more li:nth-child(2) {
  background: url(../assets/home/dzline.png) center/cover no-repeat;
}
.list li, .line li, .more li {
  width: 352px;
  height: 224px;
  display: flex;
  background-color: #ffffff;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.list li:nth-child(1), .line li:nth-child(2), .more li:nth-child(1)  {
  position: relative;
}
.list li:nth-child(1):after{
  content: "";
  width: 0;
  height: 0;
  position: absolute;
  left: 50%;
  top: 99%;
  margin-left: -14px;
  border-right: solid 28px transparent;
  border-top: solid 28px white;
  border-left: solid 28px transparent;
}
.line li:nth-child(2):after{
  content: "";
  width: 0;
  height: 0;
  position: absolute;
  left: 50%;
  bottom: 99%;
  margin-left: -14px;
  border-right: solid 28px transparent;
  border-bottom: solid 28px white;
  border-left: solid 28px transparent;
}
.more li:nth-child(1):after{
  content: "";
  width: 0;
  height: 0;
  position: absolute;
  top: 50%;
  left: 99%;
  margin-top: -14px;
  border-top: solid 28px transparent;
  border-left: solid 28px white;
  border-bottom: solid 28px transparent;
}
.title {
  font-size: 24px;
  color: #333333;
  margin-bottom: 11px;
}
.con {
  font-size: 18px;
  color: #595757;
}
</style>
