<template>
  <div>
    <Head></Head>
    <img src="../assets/custom/banner.png" class="banner"/>
    <h1>INTERNATIONAL MASTER</h1>
    <p class="subtitle">国际大师 打造国际品牌</p>
    <ul class="master">
      <li v-for="(item, index) in master" :key="index">
        <router-link :to="{name: 'designer-detail'}" exact>
          <img :src="item" alt="">
        </router-link>
      </li>
    </ul>
    <div class="quality">
      <h1>PROCESS QUALITY</h1>
      <p class="subtitle">工艺品质 匠心精神</p>
      <ul class="process">
        <li v-for="(item, index) in quality" :key="index">
          <img :src="item.img" alt="">
          <p>{{item.craft}}</p>
        </li>
      </ul>
    </div>
    <div class="intelligence">
      <h1>INTELLIGENCE</h1>
      <p class="subtitle">全屋智能 多种模式</p>
      <swiper class="listSwiper" :options="swiperOption" ref="mySwiper">
        <swiper-slide v-for="(item, index) in intelligence" :key="index">
          <img :src="item.img" alt="" class="img">
          <div class="right">
            <p class="mode">{{item.mode}}</p>
            <img :src="item.cloud" alt="" class="cloud">
            <ul class="select">
              <li>智能唤醒</li>
              <li>智能灯光</li>
              <li>自动窗帘</li>
              <li>音乐响起</li>
              <li>自动煮饭</li>
              <li>温度调节</li>
            </ul>
          </div>
        </swiper-slide>
      </swiper>
    </div>
    <div class="degree">
      <h1>REDUCTION&nbsp;DEGREE</h1>
      <p class="subtitle">高度还原&nbsp;效果达99%</p>
      <ul class="compare">
        <li v-for="(item, index) in degree" :key="index">
          <img :src="item" alt="">
        </li>
      </ul>
    </div>
    <div class="science">
      <h1>MATERIAL&nbsp;SCIENCE</h1>
      <p class="subtitle">国际优材 工厂直供</p>
      <div class="tab">
        <div class="tabLeft">
          <div class="box">
            <div v-for="(item, index) in science" v-if="indexs===index" :key="index">
              <img :src="item" alt="">
            </div>
          </div>
          <div class="btns" v-for="(ind, index) in science" :class="{active:(indexs===index)}" @click="a(index)" :key="index">
            <img :src="ind" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="case">
      <h1>VILLA&nbsp;CASE</h1>
      <p class="subtitle">设计案例&nbsp;经典赏析</p>
      <ul class="caseList">
        <li v-for="(item, index) in cash" :key="index">
          <router-link :to="{name: 'example-detail'}" exact>
            <img :src="item" alt="">
          </router-link>
        </li>
      </ul>
    </div>
    <div class="service">
      <h1 class="head">VIP&nbsp;SERVICE</h1>
      <p class="subtitle">会员服务</p>
      <div class="vip">
        <ul class="vipList">
        <li>
          <img src="../assets/custom/design.png" alt="">
          <span>设计优势</span>
        </li>
        <li>
          <img src="../assets/custom/source.png" alt="">
          <span>资源优势</span>
        </li>
        <li>
          <img src="../assets/custom/brand.png" alt="">
          <span>品牌优势</span>
        </li>
        <li>
          <img src="../assets/custom/manage.png" alt="">
          <span>管理优势</span>
        </li>
        <li>
          <img src="../assets/custom/service.png" alt="">
          <span>售后服务</span>
        </li>
      </ul>
      </div>
    </div>
    <p class="quote" @click="showPanel">立即预约报价</p>
    <Foot></Foot>
    <Price :panelShow.sync="panelShow"></Price>
  </div>
</template>
<script>
import Head from './head-nav'
import Foot from './footNav'
import Price from './price'
import master1 from '../assets/custom/master1.png'
import master2 from '../assets/custom/master2.png'
import master3 from '../assets/custom/master3.png'
import master4 from '../assets/custom/master4.png'
import quality1 from '../assets/custom/quality1.png'
import quality2 from '../assets/custom/quality2.png'
import quality3 from '../assets/custom/quality3.png'
import intelligence1 from '../assets/custom/intelligence1.png'
import cloud from '../assets/custom/cloud.png'
import degree1 from '../assets/custom/degree1.png'
import degree2 from '../assets/custom/degree2.png'
import science1 from '../assets/custom/science1.png'
import science2 from '../assets/custom/science2.png'
import science3 from '../assets/custom/science3.png'
import science4 from '../assets/custom/science4.png'
import case1 from '../assets/custom/case1.png'
import case2 from '../assets/custom/case2.png'
import case3 from '../assets/custom/case3.png'
import case4 from '../assets/custom/case4.png'
import case5 from '../assets/custom/case5.png'
import case6 from '../assets/custom/case6.png'
import case7 from '../assets/custom/case7.png'
import case8 from '../assets/custom/case8.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'custom',
  metaInfo () {
    const title = '别墅定制 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      indexs: 0,
      panelShow: false,
      master: [
        master1, master2, master3, master4
      ],
      quality: [
        {
          img: quality1,
          craft: '油漆工工艺'
        },
        {
          img: quality2,
          craft: '木工工艺'
        },
        {
          img: quality3,
          craft: '软装工艺'
        }
      ],
      intelligence: [
        {
          img: intelligence1,
          cloud: cloud,
          mode: '起床模式'
        },
        {
          img: intelligence1,
          cloud: cloud,
          mode: '全屋智能'
        }
      ],
      degree: [
        degree1, degree2
      ],
      science: [
        science1, science2, science3, science4
      ],
      cash: [
        case1, case2, case3, case4, case5, case6, case7, case8
      ],
      swiperOption: {
        autoplay: true,
        effect: 'fade',
        speed: 400,
        loop: true
      }
    }
  },
  components: {
    Head, Foot, swiper, swiperSlide, Price
  },
  methods: {
    showPanel () {
      this.panelShow = true
    },
    a (str) {
      this.indexs = str
    }
  }
}
</script>
<style scoped>
.banner {
  width: 100%;
  margin-top: 88px;
}
h1 {
  font-family: Imprint MT Shadow;
  font-size: 35px;
  color: #111111;
  text-align: center;
  margin: 47px 0 16px;
}
.subtitle {
  font-size: 23px;
  letter-spacing: 1px;
  color: #000000;
  text-align: center;
  margin-bottom: 46px;
}
.master {
  width: 93.8%;
  margin: 0 auto 47px;
  overflow: hidden;
}
.master li {
  float: left;
  width: 25%;
}
.master li img {
  width: 175px;
  height: 351px;
}
.quality {
  width: 100%;
  height: 53vw;
  background-color: #fafafa;
  padding-top: 2px;
}
/* @media screen and (min-width: 736px) {
  .quality {
    height: 46vw;
  }
}
@media screen and (min-width: 1024px) {
  .quality {
    height: 40vw;
  }
} */
.process {
  width: 93.4%;
  margin: 23px auto 0;
}
.process li {
  display: inline-block;
  width: 32%;
}
.process li:nth-child(1),
.process li:nth-child(2) {
  margin-right: 2%;
}
.process li img {
  width: 100%;
}
.process li p {
  font-size: 18px;
  color: #000000;
  margin-top: 12px;
}
.intelligence {
  margin-top: 54px;
}
  /* .listSwiper .swiper-slide:nth-child(2n-1) .head,
  .listSwiper .swiper-slide:nth-child(2n-1) .subhead,
  .listSwiper .swiper-slide:nth-child(2n-1) .mode,
  .listSwiper .swiper-slide:nth-child(2n-1) .select,
  .listSwiper .swiper-slide:nth-child(2n-1) .con {
    color: #fff;
  } */
  .img {
    width: 100%;
  }
  .right {
    width: 30vw;
    position: absolute;
    top: 80px;
    right: 70px;
    text-align: left;
  }
  .mode {
    font-size: 38px;
    letter-spacing: 1px;
    color: #333333;
    display: inline-block;
  }
  .cloud {
    display: inline-block;
    width: 49px;
    height: 38px;
    margin-left: 10px;
  }
  .mode:after {
    content: '';
    display: block;
    width: 85px;
    height: 2px;
    background-color: #d42f31;
    margin-top: 10px;
  }
  .select {
    width: 237px;
    font-size: 18px;
    color: #727171;
    margin-top: 56px;
  }
  .select li {
    display: inline-block;
    margin-bottom: 21px;
  }
  .select li:before {
    content: '';
    display: inline-block;
    width: 17px;
    height: 17px;
    margin-right: 10px;
    background: url("../assets/custom/right.png") no-repeat;
    background-size: 17px;
    vertical-align: middle;
  }
  .degree {
    margin-top: 46px;
  }
  .compare {
    width: 94%;
    margin: 0 auto;
  }
  .compare li {
    display: inline-block;
    width: 100%;
    margin-bottom: 29px;
  }
  .compare li img {
    width: 100%;
  }
  .science {
    width: 100%;
    margin-top: 33px;
  }
  .tab {
    width: 93.6%;
    background-color: #fafafa;
    margin: 0 auto;
    padding-top: 23px;
  }
  .tabLeft {
    width: 92%;
    margin: 0 auto 29px;
    overflow: hidden;
  }
  .box {
    width: 100%;
    margin-bottom: 4px;
  }
  .box img {
    width: 100%;
  }
  .btns {
    width: 24%;
    height: 95px;
    float: left;
    margin-right: 1.3%;
    cursor: pointer;
  }
  .btns:nth-child(5) {
    margin-right: 0;
  }
  .btns img {
    width: 100%;
  }
  .active {
    border: 1px solid red;
    box-sizing: border-box
  }
  .case {
    margin-top: 47px;
  }
  .caseList {
    width: 93.6%;
    /* height: 334px; */
    margin: 0 auto;
  }
  .caseList li {
    width: 49.4%;
    display: inline-block;
  }
  .caseList li:nth-child(odd) {
    margin-right: 0.8%;
  }
  .caseList li img {
    width: 100%;
  }
  .service {
    width: 100%;
    margin-top: 46px;
  }
  .vip {
    width: 100%;
    height: 240px;
    background-color: #fafafa;
    position: relative;
  }
  .vipList {
    width: 93.6%;
    height: 44.8%;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
  }
  .vipList li {
    display: inline-block;
  }
  .vipList li:nth-child(2),
  .vipList li:nth-child(3),
  .vipList li:nth-child(4) {
    margin: 0 38px;
  }
  .vipList li:nth-child(1),
  .vipList li:nth-child(4) {
    margin-right: 38px;
  }
  .vipList li img {
    width: 80px;
    display: block;
    margin: 0 auto;
  }
  .vipList span {
    display: inline-block;
    margin-top: 14px;
    font-size: 13px;
    color: #111111;
  }
  .quote {
    width: 290px;
    height: 50px;
    background-color: #d42f31;
    margin: 42px auto 37px;
    text-align: center;
    line-height: 50px;
    font-size: 24px;
    color: #ffffff;
  }
</style>
