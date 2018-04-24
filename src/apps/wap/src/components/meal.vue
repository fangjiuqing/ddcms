<template>
  <div class="scheme">
    <Header></Header>
    <div class="box">
      <div class="word">
        <h3>轻奢现代简约风格</h3>
        <p class="subhead">追求新奇时尚的年轻人，希望自己的家有更多功能，满足居住需求的同时，带来更个性的生活体验</p>
        <p class="subhead">崇尚优雅、浪漫的工作人群</p>
        <h1><span class="time">缔造33天急速工期&nbsp;</span><span class="all">全屋环保，装完即可入住，无需等待</span></h1>
        <p class="red">999元/平 <span>起</span></p>
      </div>
      <div class="inner" id="inner">
        <swiper class="lists" :options="swiperOption" ref="mySwiper">
          <swiper-slide v-for="(item, index) in banners" :key="index">
            <img :src="item.img" alt="" class="banner">
            <div class="black"></div>
          </swiper-slide>
          <div class="swiper-pagination pa" slot="pagination"></div>
        </swiper>
        <p class="smart">智慧客厅</p>
      </div>
    </div>
    <model></model>
    <div class="teamh">
      <div class="team">
        <p>设计团队结合30000多家客户的真实需求</p>
        <p>总结、提炼，打造标准化家装</p>
        <span>客户真实需求提炼、实施经验总结，打造标准化家装</span>
        <img src="../assets/meal/teamh.png" alt="">
      </div>
    </div>
    <pack></pack>
    <div class="obtain">
      <button>我要这样装 立即获取报价</button>
    </div>
    <div class="more">
      <a href="javscript:;">查看更多资料介绍</a>
      <a href="javscript:;"><img src="../assets/meal/arrow.png" alt=""></a>
    </div>
    <foot></foot>
  </div>
</template>
<script>
import Header from './head-nav'
import foot from './footNav'
import model from './model'
import pack from './package'
import banner1 from '../assets/meal/banner.png'
export default {
  name: 'meal',
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
        preventClicks: false,
        autoplay: false,
        slidesPerView: 3,
        speed: 500,
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
    Header, foot, model, pack
  }
}
</script>
<style>
.scheme .box {
  border-top: 1px solid lightgray;
  padding-top: 88px;
}
.word {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.scheme h3 {
  font-size: 36px;
  color: #000;
  text-align: center;
  letter-spacing: 1px;
  padding: 60px 0 20px;
}
.scheme .subhead {
  width: 655px;
  line-height: 32px;
  font-size: 18px;
  color: #666;
  text-align: center;
}
.scheme h1 {
  font-size: 16px;
  color: #000000;
  padding-top: 15px;
}
.scheme .time {
  font-size: 16px;
  color: #000;
}
.scheme .all {
  font-size: 16px;
  color: #000;
}
.scheme .red {
  font-size: 18px;
  color: #ec0000;
  padding-top: 37px;
}
.scheme .red span {
  font-size: 12px;
  color: #666666;
}
.scheme .inner {
  position: relative;
  width: 100%;
}
.scheme .black {
  width: 100%;
  height: 100%;
  background-color: #000;
  opacity: 0.4;
  position: absolute;
  transition-duration: .5s;
}
.scheme .banner {
  /* width: 564px;
  height: 323px; */
}
.scheme .smart {
  font-size: 18px;
  color: #292929;
  position: absolute;
  bottom: 100px;
  left: 0;
  right: 0;
  text-align: center;
}
.scheme .lists {
  width: 100%;
  margin: 46px auto 0;
}
.scheme .lists li {
  display: inline-block;
  margin-right: 8px;
}
#inner {
  width: 93.6%;
  margin: 0 auto 38px;
  /* height: 508px; */
}
#inner .swiper-slide {
  text-align: center;
  font-size: 18px;
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
}
#inner .swiper-slide-active{
  -webkit-transform: scale(1);
  -moz-transform: scale(1);
  -ms-transform: scale(1);
  -o-transform: scale(1);
  transform: scale(1);
  z-index: 1;
}
#inner .swiper-slide-active .banner + .black {
  background-color: transparent!important;
  transition-duration: .5s;
}
#inner .swiper-slide-active .banner {
  /* width: 564px;
  height: 323px; */
}
#inner .swiper-pagination-bullet {
  width: 90px!important;
  height: 64px!important;
  display: inline-block;
  border-radius: 0!important;
  opacity: 0.5;
  background: url("../assets/meal/banner.png");
  background-size: 90px 64px;
}
.pa {
  position: static!important;
  margin-top: 76px;
}
#inner .swiper-pagination-bullet-active {
  border: 1px solid #dfdfdf !important;
  opacity: 1!important;
}
#inner .swiper-pagination-bullet .img {
  width: 90px!important;
  height: 64px!important;
}
.teamh {
  padding: 110px 0 77px;
}
.team {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.team p {
  font-size: 36px;
  line-height: 54px;
  letter-spacing: 1px;
  color: #333333;
}
.team span {
  font-size: 18px;
  color: #595757;
  margin-bottom: 57px;
}
.team img {
  width: 750px;
  height: 424px;
}
.obtain {
  display: flex;
  padding-top: 45px;
  justify-content: center;
}
.obtain button {
  border: none;
  outline: none;
  font-size: 20px;
  color: #fff;
  padding: 13px 33px;
  background-color: #d42f31;
  margin-bottom: 18px;
  cursor: pointer;
}
.more {
  font-size: 0;
  text-align: center;
  margin-bottom: 24px;
}
.more a{
  font-size: 16px;
  display: inline-block;
  text-decoration: none;
  vertical-align: middle;
  color: #513f36;
  margin-right: 13px;;
}
.more img {
  display: inline-block;
  vertical-align: middle;
}
</style>
