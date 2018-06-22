<template>
  <div class="scheme">
    <Head></Head>
    <div class="box">
      <h3>轻奢现代简约风格</h3>
      <p class="subhead">追求新奇时尚的年轻人，希望自己的家有更多功能，满足居住需求的同时，带来更个性的生活体验</p>
      <p class="subhead">崇尚优雅、浪漫的工作人群</p>
      <h1><span class="time">缔造33天急速工期&nbsp;</span><span class="all">全屋环保，装完即可入住，无需等待</span></h1>
      <p class="red">999元/平 <span>起</span></p>
      <div class="inner" id="inner">
        <swiper class="lists" :options="swiperOption" ref="mySwiper">
          <swiper-slide v-for="(item, index) in banners" :key="index">
            <img :src="item.img" alt="" class="banner">
            <div class="black"></div>
          </swiper-slide>
          <div class="swiper-pagination pa" slot="pagination"></div>
        </swiper>
        <div class="swiper-button-prev prev" slot="button-prev"></div>
        <div class="swiper-button-next prev" slot="button-next"></div>
        <p class="smart">智慧客厅</p>
      </div>
    </div>
    <sideBar></sideBar>
    <scene></scene>
    <designteam></designteam>
    <model></model>
    <foot></foot>
  </div>
</template>
<script>
import Head from './head.vue'
import scene from './scene.vue'
import model from './model.vue'
import designteam from './designteam.vue'
import foot from './foot.vue'
import sideBar from './sidebar'
import banner1 from '../assets/scheme/banner.png'
export default {
  name: 'scheme',
  metaInfo () {
    const title = '智装套餐 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      isShow: false,
      banners: [
        {
          img: banner1
        },
        {
          img: banner1
        },
        {
          img: banner1
        },
        {
          img: banner1
        }
      ],
      swiperOption: {
        loop: true,
        paginationType: 'fraction',
        centeredSlides: true,
        slidesPerView: 3,
        preventClicks: false,
        autoplay: false,
        speed: 500,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
          renderBullet: function (index, className) {
            return '<span class="' + className + '">' + '</span>'
          }
        }
      }
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
    Head, scene, model, designteam, foot, sideBar
  }
}
</script>
<style>
  .scheme {
    width: 100%;
    /*height: 1023px;*/
    left: 0;
    right: 0;
    margin: 71px auto 0;
  }
  .scheme .box {
    border-top: 1px solid lightgray;
    padding-top: 53px;
  }
  .scheme h3 {
    font-size: 36px;
    color: #000;
    text-align: center;
    margin-bottom: 15px;
  }
  .scheme .subhead {
    font-size: 18px;
    color: #595757;
    text-align: center;
    margin-bottom: 11px;
  }
  .scheme h1 {
    font-size: 16px;
    color: #000000;
    margin-top: 21px;
  }
  .scheme .time {
    font-family: HiraginoSansGB-W6;
    font-weight: bold;
  }
  .scheme .all {
    font-family: HiraginoSansGB-W3;
  }
  .scheme .red {
    font-size: 18px;
    color: #ec0000;
    margin-top: 13px;
  }
  .scheme .red span {
    font-size: 12px;
    color: #666666;
  }
  .scheme .inner {
    width: 1140px;
    margin: 0 auto 246px;
    position: relative;
  }
  .scheme .banner {
    width: 800px;
    height: 460px;
  }
  .scheme .smart {
    font-size: 18px;
    color: #292929;
    margin-top: -130px;
  }
  .scheme .lists {
    width: 100%;
    margin: 51px auto 0;
  }
  .scheme .lists li {
    display: inline-block;
    margin-right: 8px;
  }
  #inner .black {
    width: 800px;
    height: 460px;
    opacity: 0.4;
    background-color: #000;
    position: absolute;
    transition-duration: .5s;
  }
  #inner .swiper-slide {
    text-align: center;
    font-size: 18px;
    /* background: red; */
    width: 800px;
    /* Center slide text vertically */
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
    /*缩放*/
    -webkit-transition: 1000ms;
    -moz-transition: 1000ms;
    -ms-transition: 1000ms;
    -o-transition: 1000ms;
    transition: 1000ms;
    -webkit-transform: scale(0.78);
    -moz-transform: scale(0.78);
    -ms-transform: scale(0.78);
    -o-transform: scale(0.78);
    transform: scale(0.78);
    -webkit-backface-visibility: hidden;
    /*overflow: hidden;*/
    /*margin-left: -342px;*/
  }
  #inner .swiper-slide-active{
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1);
    /*margin-left: -170px;*/
    z-index: 1;
  }
  #inner .swiper-slide-active .banner + .black {
    background-color: transparent!important;
    transition-duration: .5s;
  }
  #inner .swiper-pagination-bullet {
    width: 90px!important;
    height: 64px!important;
    display: inline-block;
    border-radius: 0!important;
    opacity: 0.5;
    background: url("../assets/scheme/banner.png");
    background-size: 90px 64px;
  }
  #inner .swiper-button-prev {
    left: -50px;
  }
  #inner .swiper-button-next {
    right: -50px;
  }
  .pa {
    position: static!important;
    margin-top: 81px;
  }
  #inner .swiper-pagination-bullet-active {
    border: 1px solid #dfdfdf !important;
    opacity: 1!important;
  }
  #inner .swiper-pagination-bullet .img {
    width: 90px!important;
    height: 64px!important;
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
