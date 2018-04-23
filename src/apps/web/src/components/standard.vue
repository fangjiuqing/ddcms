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
      <li>
        <p class="title">强弱电分开走线</p>
        <p class="con">避免影响信号</p>
      </li>
      <li></li>
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
  name: 'standard',
  data () {
    return {
      banners: []
    }
  }
}
</script>
<style scoped>
  .standard {
    padding-top: 120px;
    position: relative;
    width: 100%;
    height: 900px;
    background-color: #f3f3f3;
  }
  h3 {
    font-size: 40px;
    color: #111;
    text-align: center;
    margin-bottom: 15px;
  }
  .subhead {
    font-size: 20px;
    color: #595757;
    text-align: center;
  }
  .list {
    width: 1280px;
    height: 556px;
    text-align: center;
    position: absolute;
    left: 0;
    right: 0;
    margin: 0 auto;
    margin-top: 88px;
  }
  .list li {
    width: 420px;
    height: 280px;
    float: left;
    background-color: #ffffff;
  }
  .list li p {
    position: relative;
    top: 50%;
    transform: translateY(-50%);
  }
  .list li:nth-child(2) {
    background: url(../assets/home/ddzzh.png) center/cover no-repeat;
  }
  .list li:nth-child(4) {
    background: url(../assets/home/paint.png) center/cover no-repeat;
  }
  .list li:nth-child(6) {
    background: url(../assets/home/dzline.png) center/cover no-repeat;
  }
  .title {
    font-size: 30px;
    color: #333333;
    margin-bottom: 16px!important;
  }
  .con {
    font-size: 22px;
    color: #595757;
  }
  .list li:nth-child(1), .list li:nth-child(3), .list li:nth-child(5)  {
    position: relative;
  }
  .list li:nth-child(1):after{
    content: "";
    width: 0;
    height: 0;
    position: absolute;
    left: 50%;
    top: 100%;
    margin-left: -19px;
    border-right: solid 38px transparent;
    border-top: solid 38px white;
    border-left: solid 38px transparent;
  }
  .list li:nth-child(3):after{
    content: "";
    width: 0;
    height: 0;
    position: absolute;
    left: 50%;
    top: 100%;
    margin-left: -19px;
    border-right: solid 38px transparent;
    border-top: solid 38px white;
    border-left: solid 38px transparent;
  }
  .list li:nth-child(5):after{
    content: "";
    width: 0;
    height: 0;
    position: absolute;
    left: 50%;
    bottom: 100%;
    margin-left: -19px;
    border-right: solid 38px transparent;
    border-bottom: solid 38px white;
    border-left: solid 38px transparent;
  }
</style>
