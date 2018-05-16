<template>
  <div class="advert">
    <div class="middle">
      <ul class="box">
        <li class="left">
          <img src="../assets/home/factory.png" height="79" width="97">
          <p>工厂</p>
        </li>
        <li class="mid">
          <img src="../assets/home/ad-dz.png" height="45" width="120">
          <div class="line"></div>
          <p>自有工厂 自有品牌 工厂直销有保障</p>
          <p>自建仓库 省去运输费用</p>
        </li>
        <li class="right">
          <img src="../assets/home/family.png" height="73" width="87">
          <p>家</p>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  name: 'advert'
}
</script>
<style scoped>
  .advert {
    background: url("../assets/home/abanana.png")  no-repeat;
    background-size: 100%;
    margin-bottom: 88px;
    margin-top: 80px;
    opacity: 0.8;
    height: 250px;
    position: relative;
  }
  .middle {
    /*width: 100%;*/
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
  }
  .box {
    width: 100%;
    /*height: 160px;*/
    /*margin-left: 100px;*/
  }
  .box li {
    /*float: left;*/
    display: inline-block;
  }
  .left {
    width: 160px;
    height: 120px;
    margin-top: 65px;
  }
  .mid {
    width: 34%;
    height: 120px;
    margin-top: 50px;
  }
  .mid img {
    margin-bottom: 12px;
  }
  .mid .line {
    /*width: 668px;*/
    height: 3px;
    margin-bottom: 16px;
    background-color: #ffffff;
  }
  .mid p{
    font-size: 13px;
    margin: 0 auto;
    line-height: 24px;
    color: #ffffff;
  }
  .right {
    width: 160px;
    height: 120px;
    margin-top: 65px;
  }
  .left p, .right p {
    color: #fff;
    font-size: 16px;
    margin-top: 10px;
  }
</style>
