<template>
  <div>
    <div class="black">
      <div class="nav">
        <div class="rl">
          <span>登录</span>
          <span>注册</span>
        </div>
      </div>
    </div>
    <div class="topSearch">
      <div class="logo"></div>
      <div class="left">优材商城</div>
      <div class="mar">
        <input type="text" class="search" placeholder="瓷砖类"/>
        <p>搜索</p>
        <div class="shop">
          <span>购物车</span>
        </div>
      </div>
    </div>
    <div class="commodity">
      <div class="all">
        <p>全部商品分类</p>
        <ul>
          <li>限时抢购</li>
          <li>品牌特卖</li>
          <li>爆款拼团</li>
          <li>智能家居馆</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'common'
}
</script>

<style scoped>
  .black {
    width: 100%;
    height: 48px;
    background: #171717;
  }
  .nav {
    width: 1200px;
    height: 48px;
    margin: 0 auto;
    position: relative;
  }
  .rl {
    font-size: 14px;
    color: #ffffff;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
  }
  .rl span:nth-child(1):before {
    display: inline-block;
    content: '';
    width: 16px;
    height: 16px;
    margin-right: 16px;
    background: url("../assets/home/nav/lr.png");
  }
  .rl span:nth-child(1):after {
    width: 1px;
    height: 11px;
    background-color: #ffffff;
    display: inline-block;
    content: '';
    margin: 0 8px;
  }
  .topSearch {
    width: 1200px;
    height: 68px;
    margin: 24px auto 0;
    text-align: left;
    overflow: hidden;
  }
  .logo {
    width: 68px;
    height: 68px;
    display: inline-block;
    background: url("../assets/home/logo.png") no-repeat;
    float: left;
  }
  .left {
    width: 156px;
    font-size: 28px;
    letter-spacing: 1px;
    color: #3e3a39;
    font-weight: bold;
    margin: 8px 0 0 22px;
    float: left;
  }
  .left:after {
    width: 156px;
    height: 25px;
    content: '';
    display: block;
    margin-top: 8px;
    background: url("../assets/home/mall.png");
  }
  .mar {
    margin-top: 17px;
  }
  .search {
    width: 436px;
    height: 38px;
    margin-left: 101px;
    padding-left: 15px;
    border: solid 1px #d8d8d8;
    float: left;
  }
  .topSearch p {
    width: 88px;
    height: 42px;
    background-color: #d42f31;
    text-align: center;
    line-height: 42px;
    font-size: 16px;
    color: #ffffff;
    float: left;
  }
  .shop {
    width: 100px;
    height: 38px;
    border: solid 1px #d8d8d8;
    margin-left: 102px;
    line-height: 38px;
    text-align: center;
    float: left;
  }
  .shop span {
    font-size: 14px;
    color: #3a3a3a;
  }
  .shop span:before {
    width: 17px;
    height: 17px;
    display: inline-block;
    content: '';
    background: url("../assets/home/shopCar.png");
    margin-right: 9px;
    vertical-align: middle;
  }
  .commodity {
    width: 1200px;
    margin: 16px auto 0;
    text-align: left;
  }
  .all {
    /*position: relative;*/
  }
  .all p {
    width: 280px;
    height: 51px;
    background-color: #f3f3f3;
    /*box-shadow: 0 15px 29px 0 rgba(0, 0, 0, 0.1);*/
    font-size: 18px;
    color: #3e3a39;
    text-align: center;
    line-height: 51px;
    display: inline-block;
  }
  .all ul {
    margin-left: 32px;
    display: inline-block;
  }
  .all > ul li {
    display: inline-block;
    font-size: 16px;
    color: #3e3a39;
    margin-right: 49px;
  }
</style>
