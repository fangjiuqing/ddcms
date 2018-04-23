<template>
  <div class="model">
    <div class="intelligence">
      <swiper class="listSwiper" :options="swiperOption" ref="mySwiper">
        <swiper-slide v-for="(item, index) in model" :key="index">
          <img :src="item.img" alt="" class="img">
          <div class="light">
            <h2>{{item.mode}}</h2>
            <p>{{item.content}}</p>
          </div>
        </swiper-slide>
      </swiper>
    </div>
  </div>
</template>
<script>
import model from '../assets/meal/model.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'model',
  components: {
    swiper, swiperSlide
  },
  data () {
    return {
      swiperOption: {
        autoplay: true,
        effect: 'fade',
        speed: 400,
        loop: true
      },
      model: [
        {
          img: model,
          mode: '起夜模式',
          content: '有人经过，灯光自动打开，再也不用摸黑开灯'
        },
        {
          img: model,
          mode: '起床模式',
          content: '有人经过，灯光自动打开，再也不用摸黑开灯'
        },
        {
          img: model,
          mode: '起身模式',
          content: '有人经过，灯光自动打开，再也不用摸黑开灯'
        },
        {
          img: model,
          mode: '睡觉模式',
          content: '有人经过，灯光自动打开，再也不用摸黑开灯'
        }
      ]
    }
  }
}
</script>
<style scoped>
.model {
  width: 750px;
  height: 639px;
  margin: 0 auto;
  background-color: #383838;
}
.intelligence .img {
  width: 704px;
  height: 441px;
  margin: 91px 0 0 24px;
}
.light {
  width: 650px;
  height: 98px;
  margin-left: 50px;
  margin-top: 50px;
  background-color: #222222;
  box-shadow: 0px 15px 30px 0px rgba(0, 0, 0, 0.1);
}
.light h2 {
  font-size: 24px;
  letter-spacing: 1px;
  color: #ffffff;
  padding: 23px 0 13px 40px;
}
.light p {
  font-size: 20px;
  line-height: 24px;
  padding-left: 40px;
  color: #999999;
}
</style>
