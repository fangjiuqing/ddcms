<template>
  <div class="strict">
    <h3>严格甄选&nbsp;品质特供</h3>
    <p class="subhead">用料考究，层层筛选，品质保证</p>
    <div class="c" @mouseenter="visible" @mouseleave="hidden">
      <swiper class="list" :options="swiperOption" ref="mySwiper">
        <swiper-slide v-for="(item, index) in banners" :key="index" :class="{anim:animate==true}">
          <div class="listmore">
            <img :src="item.imgUrl" alt="swiper-image" class="swiper-image">
            <h3 class="socket">{{item.name}}</h3>
            <p class="smart">{{item.intr}}</p>
          </div>
        </swiper-slide>
        <div class="swiper-pagination" slot="pagination"></div>
        <div class="swiper-button-prev prev" slot="button-prev"></div>
        <div class="swiper-button-next prev" slot="button-next"></div>
      </swiper>
    </div>
    <button class="more">查看更多</button>
  </div>
</template>
<script>
import img from '../assets/home/xgj.png'
import yzhu from '../assets/home/dznw.png'
import xzjqr from '../assets/home/xzjqr.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'strict',
  data () {
    return {
      animate: false,
      // isShow: false,
      banners: [
        { imgUrl: xzjqr,
          name: '小管家智能插座',
          intr: '当你进入黑暗空间时自动亮灯，离开时自动灭灯'
        },
        { imgUrl: img,
          name: '小智机器人',
          intr: '智能生活，你可以和小智一起开始'
        },
        { imgUrl: yzhu,
          name: '多功能智能网关',
          intr: '多功能切换，360°贴合你的作息'
        },
        { imgUrl: xzjqr,
          name: '小管家智能插座',
          intr: '当你进入黑暗空间时自动亮灯，离开时自动灭灯'
        },
        { imgUrl: yzhu,
          name: '小智机器人',
          intr: '智能生活，你可以和小智一起开始'
        },
        { imgUrl: img,
          name: '多功能智能网关',
          intr: '多功能切换，360°贴合你的作息'
        }
      ],
      swiperOption: {
        speed: 400,
        slidesPerView: 3,
        centeredSlides: false,
        loop: false,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        },
        pagination: {
          bulletClass: 'bullet',
          bulletActiveClass: 'bulletActive',
          el: '.swiper-pagination',
          clickable: true
        }
      },
      timer: ''
    }
  },
  methods: {
    visible () {
      this.isShow = true
    },
    hidden () {
      this.isShow = false
    }
  },
  components: {
    swiper, swiperSlide
  }
}
</script>
<style scoped>
  .strict {
    width: 1280px;
    height: 720px;
    /*height: 45vw;*/
    /*height: 35vw;*/
    position: relative;
    left: 0;
    right: 0;
    margin: 0 auto;
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
  .c {
    width: 100%;
    height: 655px;
  }
  .list {
    width: 1200px;
    /*width: 61vw;*/
    /*height: 36.6vw;*/
    position: absolute;
    left: 0;
    right: 0;
    margin: 88px auto 0;
  }
  .listmore {
    width: 380px;
    margin: 0 auto;
    padding-top: 20px;
  }
  .list li {
    /*height: 16.5vw;*/
    width: 380px;
    display: inline-block;
    margin-top: 43px;
    text-align: center;
  }
  .swiper-image {
    width: auto;
    height: 300px;
  }
  .swiper-slide {
    width: 380px;
  }
  .swiper-slide-active{
    height: 460px;
    /*background-color: #ffffff;*/
    /*box-shadow: 0 2px 15px 0*/
    /*rgba(0, 0, 0, 0.2);*/
    /*border: solid 2px #d42f31;*/
  }
  .socket {
    font-size: 24px;
    color: #595757;
    margin-top: 30px;
    margin-bottom: 12px;
  }
  .smart {
    font-size: 16px;
    color: #595757;
  }
  .more {
    position: absolute;
    left: 0;
    right: 0;
    margin: 0 auto;
    bottom: 0;
    border: 0;
    width: 124px;
    height: 36px;
    background-color: #d42f31;
    border-radius: 4px;
    color: #fff;
  }
  .more:hover {
    cursor: pointer;
  }
  .swiper-button-next {
    right: 0;
  }
</style>
<style>
  .swiper-button-prev {
    width: 26px;
    height: 56px;
    background: url("../assets/home/prev.png") no-repeat!important;
  }
  .swiper-button-prev.swiper-button-disabled {
    background: url("../assets/home/prevDisable.png") no-repeat!important;
  }
  .swiper-button-next {
    width: 26px;
    height: 56px;
    background: url("../assets/home/next.png") no-repeat!important;
  }
  .swiper-button-next.swiper-button-disabled {
    background: url("../assets/home/nextDisable.png") no-repeat!important;
  }
  .bullet {
    width: 8px;
    height: 8px;
    display: inline-block;
    margin: 0 4px;
    border-radius: 4px;
    opacity: 0.2!important;
    background-color: #ccc!important;
  }
  .bulletActive {
    opacity: 0.8!important;
    background-color: #ccc!important;
  }
</style>
