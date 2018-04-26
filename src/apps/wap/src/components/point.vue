<template>
  <div>
    <Head></Head>
    <div class="banner">
      <swiper :options="swiperOption" ref="mySwiper">
        <swiper-slide v-for="(item, index) in imgs" :key="index">
          <img :src="item.imgUrl" alt="">
          <div class="rightnow">
            <div class="content" v-for="(item, index) in confirm" :key="index">
              <div class="word">
                <div class="alread">
                  <p>{{item.already[0]}}</p>
                  <p class="partner">{{item.already[1]}}</p>
                </div>
                <span class="num">{{item.num}}</span>
                <div class="en">
                  <span>{{item.add}}</span>
                  <p>{{item.en[0]}}</p>
                  <p>{{item.en[1]}}</p>
                </div>
              </div>
              <h2>{{item.title}}</h2>
              <span class="entitle">{{item.entitle[0]}}</span>
              <span class="entit">{{item.entitle[1]}}</span>
              <button class="btn">立即预约</button>
            </div>
          </div>
        </swiper-slide>
        <div class="swiper-pagination" slot="pagination" id="banner"></div>
      </swiper>
    </div>
    <div class="photo">
      <ul class="list">
        <li>
          <img src="../assets/taste/pointa.png" alt="">
        </li>
        <li>
          <img src="../assets/taste/pointb.png" alt="">
        </li>
      </ul>
      <ul class="list1">
        <li>
          <img src="../assets/taste/pointc.png" alt="">
        </li>
      </ul>
      <ul class="list2">
        <li>
          <img src="../assets/taste/pointd.png" alt="">
        </li>
        <li>
          <img src="../assets/taste/pointd.png" alt="">
        </li>
      </ul>
      <ul class="list3">
        <li>
          <img src="../assets/taste/pointc.png" alt="">
        </li>
      </ul>
      <ul class="list4">
        <li>
          <img src="../assets/taste/pointa.png" alt="">
        </li>
        <li>
          <img src="../assets/taste/pointb.png" alt="">
        </li>
      </ul>
    </div>
    <div class="map">
      <h3>计划展厅铺设点</h3>
      <p>全面覆盖，全新体验，展厅全天浏览</p>
      <img src="../assets/taste/map.png" alt="">
    </div>
    <div class="expect">
      <h4>建设中，敬请期待...</h4>
      <span>留下您的联系方式，我们会第一时间通知到您</span>
      <form action="" class="form">
        <input type="text" placeholder="请输入您的手机号">
        <button>提交</button>
      </form>
    </div>
    <Foot></Foot>
  </div>
</template>
<script>
import Head from './head-nav'
import Foot from './footNav'
import img from '../assets/taste/banner.png'
export default {
  name: 'point',
  metaInfo () {
    const title = '实体网点 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      imgs: [
        {imgUrl: img},
        {imgUrl: img},
        {imgUrl: img}
      ],
      swiperOption: {
        autoplay: false,
        speed: 600,
        loop: true,
        pagination: {
          el: '.swiper-pagination',
          clickable: false
        }
      },
      confirm: [
        {
          already: [
            '已经有',
            '小伙伴'
          ],
          num: 3638,
          add: '+',
          en: [
            'Already',
            'there are'
          ],
          title: '预约了黄山智装展厅的体验',
          entitle: [
            'A reservation',
            'for the experience of '
          ]
        }
      ]
    }
  },
  components: {
    Head, Foot
  }
}
</script>
<style scoped>
.banner {
  position: relative;
  width: 100%;
  height: 315px;
  padding-top: 88px;
  margin-bottom: 16px;
}
.banner img {
  width: 100%;
  height: 315px;
}
.rightnow {
  position: absolute;
  width: 560px;
  height: 240px;
  background-color: rgba(255, 255, 255, 0.95);
  border-radius: 5px;
  opacity: 0.95;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.content {
  display: flex;
  flex-direction: column;
  margin: 40px 0 0 64px;
}
.word {
  display: flex;
  width: 100%;
  flex-wrap: wrap;
}
.alread {
  display: flex;
  flex-direction: column;
  margin-right: 8px;
}
.alread p {
  font-size: 16px;
  color: #595757;
}
.partner {
  line-height: 30px;
}
.num {
  font-size: 40px;
  line-height: 30px;
  margin-right: 9px;
  color: #d42f31;
  font-weight: bold;
}
.en {
  display: flex;
  flex-direction: column;
}
.en span {
  font-size: 26px;
  color: #595757;
}
.en p {
  font-size: 10px;
  line-height: 14px;
  color: #595757;
}
h2 {
  font-size: 30px;
  color: #3e3a39;
  padding: 9px 0 4px;
}
.entitle {
  font-size: 10px;
  line-height: 14px;
  color: #777575;
}
.entit {
  font-size: 10px;
  color: #212121;
}
.btn {
  width: 112px;
  height: 35px;
  position: absolute;
  background-color: #d42f31;
  border-radius: 3px;
  outline: none;
  border: 0;
  color: #fff;
  bottom: 6%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 18px;
}
.list, .list1, .list2, .list3, .list4 {
  display: flex;
  width: 100%;
  justify-content: center;
  font-size: 0;
}
.list li, .list img, .list4 li, .list4 img {
  width: 343px;
  height: 288px;
}
.list li:first-child, .list4 li:first-child {
  margin: 0 16px 16px 0;
}
.list4 li {
  margin-bottom: 31px;
}
.list1 li, .list1 img ,.list3 li, .list3 img{
  width: 702px;
  height: 307px;
}
.list1 li, .list3 li {
  margin-bottom: 16px;
}
.list2 li, .list2 img {
  width: 343px;
  height: 472px;
}
.list2 li:first-child {
  margin: 0 16px 16px 0;
}
.map {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.map h3 {
  font-size: 36px;
  color: #595757;
  margin-bottom: 13px;
}
.map p {
  color: #595757;
  font-size: 18px;
  margin-bottom: 52px;
}
.map img {
  width: 676px;
  height: 504px;
  margin-bottom: 64px;
}
.expect {
  width: 702px;
  height: 317px;
  background-color: #ffffff;
  margin: 0 auto 42px;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-shadow: 0px 6px 28px 0px rgba(0, 0, 0, 0.15);
}
.expect h4 {
  font-size: 30px;
  margin: 69px 0 15px;
  color: #111111;
}
.expect span {
  font-size: 18px;
  color: #111111;
  margin-bottom: 49px;
}
.form {
  display: flex;
  width: 418px;
  height: 55px;
  background-color: #ffffff;
  border: solid 1px #bfbfbf;
}
.form input {
  display: inline-block;
  width: 80%;
  border: 0;
  outline: none;
  font-size: 24px;
  padding-left: 21px;
}
::-webkit-input-placeholder {
  font-size: 18px;
  line-height: 24px;
}
:-moz-placeholder {
  font-size: 18px;
  line-height: 24px;
}
::-moz-placeholder {
  font-size: 18px;
  line-height: 24px;
}
:-ms-input-placeholder {
  font-size: 18px;
  line-height: 24px;
}
.form button {
  display: inline-block;
  width: 25%;
  height: 56px;
  border: none;
  outline: none;
  color: #fff;
  font-size: 24px;
  background-color: #d42f31;
}
</style>
