<template>
  <div class="swiper-container">
    <swiper :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="(item, index) in banners" :key="index">
        <img :src="item.imgUrl" alt="swiper-image" class="swiper-image">
      </swiper-slide>
      <div class="swiper-pagination" slot="pagination"></div>
      <!--<div class="swiper-button-prev swiper-button-white" slot="button-prev"></div>-->
      <!--<div class="swiper-button-next swiper-button-white" slot="button-next"></div>-->
    </swiper>
  </div>
</template>
<script>
import img from '../assets/home/banner.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'index',
  data () {
    return {
      banners: [
        {imgUrl: img},
        {imgUrl: img},
        {imgUrl: img}
      ],
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
  methods: {
  },
  components: {
    swiper, swiperSlide
  }
}
</script>
<style scoped>
  .swiper-container {
    width: 100%;
    height: 100%;
  }

  .swiper-wrapper {
    width: 100%;
    /*height: 100%;*/
  }
  .swiper-slide {
    background-position: center;
    background-size: cover;
    width: 100%;
    /*height: 100%;*/
  }
  .swiper-slide img {
    width: 100%;
    /*height: 100%;*/
  }
  .swiper-pagination-bullet {
    width:0.833rem;
    height: 0.833rem;
    display: inline-block;
    background: #7c5e53;
  }
</style>
