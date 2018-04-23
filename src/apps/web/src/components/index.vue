<template>
<div class="container">
  <div class="tasking"></div>
  <div class="content">
    <ul class="list">
      <li v-for="(item, index) in banners" :key="index" v-show="index===currentIndex" @mouseenter="stop" @mouseleave="go">
        <img class="study" :src="item.imgUrl" alt="">
        <div class="word">
          <div class="banner-word">
            <div class="word-top">
              <div class="line">
              </div>
              <span>INTELLIGENT FAMILY SOLUTION</span>
              <div class="right"></div>
            </div>
            <div class="word-mid">
              <span>道达智装 智慧家庭解决方案</span>
            </div>
            <div class="word-foot">
              <span>五大空间 八大生活场景集成设计</span>
            </div>
          </div>
          <div class="play"></div>
          <div class="play-s"></div>
          <div class="chose">立即获取智装方案</div>
        </div>
      </li>
    </ul>
    <div class="bullet">
      <span v-for="(item, index) in banners" :class="{ 'active':index===currentIndex }"
              @click="change(index)" :key="index">
      </span>
    </div>
  </div>
</div>
</template>
<script>
import img from '../assets/banner.png'
import left from '../assets/img.png'
import center from '../assets/ddzzh.png'
export default {
  name: 'index',
  data () {
    return {
      banners: [
        { imgUrl: img },
        { imgUrl: left },
        { imgUrl: center }
      ],
      currentIndex: 0,
      timer: ''
      // isShow: true
    }
  },
  computed: {
    prevIndex () {
      if (this.currentIndex === 0) {
        return this.banners.length - 1
      } else {
        return this.currentIndex - 1
      }
    },
    nextIndex () {
      if (this.currentIndex === this.banners.length - 1) {
        return 0
      } else {
        return this.currentIndex + 1
      }
    }
  },
  created () {
    // 在DOM加载完成后，下个tick中开始轮播
    this.$nextTick(() => {
      this.timer = setInterval(() => {
        this.autoPlay()
      }, 3000)
    })
  },
  methods: {
    goto (index) {
      // this.isShow = false
      setTimeout(() => {
      // this.isShow = true
        this.currentIndex = index
      }, 10)
    },
    go () {
      this.timer = setInterval(() => {
        this.autoPlay()
      }, 4000)
    },
    change (i) {
      this.currentIndex = i
    },
    stop () {
      clearInterval(this.timer)
      this.timer = null
    },
    autoPlay () {
      this.currentIndex++
      if (this.currentIndex > this.banners.length - 1) {
        this.currentIndex = 0
      }
    }
  }
}
</script>
<style scoped>
.container {
  height: 100vh;
}
img {
  width: 100%;
  height: 100vh;
}
.tasking {
  width: 100%;
  height: 100vh;
  z-index: 100;
  position: absolute;
  background-color: rgba(0, 0, 0, 0.5);
}
.banner img {
  display: block;
  width: 100%;
  position: relative;
}
.word {
  z-index: 999;
  width: 622px;
  height: 450px;
  position: absolute;
  top: 50%;
  left: 50%;
  margin-left: -311px;
  margin-top: -200px;
}
.banner-word .word-top {
  width: 622px;
  float: left;
  margin-bottom: 12px;
}

.banner-word .word-top .line, .banner-word .word-top .right{
  width: 97px;
  height: 2px;
  background-color: #ffffff;
  border-radius: 1px;
  margin-top: 10px;
}
.banner-word .word-top .line {
  float: left;
}
.banner-word .word-top .right {
  float: right;
}
.banner-word .word-top span {
  width: 428px;
  height: 17px;
  font-size: 24px;
  color: #ffffff;
}
.banner-word .word-mid {
  letter-spacing: 2px;
  margin-bottom: 22px;
}
.banner-word .word-mid span{
  width: 38.9rem;
  height: 2.9rem;
  font-size: 3rem;
  color: #ffffff;
}
.banner-word .word-foot {
  letter-spacing: 1px;
}
.banner-word .word-foot span{
  width: 363px;
  font-size: 24px;
  color: rgba(255, 255, 255, 0.5);
  text-align: center;
}
.play {
  width: 56px;
  height: 56px;
  background-color: rgba(255, 255, 255, 0.5);
  opacity: 0.5;
  border-radius: 50%;
  position: absolute;
  top: 55%;
  left: 50%;
  margin-left: -28px;
  margin: -28px;
}
.play-s {
  height: 0;
  width: 0;
  border-top: 12px solid transparent;
  border-left: 18px solid white;
  border-bottom: 12px solid transparent;
  position: absolute;
  top: 55%;
  left: 50%;
  margin-top: -10px;
  margin-left: -6px;
}
.chose {
  width: 314px;
  height: 53px;
  background-color: #415bff;
  box-shadow: 0 3px 16px 0 rgba(0, 0, 0, 0.3);
  border-radius: 5px;
  line-height: 53px;
  font-size: 24px;
  color: #fff;
  position: absolute;
  left: 50%;
  bottom: 0;
  margin-top: 120px;
  margin-left: -157px;
}
.bullet {
  position: absolute;
  width: 100%;
  bottom: -5%;
  margin: 0 auto;
  z-index: 10;
  text-align: center;
}
.bullet span {
  width: 48px;
  height: 4px;
  /*border: 1px solid;*/
  background: #aca39c;
  display: inline-block;
  margin-right: 10px;
}
.active {
  background: white !important;
}
</style>
