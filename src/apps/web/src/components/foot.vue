<template>
<div class="content">
  <div class="top">
    <div class="left">
      <h3>道达智装</h3>
      <img src="../assets/home/future.png" alt="">
    </div>
    <div class="right">
      <div class="right-phone">
        <ul class="list">
          <li>关于我们</li>
          <li>联系我们</li>
          <li>
            <router-link :to="{name: 'join-us'}" exact>
              加入我们
            </router-link>
          </li>
          <li>意见反馈</li>
        </ul>
        <p class="phone">
          <span>400-880-1908</span>
        </p>
        <p class="address">地址：上海市黄浦区北京东路666号科技京城C区907</p>
        <p class="email address">Emall：shangwu@xiaoguanjia.com</p>
      </div>
    </div>
    <ul class="qrlist">
      <li>
        <div class="qr"></div>
        <p>道达智装APP下载</p>
      </li>
      <li class="qr-r">
        <div class="qr"></div>
        <p>道达智装微信客服</p>
      </li>
    </ul>
  </div>
  <p class="copy">Copyright ®2018 小管家智能芯片科技（上海）有限公司 版权所有沪ICP备15007819号-1</p>
</div>
</template>
<script>
export default {
  name: 'foot'
}
</script>
<style scoped>
  .content {
    width: 100%;
    height: 265px;
    position: relative;
    background: url('../assets/home/foot-bg.png') no-repeat;
  }
  @media screen and (min-width: 1920px) {
    .content {
      width: 1920px;
      left: 0;
      right: 0;
      margin: 0 auto;
    }
  }
  .top {
     width: 80%;
     height: 116px;
     position: absolute;
     left: 0;
     right: 0;
     /*top: 0;*/
     /*bottom: 0;*/
     margin: auto;
    padding: 42px;
    border-bottom: 2px solid rgba(255, 255, 255, 0.2);
   }
  .left {
    height: 80px;
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    margin: auto 0;
  }
  .left h3 {
    font-size: 36px;
    margin-bottom: 13px;
    color: #ffffff;
  }
  .left p {
    font-size: 30px;
    color: #ffffff;
    margin-top: 18px;
  }
  .right {
    position: absolute;
    left: 360px;
  }
  .list {
    text-align: left;
  }
  .list li {
    display: inline-block;
    font-family: MicrosoftYaHei;
    font-size: 18px;
    color: #ffffff;
    margin-right: 44px;
  }
  .list li a {
    color: #fff;
  }
  p {
    text-align: left;
    margin-top: 17px;
  }
  .phone span {
    font-size: 24px;
    color: #ffffff;
  }
  .phone span:before {
    content: '';
    display: inline-block;
    width: 33px;
    height: 33px;
    background: url("../assets/home/phone.png") no-repeat;
    background-size: 33px;
    vertical-align:middle;
    margin-right: 12px;
  }
  .address {
    font-size: 14px;
    color: #ffffff;
    margin-bottom: 11px;
  }
  .qrlist {
    font-size: 14px;
    color: #ffffff;
    position: absolute;
    right: 0;
  }
  .qrlist li {
    display: inline-block;
    margin-left: 53px;
  }
  .qr {
    width: 115px;
    height: 115px;
    background: url("../assets/home/qr.png") no-repeat;
    background-size: 115px 115px;
  }
  .copy {
    position: absolute;
    bottom: 24px;
    left: 0;
    right: 0;
    text-align: center;
    font-family: MicrosoftYaHeiLight;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.5);
  }
  @media screen and (max-width: 1280px) {
    .top {
      width: 1068px!important;
    }
  }
</style>
