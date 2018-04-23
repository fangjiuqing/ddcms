<template>
  <div>
    <div class="container">
      <!--<div class="nav-top">-->
        <!--<div class="middle">-->
          <!--<div class="left">-->
            <!--<span class="twy">送您20年不落后的家</span>-->
            <!--&lt;!&ndash;<img src="../assets/home/voice.png">&ndash;&gt;-->
            <!--<span class="robot">爆品智能机器人仅1999元!</span>-->
          <!--</div>-->
          <!--<div class="right">-->
            <!--<ul class="login">-->
              <!--<li @click="login">登录</li>-->
              <!--<li>-->
                <!--<div class="line"></div>-->
              <!--</li>-->
              <!--<li class="register" @click="regist">注册</li>-->
            <!--</ul>-->
            <!--<ul class="list">-->
              <!--<li>我的订单</li>-->
              <!--<li><div class="line"></div></li>-->
              <!--<li>会员</li>-->
              <!--<li><div class="line"></div></li>-->
              <!--<li>道达币</li>-->
              <!--<li><div class="line"></div></li>-->
              <!--<li>企业采购</li>-->
              <!--<li><div class="line"></div></li>-->
              <!--<li>客户服务</li>-->
            <!--</ul>-->
          <!--</div>-->
        <!--</div>-->
      <!--</div>-->
      <div class="nav-foot">
        <div class="mid">
          <div class="logo">
            <img src="../assets/home/logo1.png">
          </div>
          <ul class="menu" @mouseleave="hidden">
            <li v-for="(menuItem, index) in tabParams" :key="index" class="menu-index" @mouseenter="tab(menuItem, index)" :class="{active:index == num}">
              <span class="menu-span">
                <router-link :to="{name: menuItem.en}" exact>
                  {{menuItem.title}}
                </router-link>
              </span>
              <ul class="sub-menu" v-show="index === num" v-if="show">
                <div class="vh">
                  <li v-for="(subMenu, index) in menuItem.children" :key="index" class="two">
                    <img :src="subMenu.img" alt="">
                    <p>
                      {{subMenu.tTitle}}
                      <span>{{subMenu.price}}</span>
                    </p>
                  </li>
                </div>
              </ul>
            </li>
          </ul>
        </div>
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
import $ from 'jquery'
import future1 from '../assets/home/future1.png'
import future2 from '../assets/home/future2.png'
import future3 from '../assets/home/future3.png'
import logo1 from '../assets/home/logo1.png'
import logo2 from '../assets/home/logo2.png'
export default {
  name: 'head2',
  data () {
    return {
      num: 1,
      scroll: '',
      logo1: logo1,
      logo2: logo2,
      show: false,
      loginin: false,
      logining: false,
      register: false,
      tabParams: [
        {
          title: '首页',
          en: 'Header'
        },
        {
          title: '智装套餐',
          en: 'scheme',
          children: [
            {
              img: future3,
              tTitle: '梦想',
              price: '999元/平'
            },
            {
              img: future2,
              tTitle: '智慧',
              price: '1299元/平'
            },
            {
              img: future1,
              tTitle: '未来',
              price: '1999元/平'
            }
          ]
        },
        {
          title: '别墅定制',
          en: 'case'
        },
        {
          title: '优选案例',
          en: 'gather'
        },
        {
          title: '设计名家',
          en: 'design'
        },
        {
          title: '施工品质',
          en: 'construction'
        },
        {
          title: '国际优材 ',
          en: 'superior'
        },
        {
          title: '智装课堂 ',
          en: 'classroom'
        },
        {
          title: '金牌服务',
          en: 'service'
        },
        {
          title: '实体网点',
          en: 'entity'
        }
      ]
    }
  },
  methods: {
    tab (menuItem, index) {
      this.num = index
      this.show = true
      if (menuItem.children === undefined) {
        this.show = false
      }
    },
    menu () {
      this.scroll = document.documentElement.scrollTop || document.body.scrollTop
      if (this.scroll > 50) {
        $('.logo img').attr('src', this.logo2)
      } else {
        $('.logo img').attr('src', this.logo1)
      }
    },
    hidden () {
      this.show = false
    },
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
  },
  mounted () {
    $(document).ready(function () {
      $(window).scroll(function () {
        let topp = $(document).scrollTop()
        if (topp > 0) {
          $('.nav-foot').addClass('shadow')
        } else if (topp === 0) {
          $('.nav-foot').removeClass('shadow')
        }
      })
    }())
    document.addEventListener('scroll', this.menu)
  }
}
</script>
<style scoped>
  .middle {
    width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
  }
  .container {
    width: 100%;
    margin: 0 auto;
    background-color: #fff;
    position: fixed;
    top: 0;
    z-index: 100;
  }
  .nav-top {
    display: flex;
    width: 100%;
    height: 45px;
    justify-content: space-around;
    align-items: center;
    background-color: #333333;
  }
  .nav-foot {
    display: flex;
    height: 70px;
    align-items: center;
    justify-content: space-around;
    position: relative;
  }
  .shadow {
    box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.1);
  }
  .left {
    display: flex;
  }
  .twy{
    color: #fff;
    min-width: 146px;
    margin-right: 47px;
  }
  .robot {
    color: #d42f31;
    min-width: 184px;
    vertical-align: middle;
  }
  .robot:before {
    content: '';
    display: inline-block;
    width: 19px;
    height: 19px;
    background: url("../assets/home/voice.png") no-repeat;
    margin-right: 9px;
    vertical-align: middle;
  }
  .right {
    display: flex;
    justify-content: flex-start;
  }
  .login {
    margin-right: 24px;
  }
  .list {
    margin-right: 30px;
  }
  .login, .list {
    display: flex;
    color: #fff;
    font-size: 14px;
  }
  .login li:nth-child(2n-1) {
    min-width: 30px;
  }
  .login li {
    cursor: pointer;
  }
  .list li {
    margin: 0 4px;
  }
  .login .line {
    width: 1px;
    height: 14px;
    background-color: #c2c2c2;
    margin: 0 15px 0 12px;
  }
  .list .line {
    width: 1px;
    height: 14px;
    background-color: #c2c2c2;
  }
  .mid {
    width: 1200px;
    height: 97px;
    display: flex;
    justify-content: space-between;
    margin: 0 auto;
  }
  .logo {
    display: flex;
    align-items: center;
  }
  .menu {
    display: flex;
    align-items: center;
    margin-right: 20px;
  }
  .menu-index {
    display: flex;
    margin: 0 12px;
  }
  .menu-span {
    width: 100%;
  }
  .menu-index a {
    color: #000;
    text-decoration: none;
  }
  .menu-index .menu-span {
    color: #000;
  }
  .sub-menu {
    width: 100vw;
    /*height: 128px;*/
    background-color: #ffffff;
    box-shadow: 0 6px 9px 0 rgba(0, 0, 0, 0.08);
    font-size: 0;
    position: absolute;
    display: flex;
    margin-top: 56px;
    left: 0;
    z-index: 77777;
    text-align: center;
    padding-bottom: 30px;
  }
  .vh {
    margin: 0 auto;
  }
  .vh li {
    display: inline-block;
    margin-right: 23px;
  }
  .sub-menu .two:nth-child(2) {
    /*margin: 0 33px 0 23px;*/
  }
  .menu-index a:hover {
    padding-bottom: 7px;
    border-bottom: 2px solid #d42f31;
  }
  a.router-link-active {
    padding-bottom: 7px;
    border-bottom: 2px solid #d42f31;
  }
  .two {
    display: flex;
    flex-direction: column;
  }
  .two img {
    margin-bottom: 10px;
  }
  .two {
    cursor: pointer;
  }
  .two p {
    color: #666666;
    font-size: 12px;
  }
  .two span {
    color: #e74700;
    font-size: 12px;
  }
  .menu-span:hover .sub-menu {
    display: block;
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
    font-family: MicrosoftYaHei;
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
    /*display: flex;*/
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

  /*注册弹窗*/
</style>
