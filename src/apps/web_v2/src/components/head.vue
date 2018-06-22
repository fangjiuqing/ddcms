<template>
  <div class="head">
    <div class="container">
      <div class="nav-foot">
        <div class="mid">
          <div class="logo">
            <router-link :to="{name: 'home'}" class="ho">
              <img src="../assets/home/logo.png">
            </router-link>
          </div>
          <ul class="menu" @mouseleave="hidden">
            <li v-for="(menuItem, index) in tabParams" :key="index" class="menu-index" @mouseenter="tab(menuItem, index)" :class="{active:index == num}">
              <span class="menu-span">
                <router-link :to="{name: menuItem.en}" exact>
                  {{menuItem.title}}
                </router-link>
              </span>
              <ul class="sub-menu" v-show="index === num" v-if="show">
                <li v-for="(subMenu, index) in menuItem.children" :key="index" class="two">
                  <!-- <img :src="subMenu.img" alt=""> -->
                  <router-link :to="{name: subMenu.en}">
                    <p>
                      {{subMenu.tTitle}}
                      <span>{{subMenu.price}}</span>
                    </p>
                  </router-link>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
// import future1 from '../assets/home/future1.png'
// import future2 from '../assets/home/future2.png'
// import future3 from '../assets/home/future3.png'
export default {
  name: 'head2',
  data () {
    return {
      num: 1,
      scroll: '',
      show: false,
      loginin: false,
      logining: false,
      register: false,
      tabParams: [
        {
          title: '智装系列',
          en: 'home',
          children: [
            {
              // img: future3,
              tTitle: '私人定制',
              en: 'personal-tailor'
              // price: '999元/平'
            },
            {
              tTitle: '省心整装',
              en: 'personal-tailor'
            }
          ]
        },
        {
          title: '精品案例',
          en: 'gather'
        },
        {
          title: '设计名家',
          en: 'designList'
        },
        {
          title: '施工品质',
          en: 'construction'
        },
        {
          title: '国际优材',
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
  }
}
</script>
<style scoped>
  .ho {
    border-bottom: 0!important;
  }
  .head {
    padding-top: 88px;
    box-sizing: border-box;
  }
  .container {
    width: 100%;
    margin: 0 auto;
    background-color: #fff;
    position: fixed;
    top: 0;
    z-index: 100;
  }
  .nav-foot {
    height: 88px;
    position: relative;
  }
  .shadow {
    box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.1);
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
  .mid {
    width: 1200px;
    margin: 0 auto;
    overflow: hidden;
  }
  .logo {
    /* height: 66px; */
    display: inline-block;
    position: relative;
    z-index: 11;
    /* line-height: 66px; */
    margin-top: 11px;
  }
  .logo img {
    /* width: 66px; */
  }
  .menu {
    height: 88px;
    margin-right: 90px;
    display: inline-block;
    float: right;
  }
  .menu-index {
    display: inline-block;
    margin: 0 12px;
    line-height: 88px;
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
    background-color: #ffffff;
    box-shadow: 0 6px 9px 0 rgba(0, 0, 0, 0.08);
    position: absolute;
    left: 0;
    z-index: 10;
    text-align: center;
    padding-top: 30px;
  }
  .sub-menu li {
    display: inline-block;
    margin-right: 23px;
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
    cursor: pointer;
  }
  .two img {
    margin-bottom: 10px;
  }
  .two p {
    color: #666666;
    font-size: 16px;
    line-height: 20px;
  }
  .two span {
    color: #e74700;
    font-size: 12px;
  }
  .menu-span:hover .sub-menu {
    display: block;
  }
</style>
