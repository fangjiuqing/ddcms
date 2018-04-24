<template>
  <div>
    <Head></Head>
    <!-- banner轮播部分 -->
    <div class="container">
      <swiper :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="(item, index) in imgs" :key="index">
        <img :src="item.imgUrl" alt="">
      </swiper-slide>
      <div class="swiper-pagination" slot="pagination" id="banner"></div>
    </swiper>
    </div>
    <!-- 小图标 -->
    <ul class="list">
      <li v-for="(item, index) in clock" :key="index">
        <img :src="item.img" alt="">
        <span>{{item.title}}</span>
      </li>
    </ul>
    <!-- 智慧整装 -->
    <div class="example">
      <div class="life">
        <h2>智慧整装，打造品质生活</h2>
        <p>科技使生活更简单，智慧家庭解决方案是我们的核心竞争力</p>
      </div>
      <div class="date">
        <div class="content">
          <div class="line"></div>
          <h2>别墅智能整装</h2>
          <span>只需30-60工作日</span>
          <p>从设计到施工入住全方面省心，给您更智能的家</p>
          <button>预约套餐</button>
          <a href="javascript:;">查看详情
            <img src="../assets/home/arrow.png" alt="">
            <img src="../assets/home/arrow.png" alt="">
          </a>
        </div>
        <div class="pic">
          <img src="../assets/home/example.png" alt="">
        </div>
      </div>
      <div class="simple">
        <div class="pho">
          <img src="../assets/home/example.png" alt="">
        </div>
        <div class="simple-c">
          <div class="line"></div>
          <h2>套餐定制</h2>
          <span>装修就是这么简单</span>
          <p>一站式服务，省事更省心</p>
          <button>预约套餐</button>
          <a href="javascript:;">查看详情
            <img src="../assets/home/arrow.png" alt="">
            <img src="../assets/home/arrow.png" alt="">
          </a>
        </div>
      </div>
    </div>
    <!-- 从工厂到家 -->
    <div class="factory">
      <div class="fact">
        <img src="../assets/home/total.png" alt="">
      </div>
      <div class="logo">
        <img src="../assets/home/logo.png" alt="">
        <div class="line"></div>
        <p class="self">自有工厂 自有品牌 工厂直销有保障</p>
        <p class="price">自建仓库 省去运输费用</p>
      </div>
      <div class="fram">
        <img src="../assets/home/farm.png" alt="">
      </div>
    </div>
    <!-- 严格甄选 -->
    <strict></strict>
    <!-- 智装设计师名家 -->
    <famous></famous>
    <!-- 智装工艺标准化 -->
    <standard></standard>
    <!-- 业主寄语 -->
    <owner></owner>
    <Foot></Foot>
  </div>
</template>
<script>
import Head from './head-nav'
import Foot from './footNav'
import strict from './strict'
import famous from './famous'
import standard from './standard'
import owner from './owner'
import img from '../assets/home/banner1.png'
import house from '../assets/home/house.png'
import print from '../assets/home/print.png'
import crown from '../assets/home/crown.png'
import clock from '../assets/home/clock.png'
import tree from '../assets/home/tree.png'
import 'swiper/dist/css/swiper.css'
import '../assets/css/dot.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
export default {
  name: 'home',
  metaInfo () {
    const title = '首页 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  components: {
    Head, Foot, swiper, swiperSlide, strict, famous, standard, owner
  },
  data () {
    return {
      imgs: [
        {imgUrl: img},
        {imgUrl: img},
        {imgUrl: img}
      ],
      clock: [
        {
          img: print,
          title: '全屋整装'
        },
        {
          img: house,
          title: '智能家居'
        },
        {
          img: tree,
          title: '全屋环保'
        },
        {
          img: crown,
          title: '自由品牌'
        },
        {
          img: clock,
          title: '58个工作日'
        }
      ],
      swiperOption: {
        autoplay: true,
        speed: 600,
        loop: true,
        pagination: {
          el: '.swiper-pagination',
          clickable: false
        }
      }
    }
  }
}
</script>
<style scoped>
.container {
  padding-top: 88px;
}
.swiper-container img {
  width: 100%;
  height: 406px;
}
.list {
  display: flex;
  justify-content: space-around;
  padding: 25px 0 47px;
}
.list li {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.list img {
  width: 67px;
  height: 67px;
  margin-bottom: 12px;
}
.list span {
  font-size: 18px;
  color: #000000;
}
.life {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.life h2 {
  font-size: 36px;
  color: #333333;
  margin-bottom: 12px;
}
.life p {
  font-size: 18px;
  color: #595757;
  margin-bottom: 50px;
}
.factory {
  width: 100%;
  height: 233px;
  background: url('../assets/home/factory-f.png') center center no-repeat;
  background-size: 100% 233px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.fact img {
  width: 91px;
  height: 74px;
}
.logo{
  display: flex;
  flex-direction: column;
  align-items: center;
}
.logo img {
  width: 120px;
  height: 45px;
}
.line {
  width: 485px;
  height: 2px;
  background-color: #ffffff;
  margin: 13px 14px 13px 24px;
}
.fram img {
  width: 87px;
  height: 73px;
}
.self, .price {
  display: flex;
  color: #fff;
  flex-direction: column;
  line-height: 24px;
  font-size: 18px
}
.date {
  width: 100%;
  display: flex;
  justify-content: space-around;
  background-color: #f1f1f1;
}
.date .content {
  padding: 28px 0 0 24px;
}
.date .line, .simple-c .line {
  width: 56px;
  height: 3px;
  margin-left: 3px;
  background-color: #d42f31;
}
.simple-c .line {
  margin: 0 0 19px 0;
}
.simple-c img, .content a img {
  width: 12px;
  height: 21px;
}
.content h2, .simple-c h2{
  font-size: 36px;
  letter-spacing: 1px;
  color: #3e3a39;
  margin-bottom: 9px;
}
.content span, .simple-c span {
  font-size: 24px;
  color: #333333;
}
.content p, .simple-c p{
  color: rgba(51, 51, 51, 0.5);
  font-size: 16px;
  line-height: 20px;
  width: 225px;
  margin: 9px 0 19px;
}
.simple-c p {
  text-align: right;
}
.content button, .simple-c button {
  width: 158px;
  height: 53px;
  background-color: #d42f31;
  outline: none;
  border: 0;
  box-shadow: 0px 3px 21px 0px rgba(0, 0, 0, 0.2);
  border-radius: 3px;
  font-size: 24px;
  letter-spacing: 1px;
  color: #fff;
  margin-bottom: 13px;
}
.content a, .simple-c a {
  display: block;
  text-decoration: none;
  color: #d42f31;
  font-size: 24px;
}
.pic img {
  width: 457px;
  height: 318px;
}
.simple {
  width: 100%;
  height: 410px;
  display: flex;
  justify-content: space-around;
  background: #fff;
}
.pho img {
  width: 457px;
  height: 318px;
  padding-top: 25px;
  /* box-shadow: 0px 4px 13px 0px rgba(176, 176, 176, 0.64); */
}
.simple-c {
  display: flex;
  padding-top: 64px;
  flex-direction: column;
  align-items: flex-end;
}
</style>
