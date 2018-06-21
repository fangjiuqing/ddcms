<template>
  <div class="entity">
    <Head/>
    <div class="container">
      <swiper :options="swiperOption" ref="mySwiper">
        <swiper-slide v-for="(item, index) in banners" :key="index">
          <img :src="item.imgUrl" alt="swiper-image" class="swiper-image">
          <div class="appointment">
            <div class="content">
              <div class="hot">
                <div class="hot-left">
                  <p class="already">已经有</p>
                  <p>小伙伴</p>
                </div>
                <div class="hot-mid">
                  <span>3638</span>
                </div>
                <div class="hot-right">
                  <span>+</span>
                  <p>AlREADY</p>
                  <p>THERE  ARE</p>
                </div>
              </div>
              <div class="title">
                <p>预约了黄山智装展厅的体验</p>
                <span>A RESERVATION FOR <i>THE EXPERIENCE OF</i></span>
              </div>
              <button class="btn">立即预约</button>
            </div>
          </div>
        </swiper-slide>
        <div class="swiper-pagination pag" slot="pagination"></div>
      </swiper>
    </div>
    <div class="index">
        <div class="subtitle">
          <div class="line"></div>
          <span>首页</span>
          <img src="../assets/images/arrow.png">
          <a href="javascript:;">预约体验</a>
        </div>
        <ul class="list">
          <li v-for="(item, index) in imgs" :key="index" @mouseenter="show(item)" @mouseleave="show(item)">
            <img :src="item.imgUrl">
            <transition name="fade">
              <div class="tasking" v-show="item.isShow">
                <div>
                  <p>{{item.home}}</p>
                  <span>热销：{{item.craze}}</span>
                  <i>收藏：{{item.collect}}</i>
                </div>
              </div>
            </transition>
          </li>
        </ul>
    </div>
    <div class="containers">
      <h1>计划铺设展厅点</h1>
      <p>全面覆盖，全新体验，展厅全天浏览</p>
      <div class="middle">
        <div class="left">
          <div class="map">
            <div class="expect">
              敬请期待...
              <span></span>
              <span></span>
              <span></span>
              <span></span>
            </div>
            <ul class="address">
              <li v-for="(item, index) in city" :key="index">{{item.title}}</li>
            </ul>
          </div>
        </div>
        <div class="right">
          <div id="map" @click="shows">
            <img src="../assets/images/map.png" alt="">
          </div>
        </div>
        <div class="build" v-show="isShow">
          <div class="contents">
            <h3>建设中，敬请期待...</h3>
            <p>留下您的联系方式，我们会第一时间通知到您</p>
          </div>
          <form action="" class="sub">
            <p class="mobile">
              <input type="text" placeholder="请输入您的手机号">
              <input type="submit" class="btn" value="提交">
            </p>
          </form>
        </div>
      </div>
    </div>
    <foot/>
    <sideBar/>
  </div>
</template>
<script>
import Head from './head.vue'
import foot from './foot'
import sideBar from './sidebar'
import img from '../assets/images/entity-banner.png'
import img1 from '../assets/images/entity1.png'
import img2 from '../assets/images/entity2.png'
import img3 from '../assets/images/entity3.png'
import img4 from '../assets/images/entity4.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
export default {
  name: 'entity',
  metaInfo () {
    const title = '实体网点 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      banners: [{ imgUrl: img }, { imgUrl: img }, { imgUrl: img }],
      imgs: [
        {
          imgUrl: img1,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img2,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img3,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img4,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img3,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img4,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img1,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img2,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        }
      ],
      china: [],
      isShow: false,
      city: [
        {
          title: '青岛站'
        },
        {
          title: '|'
        },
        {
          title: '北京站'
        },
        {
          title: '|'
        },
        {
          title: '上海站'
        },
        {
          title: '深圳站'
        },
        {
          title: '|'
        },
        {
          title: '广州站'
        },
        {
          title: '|'
        },
        {
          title: '杭州站'
        },
        {
          title: '成都站'
        },
        {
          title: '|'
        },
        {
          title: '南京站'
        },
        {
          title: '|'
        },
        {
          title: '苏州站'
        },
        {
          title: '武汉站'
        },
        {
          title: '|'
        },
        {
          title: '长沙站'
        },
        {
          title: '|'
        },
        {
          title: '福州站'
        },
        {
          title: '厦门站'
        },
        {
          title: '|'
        },
        {
          title: '银川站'
        },
        {
          title: '|'
        },
        {
          title: '西安站'
        },
        {
          title: '济南站'
        },
        {
          title: '|'
        },
        {
          title: '重庆站'
        },
        {
          title: '|'
        },
        {
          title: '东莞站'
        },
        {
          title: '郑州站'
        },
        {
          title: '|'
        },
        {
          title: '湛江站'
        },
        {
          title: '|'
        }
      ],
      swiperOption: {
        autoplay: false,
        speed: 400,
        loop: true,
        pagination: {
          el: '.swiper-pagination',
          clickable: true
        }
      }
    }
  },
  components: {
    Head, swiper, swiperSlide, foot, sideBar
  },
  methods: {
    show (item) {
      item.isShow = !item.isShow
    },
    shows () {
      this.isShow = !this.isShow
    }
  }
}
</script>
<style scoped>
.container {
  position: relative;
}
.container img {
  width: 100%;
}
.appointment {
  width: 671px;
	height: 288px;
  background-color: rgba(255, 255, 255, 0.95);
  border-radius: 5px;
  opacity: 0.95;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.content {
  display: flex;
  flex-direction: column;
  margin: 37px 0 0 77px;
}
.hot {
  display: flex;
  margin-bottom: 26px;
}
.hot-left p {
  color: #595757;
  font-size: 18px;
}
.already {
  margin-bottom: 6px;
}
.hot-mid span {
  color: #d42f31;
  font-weight: 800;
  font-size: 48px;
  margin: 0 10px;
}
.hot-right {
  display: flex;
  text-align: left;
  flex-direction: column;
}
.hot-right span {
  font-size: 30px;
}
.hot-right p {
  word-wrap: break-word!important;
  font-size:12px!important;
  /* line-height: 18px; */
  color: #595757!important;
}
.title {
  text-align: left;
  font-size: 12px;
  margin-bottom: 25px;
}
.title p {
  font-size: 36px;
  color: #3e3a39;
  margin-bottom: 12px;
}
.title i {
  color: #cfcdcd;
}
.btn {
  width: 139px;
  height: 43px;
  background-color: #d42f31!important;
  border-radius: 5px;
  margin-left: 189px;
  font-size: 18px;
  border: 0;
  outline: none;
  color: #fff;
  cursor: pointer;
}
.tasking {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  font-size: 0.72vw;
  background: #000;
  opacity: 0.8;
}
.tasking p {
  color: #fff;
  position: absolute;
  top: 50%;
  left: 50%;
  font-size: 1vw;
  border-top: 2px solid #fff;
  border-bottom: 2px solid #fff;
  padding: 9px 0;
  transform: translate(-50%, -50%);
  z-index: 10;
}
.tasking span {
  position: absolute;
  color: #fff;
  top: 60%;
  left: 40%;
  transform: translate(-50%, -50%);
}
.tasking i {
  position: absolute;
  color: #fff;
  top: 60%;
  left: 60%;
  transform: translate(-50%, -50%);
}
.index {
  width: 1191px;
  margin: 48px auto 0;
  margin-bottom: 64px;
}
.subtitle {
  display: flex;
  font-size: 18px;
  text-align: left;
  margin: 48px 0;
}
.line {
  width: 2px;
  height: 17px;
  margin-right: 4px;
  background-color: #d42f31;
}
.subtitle img {
  margin: 0 6px;
}
.subtitle a {
  font-size: 18px;
  text-decoration: none;
  color: #d42f31;
}
.list {
  margin: 0 0 18px 10px;
  overflow: hidden;
}
.list li {
  float: left;
  position: relative;
}
.list li:nth-child(3),
.list li:nth-child(6),
.list li:nth-child(7),
.list li:nth-child(8){
  float: right;
}
.list li:nth-child(1),
.list li:nth-child(2),
.list li:nth-child(7),
.list li:nth-child(8) {
  width: 347px;
  height: 291px;
}
.list li:nth-child(2) {
  margin: 0 18px 18px;
}
.list li:nth-child(3),
.list li:nth-child(5){
  width: 451px;
  height: 620px;
}
.list li:nth-child(5){
  margin-right: 15px;
}
.list li:nth-child(4) {
  margin: 0 19px 18px 0;
}
.list li:nth-child(4),
.list li:nth-child(6){
  width: 710px;
  height: 310px;
}
.list li:nth-child(6){
  margin-bottom: 19px;
}
.list li:nth-child(8) {
  margin-right: 20px;
}
.list img {
  width: 100%;
}

.fade-enter-active, .fade-leave-active {
  transition: all 0.5s ease;
}

.fade-enter, .fade-leave-active{
  opacity: 0;
}
.containers {
  position: relative;
  width: 100%;
  margin-bottom: 124px;
}
.container h1 {
  font-size: 40px;
  color: #595757;
  margin-bottom: 12px;
}
.container p {
  color: #595757;
  font-size: 20px;
  /* margin-bottom: 53px; */
}
.middle {
  display: flex;
  width: 1200px;
  justify-content: space-around;
  margin: 0 auto;
}
.left {
  width: 177px;
  margin-left: 165px;
  margin-top: 150px;
}
.expect {
  position: relative;
  width: 177px;
  height: 40px;
  border: 1px solid #464646;
  line-height: 40px;
  margin-bottom: 16px;
}
.expect span:nth-child(1) {
  position: absolute;
  left: -2px;
  top: -2px;
  padding: 0.52vw;
  border-style: solid;
  border-color: #464646;
  border-width: 4px 0 0 4px;
}
.expect span:nth-child(3) {
  position: absolute;
  right: -2px;
  bottom: -2px;
  padding: 10px;
  border-style: solid;
  border-color: #464646;
  border-width: 0 4px 4px 0;
}
.address {
  display: flex;
  flex-wrap: wrap;
  width: 160px;
  line-height: 25px;
  justify-content: flex-start;
  font-size: 14px;
  margin-left: 13px;
}
.address li {
  margin: 0 2px;
}
.right {
  display: flex;
  justify-content: flex-end;
  position: relative;
}
.build {
  width: 337px;
  height: 171px;
  position: absolute;
  top: 25%;
  right: 25%;
  background-color: #ffffff;
  box-shadow: 0px 6px 28px 0px rgba(0, 0, 0, 0.15);
}
.contents h3 {
  padding-top: 27px;
  font-size: 18px;
  line-height: 24px;
  color: #111111;
  margin-bottom: 7px;
}
.contents p {
  font-size: 10px;
  color: #111111;
  margin-bottom: 23px;
}
.mobile {
  display: flex;
  justify-content: center;
}
.sub {
  font-size: 0;
  vertical-align: middle;
}
.sub input {
  width: 200px;
  height: 26px;
  background-color: #ffffff;
  border: solid 1px #bfbfbf;
  box-sizing: border-box;
  padding-left: 10px;
}
.sub .btn {
  width: 46px;
  height: 26px;
  color: #fff;
  cursor: pointer;
  outline: none;
  border: none;
  background-color: #d42f31;
}
.content:after{
  content: "";
  width: 0;
  height: 0;
  position: absolute;
  left: 50%;
  top: 100%;
  margin-left: -19px;
  border-right: solid 21px transparent;
  border-top: solid 21px white;
  border-left: solid 21px transparent;
}
</style>
<style>
  .pag .swiper-pagination-bullet {
    width: 48px;
    height: 4px;
    border-radius: 0;
    opacity: 0.2;
    background-color: rgba(255, 255, 255, 0.2);
  }
  .pag .swiper-pagination-bullet-active {
    opacity: 0.6;
    background-color: rgba(255, 255, 255, 0.6);
  }
</style>
