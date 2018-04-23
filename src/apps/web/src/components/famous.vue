<template>
<div class="cover">
  <h3>智装设计名家</h3>
  <p class="subhead">万千家庭口碑见证 解决了多种家居问题</p>
  <div class="content">
    <swiper class="list" :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="(item, index) in banners" :key="index">
        <div class="introduce">
          <p class="enTitle">FAMOUS DESIGNER</p>
          <h1>{{item.name}}</h1>
          <p class="eN">{{item.eN}}</p>
          <p class="address">所在地：{{item.address}}</p>
          <p class="address">{{item.style}}</p>
          <p class="address">{{item.idea}}</p>
        </div>
        <img class="study" :src="item.imgUrl" alt="">
      </swiper-slide>
      <div class="swiper-button-prev prev" slot="button-prev"></div>
      <div class="swiper-button-next prev" slot="button-next"></div>
    </swiper>
  </div>
</div>
</template>
<script>
import img from '../assets/home/sjmj.png'
import left from '../assets/home/yzhu.png'
import center from '../assets/home/dznw.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'famous',
  data () {
    return {
      banners: [
        {
          imgUrl: img,
          name: '张国强',
          eN: 'zhangguoqiang',
          address: '上海',
          style: '现代简约',
          idea: '擅长处理各种复杂的空间设计，遵行设计理念是设计源于生活，只有懂得和享受生活的人才能更合理的规划生活。'
        },
        {
          imgUrl: left,
          name: '刘冰洋',
          eN: 'liubingyang',
          address: '上海',
          style: '欧式风格',
          idea: '生活亦设计，你的生活由"你"来定制。'
        },
        {
          imgUrl: center,
          name: '韩理想',
          eN: 'hanlixiang',
          address: '上海',
          style: '欧式风格',
          idea: '遵行设计理念是设计源于生活，只有懂得和享受生活的人才能更合理的规划生活。生活亦设计，你的生活由"你"来定制。'
        }
      ],
      swiperOption: {
        loop: false,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        }
      }
    }
  },
  components: {
    swiper, swiperSlide
  }
}
</script>
<style scoped>
  .cover {
    width: 100%;
    height: 716px;
    position: relative;
    background: url('../assets/home/famous-bg.png') no-repeat;
    background-size: 100% 716px;
    margin-top: 100px;
  }
  h3 {
    font-size: 40px;
    color: #ffffff;
    text-align: center;
    padding-top: 65px;
    margin-bottom: 15px;
  }
  .subhead {
    font-size: 20px;
    color: #ffffff;
    text-align: center;
  }
  .content {
    width: 1245px;
    height: 495px;
    position: absolute;
    background-color: rgba(0, 0, 0, 0.3);
    left: 0;
    right: 0;
    top: 128px;
    bottom: 0;
    margin: auto;
    border-radius: 5px;
  }
  .swiper-slide {
    width: 1245px!important;
    /*top: 49px;*/
    /*height: 52%;*/
  }
  .list {
    width: 1245px;
    height: 100%;
    /*position: absolute;*/
    /*left: 0;*/
    /*right: 0;*/
    /*margin: 0 auto;*/
  }
  .list li {
    width: 30%;
    display: inline-block;
    margin-left: 2.5%;
    margin-top: 43px;
  }
  .introduce {
    width: 495px;
    position: absolute;
    left: 57px;
    color: #fff;
    top: 50%;
    transform: translateY(-50%);
  }
  .study {
    width: 478px;
    /*height: 374px;*/
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.2);
    box-shadow: 0 7px 22px 1px rgba(48, 48, 48, 0.15);
  }
  .address {
    text-align: left;
    font-size: 24px;
    letter-spacing: 1px;
    color: #ffffff;
    line-height: 34px;
  }
  .introduce h1 {
    font-size: 48px;
    color: #ffffff;
    text-align: left;
    margin-bottom: 8px;
  }
  .introduce .enTitle {
    font-size: 24px;
    text-align: left;
    margin-bottom: 15px;
  }
  .introduce .eN {
    font-family: BrushScriptMT;
    font-size: 30px;
    color: rgba(255, 255, 255, 0.7);
    text-align: left;
    margin-bottom: 43px;
  }
  .prev {
    top: 52%;
    right: 0;
    width: 26px;
    height: 52px;
    background-size: 26px 52px;
  }
</style>
