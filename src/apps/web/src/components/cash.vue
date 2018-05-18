<template xmlns:>
  <div class="case">
    <Head></Head>
    <div class="customization">
      <div class="caseBanner"></div>
    </div>
    <div class="master">
      <h1 class="head">INTERNATIONAL&nbsp;MASTER</h1>
      <p class="subhead">国际大师&nbsp;打造国际品牌</p>
      <ul class="list1 list">
        <li v-for="(item, index) in list1" :key="index" @mouseenter="show(item)" @mouseleave="show(item)">
          <router-link :to="{ name: 'designerDetail', query: { designerId: item.des_id}}" exact>
            <img :src="item.des_cover" alt="">
            <transition name="fade">
              <div class="show" v-show="item.toggle">
                <span>{{item.des_name}}</span>
                <p>{{item.des_slogan}}</p>
              </div>
            </transition>
          </router-link>
        </li>
      </ul>
    </div>
    <div class="process">
      <h1 class="head">PROCESS&nbsp;QUALITY</h1>
      <p class="subhead">工艺品质&nbsp;匠心精神</p>
      <ul class="list2 list">
        <li v-for="(item, index) in list2" :key="index">
          <img :src="item.process" alt="">
          <p class="title">{{item.title}}</p>
          <p class="co">{{item.content}}</p>
        </li>
      </ul>
    </div>
    <div class="intelligence">
      <swiper class="listSwiper" :options="swiperOption" ref="mySwiper">
        <swiper-slide v-for="(item, index) in intelligence" :key="index">
          <img :src="item.img" alt="" class="img">
          <div class="right">
            <h1 class="head">INTELLIGENCE</h1>
            <p class="subhead">全屋智能&nbsp;多种模式</p>
            <p class="mode">{{item.mode}}</p>
            <img :src="item.imgAfter" alt="" class="cloud">
            <ul class="select">
              <li>智能唤醒</li>
              <li>智能灯光</li>
              <li>自动窗帘</li>
              <li>音乐响起</li>
              <li>自动煮饭</li>
              <li>温度调节</li>
            </ul>
            <p class="con">{{item.content}}</p>
          </div>
        </swiper-slide>
      </swiper>
    </div>
    <div class="degree">
      <h1 class="head">REDUCTION&nbsp;DEGREE</h1>
      <p class="subhead">高度还原&nbsp;效果达99%</p>
      <ul class="compare">
        <li v-for="(item, index) in degree" :key="index">
          <img :src="item" alt="">
        </li>
      </ul>
    </div>
    <div class="science">
      <h1 class="head">MATERIAL&nbsp;SCIENCE</h1>
      <p class="subhead">国际优才，主张环保，工厂直供，真材实价</p>
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
        <div class="tabRight">
          <div class="box">
            <div v-for="(item, index) in box" v-if="indexss===index" :key="index">
              <img :src="item" alt="">
            </div>
          </div>
          <div class="btns" v-for="(ind, index) in box" :class="{active:(indexss===index)}" @click="b(index)" :key="index">
            <img :src="ind" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="case">
      <h1 class="head">VILLA&nbsp;CASE</h1>
      <p class="subhead">设计案例&nbsp;经典赏析</p>
      <ul class="caseList">
        <li v-for="(item, index) in cash" :key="index">
          <router-link :to="{ name: 'caseDetail', query: { caseId: item.case_id }}" exact>
            <img :src="item.case_cover_sm" alt="">
          </router-link>
        </li>
      </ul>
    </div>
    <div class="service">
      <h1 class="head">VIP&nbsp;SERVICE</h1>
      <p class="subhead">会员服务</p>
      <ul class="vipList">
        <li>
          <img src="../assets/cash/service1.png" alt="">
          <span>管家式售后与保障</span>
        </li>
        <li>
          <img src="../assets/cash/service2.png" alt="">
          <span>5年质保，2小时内响应</span>
        </li>
        <li>
          <img src="../assets/cash/service3.png" alt="">
          <span>管家式售后与保障</span>
        </li>
        <li>
          <img src="../assets/cash/service4.png" alt="">
          <span>5年质保，2小时内响应</span>
        </li>
        <li>
          <img src="../assets/cash/service5.png" alt="">
          <span>管家式售后与保障</span>
        </li>
      </ul>
    </div>
    <p class="quote" @click="showPanel">立即预约报价</p>
    <foot></foot>
    <sideBar></sideBar>
    <Price :panelShow.sync="panelShow"></Price>
  </div>
</template>
<script>
import Head from './head.vue'
import Foot from './foot.vue'
import sideBar from './sidebar'
import Price from './price'
// import master1 from '../assets/cash/master1.png'
// import master2 from '../assets/cash/master2.png'
// import master3 from '../assets/cash/master3.png'
// import master4 from '../assets/cash/master4.png'
import process1 from '../assets/cash/process1.png'
import process2 from '../assets/cash/process2.png'
import process3 from '../assets/cash/process3.png'
import degree1 from '../assets/cash/degree1.png'
import degree2 from '../assets/cash/degree2.png'
import degree3 from '../assets/cash/degree3.png'
// import case1 from '../assets/cash/case1.png'
// import case2 from '../assets/cash/case2.png'
// import case3 from '../assets/cash/case3.png'
// import case4 from '../assets/cash/case4.png'
// import case5 from '../assets/cash/case5.png'
// import case6 from '../assets/cash/case6.png'
// import case7 from '../assets/cash/case7.png'
// import case8 from '../assets/cash/case8.png'
import science1 from '../assets/cash/science1.jpg'
import science2 from '../assets/cash/science2.jpg'
import science3 from '../assets/cash/science3.jpg'
import science4 from '../assets/cash/science4.jpg'
import intelligence1 from '../assets/cash/intelligence1.png'
import intelligence2 from '../assets/cash/intelligence2.png'
import cloud from '../assets/cash/cloud.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'case',
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
      indexss: 0,
      panelShow: false,
      list1: [
        // {
        //   master: master1,
        //   isShow: false,
        //   name: 'Peter Marino',
        //   intr: '拥有康奈尔大学建筑学学士学位，是美国建筑师学会会员。\n' +
        //   '目前已跻身全球一流行列，在费城、纽约、加州和巴黎都有分部，雇员超过135名。'
        // },
        // {
        //   master: master2,
        //   isShow: false,
        //   name: 'Peter Marino',
        //   intr: '拥有康奈尔大学建筑学学士学位，是美国建筑师学会会员。\n' +
        //   '目前已跻身全球一流行列，在费城、纽约、加州和巴黎都有分部，雇员超过135名。'
        // },
        // {
        //   master: master3,
        //   isShow: false,
        //   name: 'Peter Marino',
        //   intr: '拥有康奈尔大学建筑学学士学位，是美国建筑师学会会员。\n' +
        //   '目前已跻身全球一流行列，在费城、纽约、加州和巴黎都有分部，雇员超过135名。'
        // },
        // {
        //   master: master4,
        //   isShow: false,
        //   name: 'Peter Marino',
        //   intr: '拥有康奈尔大学建筑学学士学位，是美国建筑师学会会员。\n' +
        //   '目前已跻身全球一流行列，在费城、纽约、加州和巴黎都有分部，雇员超过135名。'
        // }
      ],
      list2: [
        {
          process: process1,
          title: '凝聚几代人的智慧，成就一个经典。',
          content: '艺术臻品离不开工匠的精神雕琢，一件大气磅礴的家具，都需要数个工匠花费无数的时间和心里，以纯手形式制作而成。'
        },
        {
          process: process2,
          title: '岁月的累计，才能如此完美',
          content: '主要采用欧洲、非洲等地的珍贵进口木皮，\n' +
          '如:奥古曼树权皮，黄金树权皮，黑檀木皮，树瘤木皮，酸枝木皮。'
        },
        {
          process: process3,
          title: '栩栩如生的实物描画，极致完美。',
          content: '手绘系列自文艺复兴时期，对光线色彩的追求促使威尼斯艺术家在绘图中开始重视运用各种丰富的色彩。'
        }
      ],
      science: [
        science1, science2, science3, science4
      ],
      box: [
        science1, science2, science3, science4
      ],
      intelligence: [
        {
          img: intelligence1,
          imgAfter: cloud,
          mode: '起床模式',
          content: '主窗帘慢慢自动开启，灯光柔和微亮，背景音乐缓缓响起，在音乐\n' +
          '的氛围中慢慢转醒，在柔和的乐声中醒过来。此时，主卧、客厅的窗帘慢慢徐徐拉开；\n' +
          '安防系统也自动解除了“睡眠”警戒模式；与此同时，房间内的空调系统\n' +
          '开始换风，把室外清新的空气送到房间之内...\n' +
          '新的一天如此美妙...'
        },
        {
          img: intelligence2,
          imgAfter: cloud,
          mode: '全屋智能',
          content: '主窗帘慢慢自动开启，灯光柔和微亮，背景音乐缓缓响起，在音乐\n' +
          '的氛围中慢慢转醒，在柔和的乐声中醒过来。此时，主卧、客厅的窗帘慢慢徐徐拉开；\n' +
          '安防系统也自动解除了“睡眠”警戒模式；与此同时，房间内的空调系统\n' +
          '开始换风，把室外清新的空气送到房间之内...\n' +
          '新的一天如此美妙...'
        }
      ],
      degree: [
        degree1, degree2, degree3
      ],
      cash: [
        // case1, case2, case3, case4, case5, case6, case7, case8
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
    swiper, swiperSlide, Head, Foot, sideBar, Price
  },
  methods: {
    show (item) {
      item.toggle = !item.toggle
    },
    showPanel () {
      this.panelShow = true
    },
    a (str) {
      this.indexs = str
    },
    b (str) {
      this.indexss = str
    },
    getImg: function () {
      this.$http.post('public/case/index', {}).then(d => {
        // console.log('gather=========', d.data)
        if (d.code === 0) {
          // for (let i = 0; i < d.data.length; i++) {
          this.cash = this.cash.concat(d.data[0].list)
          this.cash = this.cash.concat(d.data[2].list)
          // }
        } else {
        }
      })
    },
    getList: function () {
      this.$http.post('public/designer/index', {}).then(d => {
        // console.log('designerList=========', d.msg)
        if (d.code === 0) {
          this.list1 = this.list1.concat(d.msg.list[0])
          this.list1 = this.list1.concat(d.msg.list[1])
          this.list1 = this.list1.concat(d.msg.list[2])
          this.list1 = this.list1.concat(d.msg.list[3])
        } else {
        }
      })
    }
  },
  created () {
    this.getImg()
    this.getList()
  }
}
</script>
<style scoped>
  .customization {
    position: relative;
    margin-top: 71px;
  }
  .caseBanner {
    height: 500px;
    background: url("../assets/cash/banner.png")  no-repeat center 0;
  }
  .master {
    width: 100%;
    /*height: 742px;*/
    padding-top: 93px;
    background-color: #fafafa;
  }
  .head {
    font-family: Imprint MT Shadow;
    font-size: 59px;
    color: #111111;
  }
  .subhead {
    font-family: MicrosoftYaHei;
    font-size: 29px;
    letter-spacing: 1px;
    color: #000000;
    margin: 26px 0 85px;
  }
  .list {
    width: 1010px;
    overflow: hidden;
    margin: 0 auto;
  }
  .list1 li {
    position: relative;
  }
  .show {
    width: 220px;
    height: 188px;
    background-color: rgba(0, 0, 0, 0.5);
    position: absolute;
    bottom: 3px;
    padding: 0 15px;
    text-align: left;
  }
  .show span {
    display: inline-block;
    margin: 24px 0 20px;
    font-size: 30px;
    color: #fefefe;
    font-family: Rage Italic;
  }
  .show span:after {
    content: '';
    display: block;
    width: 69px;
    height: 1px;
    margin-top: 10px;
    background-color: #ffffff;
  }
  .show p {
    font-size: 14px;
    line-height: 24px;
    color: rgba(255, 255, 255, 0.8);
  }
  .list1 li,
  .list2 li{
    float: left;
  }
  .list1 li img {
    width: 250px;
  }
  .process {
    height: 616px;
    margin-top: 82px;
  }
  .list2 li:nth-child(2) {
    margin:0 20px;
  }
  .list2 li img,
  .list2 p {
    width: 320px;
  }
  .list2 p {
    text-align: left;
  }
  .title {
    font-size: 18px;
    color: #000000;
    margin: 17px 0 15px;
  }
  .co {
    font-size: 14px;
    line-height: 30px;
    color: #727171;
  }
  .listSwiper .swiper-slide:nth-child(2n-1) .head,
  .listSwiper .swiper-slide:nth-child(2n-1) .subhead,
  .listSwiper .swiper-slide:nth-child(2n-1) .mode,
  .listSwiper .swiper-slide:nth-child(2n-1) .select,
  .listSwiper .swiper-slide:nth-child(2n-1) .con {
    color: #fff;
  }
  .img {
    width: 100%;
  }
  .right {
    width: 28vw;
    position: absolute;
    top: 3.6vw;
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
    width: 340px;
    font-size: 18px;
    color: #727171;
    margin-top: 2.3vw;
  }
  .select li {
    display: inline-block;
    margin-bottom: 1vw;
  }
  .select li:before {
    content: '';
    display: inline-block;
    width: 17px;
    height: 17px;
    margin-right: 10px;
    background: url("../assets/construction/right.png") no-repeat;
    vertical-align: middle;
  }
  .con {
    font-size: 14px;
    line-height: 1.5vw;
    color: #898989;
  }
  .degree {
    margin-top: 95px;
  }
  .compare {
    width: 1020px;
    margin: 0 auto;
  }
  .compare li {
    display: inline-block;
    margin-right: 13px;
  }
  .science {
    width: 100%;
    height: 686px;
    background-color: #fafafa;
    padding-top: 54px;
    margin-top: 90px;
  }
  .subhead {
    margin-bottom: 46px;
  }
  .tab {
    width: 1001px;
    height: 480px;
    background-color: #ffffff;
    margin: 0 auto;
    overflow: hidden;
  }
  .tabLeft {
    width: 472px;
    height: 428px;
    float: left;
    margin: 23px 17px 29px 20px;
    /*overflow: hidden;*/
  }
  .box {
    width: 472px;
    height: 329px;
    margin-bottom: 4px;
  }
  .box img {
    width: 472px;
    height: 329px;
  }
  .btns {
    width: 115px;
    height: 95px;
    float: left;
    margin-right: 1px;
    border: 1px solid transparent;
    cursor: pointer;
  }
  .btns img {
    width: 100%;
    height: 100%;
  }
  .active {
    border: 1px solid red;
  }
  .btns:nth-child(5) {
    margin-right: 0;
  }
  .tabRight {
    width: 471px;
    height: 428px;
    float: left;
    margin: 23px 21px 29px 0;
  }
  .case {
    margin-top: 83px;
  }
  .caseList {
    width: 998px;
    height: 334px;
    margin: 0 auto;
  }
  .caseList li {
    width: 245px;
    height: 164px;
    display: inline-block;
  }
  .caseList li img {
    width: 100%;
  }
  .caseList li:nth-child(1),
  .caseList li:nth-child(2),
  .caseList li:nth-child(3),
  .caseList li:nth-child(4) {
    margin-bottom: 6px;
  }
  .caseList li:nth-child(2),
  .caseList li:nth-child(6) {
    margin: 0 6px;
  }
  .caseList li:nth-child(3),
  .caseList li:nth-child(7) {
    margin-right: 6px;
  }
  .service {
    width: 100%;
    height: 318px;
    margin-top: 118px;
    padding-top: 66px;
    background-color: #fafafa;
  }
  .vipList li {
    display: inline-block;
    margin: 0 45px;
  }
  .vipList li img {
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
    margin: 54px auto 74px;
    line-height: 50px;
    font-size: 20px;
    color: #ffffff;
  }
  .quote:hover {
    cursor: pointer;
  }

  .fade-enter-active, .fade-leave-active {
    transition: all 0.5s ease;
  }

  .fade-enter, .fade-leave-active{
    opacity: 0;
  }
</style>
