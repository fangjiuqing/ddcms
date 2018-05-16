<template>
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
</template>
<script>
import img from '../assets/images/entity-banner.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'entity-banner',
  data () {
    return {
      banners: [{ imgUrl: img }, { imgUrl: img }, { imgUrl: img }],
      swiperOption: {
        autoplay: true,
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
    swiper,
    swiperSlide
  }
}
</script>
<style scoped>
.container {
  position: relative;
  margin-top: 71px;
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
  word-wrap: break-word;
  font-size:12px;
  line-height: 18px;
  color: #595757;
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
