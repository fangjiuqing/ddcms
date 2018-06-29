<template>
  <div class="header">
    <div class="black">
      <div class="nav">
        <div class="rl">
          <router-link :to="{name: 'personal'}">
          <span @click="login">登录</span>
          </router-link>
          <span @click="regist">注册</span>
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
          <li>
            <a href="javascript:;">限时抢购</a>
          </li>
          <li>
            <a href="javascript:;">品牌特卖</a>
          </li>
          <li>
            <a href="javascript:;">爆款拼团</a>
          </li>
          <li>
            <a href="javascript:;">智能家居馆</a>
          </li>
        </ul>
      </div>
    </div>
     <div class="content" v-show="loginin">
      <div class="tasking" @click="fal"></div>
      <div class="confirm">
        <div class="online">
          <h3>手机号登录</h3>
          <form action="" class="formdata">
            <p class="sm" @click="fals">使用短信验证登录</p>
            <div class="chose">
              <input type="text" placeholder="请输入手机号" class="acreage">
              <input type="text" placeholder="请输入您的密码" class="acreage acr">
            </div>
            <div class="auto">
              <input type="checkbox"><span>下次自动登录</span>
            </div>
            <p class="forget">忘记密码</p>
            <div class="submit">
              <button>登陆</button>
            </div>
            <ul class="loginin">
              <li></li>
              <li></li>
              <li></li>
              <p>手机快捷注册</p>
            </ul>
          </form>
        </div>
      </div>
    </div>
    <div class="content" v-show="register">
      <div class="tasking" @click="reg"></div>
      <div class="confirm">
        <div class="online">
          <h3>手机号注册</h3>
          <form action="" class="formdata">
            <p class="sm" @click="regis">直接登录</p>
            <div class="chose">
              <input type="text" placeholder="请输入手机号" class="acreage">
              <input type="text" placeholder="请输入短信验证码" class="acreage"><span>获取验证码</span>
              <input type="text" placeholder="请输入您的密码" class="acreage">
            </div>
            <div class="submit sub">
              <button>注册</button>
            </div>
            <div class="auto agree">
              <input type="checkbox"><span>我同意《服务条款》和《道达隐私政策》</span>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="content" v-show="logining">
      <div class="tasking" @click="logi"></div>
      <div class="confirm">
        <div class="online">
          <h3>手机号登录</h3>
          <form action="" class="formdata">
            <p class="sm" @click="logs">使用密码验证登录</p>
            <div class="chose">
              <input type="text" placeholder="请输入手机号" class="acreage">
              <input type="text" placeholder="请输入短信验证码" class="acreage"><span>获取验证码</span>
            </div>
            <div class="auto">
              <input type="checkbox"><span>下次自动登录</span>
            </div>
            <p class="forget">忘记密码</p>
            <div class="submit">
              <button>登陆</button>
            </div>
            <ul class="loginin">
              <li></li>
              <li></li>
              <li></li>
              <p>手机快捷注册</p>
            </ul>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'topHead',
  data () {
    return {
      loginin: false,
      logining: false,
      register: false
    }
  },
  methods: {
    login () {
      this.loginin = true
    },
    fal () {
      this.loginin = false
    },
    logi () {
      this.logining = false
    },
    fals () {
      this.logining = true
      this.loginin = false
    },
    logs () {
      this.logining = false
      this.loginin = true
    },
    regist () {
      this.register = true
    },
    reg () {
      this.register = false
    },
    regis () {
      this.register = false
      this.loginin = true
    }
  }
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
  .rl a {
    color: #fff;
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
    cursor: pointer;
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
  .all ul li a {
    color: #3e3a39;
  }
  /*登录弹窗*/
  .confirm {
    z-index: 9999;
    width: 450px;
    height: 446px;
    background-color: #f3ede7;
    position: fixed;
    left: 50%;
    top: 50%;
    margin: -223px 0 0 -225px;
  }
  .online {
    padding: 20px 32px 0 32px;
  }
  .online h3 {
    font-size: 24px;
    color: #3e3a39;
    text-align: left;
    margin: 21px 0 7px;
  }
  .sm {
    font-size: 14px;
    color: #666666;
    cursor: pointer;
    float: right;
  }
  .formdata {
    text-align: left;
    font-size: 0;
    overflow: hidden;
  }
  .chose {
    box-sizing: border-box;
  }
  input {
    box-sizing: border-box;
    border: 0 none;
    outline: none;
    padding: 0 0 0 12px;
  }
  .acreage {
    box-sizing: border-box;
    width: 386px;
    height: 50px;
    margin-bottom: 12px;
  }
  .acreage:nth-child(1) {
    margin-top: 20px;
  }
  .acreage:nth-child(2) {
    width: 257px;
  }
  .acr {
    width: 386px!important;
  }
  .chose span {
    width: 129px;
    height: 50px;
    text-align: center;
    line-height: 50px;
    font-size: 16px;
    color: #595757;
    display: inline-block;
    background-color: #fafafa;
    cursor: pointer;
  }
  .auto {
    float: left;
    font-size: 16px;
  }
  .auto input {
    vertical-align: middle;
  }
  .auto span {
    font-size: 12px;
    color: #898989;
    vertical-align: middle;
  }
  .agree {
    margin-top: 21px;
  }
  .forget {
    float: right;
    color: red;
    font-size: 16px;
  }
  .submit {
    display: flex;
    justify-content: center;
    margin-top: 48px;
  }
  .sub {
    margin-top: 36px;
  }
  .submit button{
    width: 386px;
    height: 46px;
    font-size: 14px;
    border: 0;
    outline: none;
    color: #fff;
    cursor: pointer;
    background-color: #d42f31;
  }
  .loginin {
    margin: 42px 0 0 21px;
    overflow: hidden;
  }
  .loginin li {
    width: 35px;
    height: 29px;
    display: inline-block;
    margin-right: 31px;
    background-size: 35px 29px;
    cursor: pointer;
  }
  .loginin li:nth-child(1) {
    background: url("../assets/home/weixin.png") no-repeat;
  }
  .loginin li:nth-child(2) {
    background: url("../assets/home/qq.png") no-repeat;
  }
  .loginin li:nth-child(3) {
    background: url("../assets/home/weibo.png") no-repeat;
  }
  .loginin p {
    font-size: 14px;
    color: #999999;
    line-height: 29px;
    float: right;
  }
  .tasking {
    position: fixed;
    z-index: 9998;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.2);
  }
</style>
