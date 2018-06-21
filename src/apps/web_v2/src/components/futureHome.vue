<template>
  <div class="new-box">
    <p class="new-word">
      <img src="../assets/personalTailor/word2.png" alt="">&nbsp;&nbsp;&nbsp;&nbsp;
      <img src="../assets/personalTailor/word1.png" alt="">
    </p>
    <p class="new-look">
      <!-- <ul class="new-list">
        <li v-for="(v, k) in icons" :key="k">
          <img :src="v.img" alt="">
        </li>
      </ul> -->
    </p>
    <div class="new-swiper">
      <!-- swiper -->
      <swiper :options="swiperOption">
        <swiper-slide v-for="(v, k) in banners" :key="k">
          <img v-img:my-group :src="v.img" alt="">
        </swiper-slide>
        <div class="swiper-button-prev swiper-button-white" slot="button-prev"></div>
        <div class="swiper-button-next swiper-button-white" slot="button-next"></div>
      </swiper>
    </div>
  </div>
</template>
<script>
import close1 from '../assets/personalTailor/close1.jpg'
import close2 from '../assets/personalTailor/close2.jpg'
import close3 from '../assets/personalTailor/close3.jpg'
import close4 from '../assets/personalTailor/close4.jpg'
import close5 from '../assets/personalTailor/close5.jpg'
import close6 from '../assets/personalTailor/close6.jpg'
import icon1 from '../assets/personalTailor/icon1.png'
import icon2 from '../assets/personalTailor/icon2.png'
import icon3 from '../assets/personalTailor/icon3.png'
import icon4 from '../assets/personalTailor/icon4.png'
import icon5 from '../assets/personalTailor/icon5.png'
export default {
  name: 'future-home',
  data () {
    return {
      banners: [
        {
          img: close1
        },
        {
          img: close2
        },
        {
          img: close3
        },
        {
          img: close4
        },
        {
          img: close5
        },
        {
          img: close6
        }
      ],
      icons: [
        {
          img: icon4
        },
        {
          img: icon2
        },
        {
          img: icon3
        },
        {
          img: icon1
        },
        {
          img: icon5
        }
      ],
      swiperOption: {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        loop: true,
        autoplay: true,
        speed: 1000,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        },
        coverflowEffect: {
          rotate: 50,
          stretch: 0,
          depth: 100,
          modifier: 1,
          slideShadows: true
        }
      }
    }
  }
}
</script>
<style scoped>
.new-box {
  /* margin-top: 50px; */
  width: 100%;
  height: 898px;
  background: #183143 url('../assets/personalTailor/new-bg.png');
}
.new-word {
  padding: 116px 0 27px;
}
.new-list {
  height: 57px;
  margin-bottom: 97px;
  display: flex;
  justify-content: center;
}
.new-list li {
  float: left;
  margin-right: 16px;
}
.new-list li:nth-child(5) {
  margin-right: 0;
}
.new-swiper {
  width: 1200px;
  /* margin: 0 auto; */
  margin: 100px auto 0;
}
.swiper-inner {
  width: 100%;
  height: 400px;
  padding-top: 50px;
  padding-bottom: 50px;
}
.swiper-slide {
  background-position: center;
  background-size: cover;
  width: 600px;
  height: 450px;
}
.swiper-slide img {
  width: 600px;
  height: 450px;
}
</style>
