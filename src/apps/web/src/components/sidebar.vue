<template>
  <transition name="bounce">
    <div>
      <div class="sidebar" v-show="isShow">
        <div class="money" @click="showPanel">
          <img src="../assets/sidebar/money.png" alt="">
          <a href="javascript:;">快速报价</a>
        </div>
        <ul class="list">
          <li class="headset">
            <i></i>
            <a href="javascript:;">在线客服</a>
          </li>
          <li class="gift">
            <i></i>
            <a href="javascript:;">新人有礼</a>
          </li>
          <li class="roket" @click="backToTop">
            <i></i>
            <a href="javascript:;">回到顶部</a>
          </li>
        </ul>
      </div>
      <Price :panelShow.sync="panelShow"></Price>
    </div>
  </transition>
</template>
<script>
import $ from 'jquery'
import Price from './price'
export default {
  name: 'sidebar',
  components: {
    Price
  },
  data () {
    return {
      panelShow: false,
      isShow: false
    }
  },
  mounted () {
    window.addEventListener('scroll', this.handleScroll)
  },
  methods: {
    backToTop () {
      $('html,body').animate({scrollTop: '0px'}, 300)
    },
    handleScroll () {
      const scrollTop =
        window.pageYOffset ||
        document.documentElement.scrollTop ||
        document.body.scrollTop
      const offsetTop = document.documentElement.clientHeight * 0.6
      if (scrollTop > offsetTop) {
        this.isShow = true
      } else {
        this.isShow = false
      }
    },
    showPanel () {
      this.panelShow = true
    }
  }
}
</script>
<style scoped>
.sidebar {
  width: 64px;
  height: 280px;
  position: fixed;
  top: 50%;
  right: 36px;
  z-index: 9997;
  transform: translate(0, -50%);
  background-color: #ffffff;
  box-shadow: 0 1px 21px 0 rgba(0, 0, 0, 0.12);
}
.money {
  width: 59px;
  height: 73px;
  margin: 3px 3px 0;
  background-color: #d42f31;
  cursor: pointer;
}
.money img {
  margin: 15px 0 8px;
}
.money a {
  display: block;
  color: #fff;
  font-size: 12px;
}
.list {
  height: 177px;
  margin-top: 11px;
}
.list li {
  width: 50px;
  height: 45px;
  margin: 12px auto 0;
  cursor: pointer;
}
.list li a {
  text-decoration: none;
  color: #595757;
  font-size: 12px;
}
.headset i, .gift i, .roket i{
  display: block;
  width: 25px;
  height: 25px;
  margin: 0 auto 5px;
}
.headset i {
  background: url(../assets/sidebar/headset.png) center/cover no-repeat;
}
.headset:hover i {
  background: url(../assets/sidebar/headset-g.png) center/cover no-repeat;
}
.headset:hover a {
  color: #d42f31;
}
.gift i {
  background: url(../assets/sidebar/gift.png) center/cover no-repeat;
}
.gift:hover i {
  background: url(../assets/sidebar/gift-g.png) center/cover no-repeat;
}
.gift:hover a {
  color: #d42f31;
}
.roket i {
  background: url(../assets/sidebar/arrow.png) center/cover no-repeat;
}
.roket:hover i {
  background: url(../assets/sidebar/arrow-g.png) center/cover no-repeat;
}
.roket:hover a {
  color: #d42f31;
}
.gift,
.headset {
  padding-bottom: 8px;
  border-bottom: 1px solid #cfcfcf;
}
.gift img {
  margin-bottom: 6px;
}
.roket img {
  margin-bottom: 11px;
}
.bounce-enter-active {
  animation: bounce-in .5s;
}
.bounce-leave-active {
  animation: bounce-out .5s;
}
@keyframes bounce-in {
  0% {
    transform: translateY(-85px);
  }
  100% {
    transform: translateY(0);
  }
}
@keyframes bounce-out {
  0% {
    transform: translateY(0);
  }
  100% {
    transform: translateY(-85px);
  }
}
</style>
