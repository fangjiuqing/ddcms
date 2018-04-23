<template>
  <div class="swiper-contain">
    <div class="tasking">
      <swiper :options="swiperOption" ref="mySwiper">
        <swiper-slide v-for="(item, index) in banners" :key="index">
          <img :src="item.imgUrl" alt="swiper-image" class="swiper-image">
          <div class="word">
            <div class="banner-word">
              <div class="word-top">
                <!--<div class="line">-->
                <!--</div>-->
                <span>{{item.solution}}</span>
                <!--<div class="right"></div>-->
              </div>
              <div class="word-mid">
                <span>{{item.ca}}</span>
              </div>
              <div class="word-foot">
                <span>{{item.room}}</span>
              </div>
            </div>
            <!--<div class="play"></div>-->
            <!--<div class="play-s"></div>-->
            <div class="chose">立即获取智装方案</div>
          </div>
        </swiper-slide>
        <div class="swiper-pagination pag" slot="pagination"></div>
        <!--<div class="swiper-button-prev swiper-button-white" slot="button-prev"></div>-->
        <!--<div class="swiper-button-next swiper-button-white" slot="button-next"></div>-->
      </swiper>
    </div>
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
        {
          imgUrl: img,
          solution: 'INTELLIGENT FAMILY SOLUTION',
          ca: '道达智装 智慧家庭解决方案',
          room: '五大空间 八大生活场景集成设计'
        },
        {
          imgUrl: img,
          solution: 'INTELLIGENT FAMILY SOLUTION',
          ca: '道达智装 智慧家庭解决方案',
          room: '五大空间 八大生活场景集成设计'
        },
        {
          imgUrl: img,
          solution: 'INTELLIGENT FAMILY SOLUTION',
          ca: '道达智装 智慧家庭解决方案',
          room: '五大空间 八大生活场景集成设计'
        }
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
  .swiper-contain {
    margin-top: 71px;
  }
  .tasking {
    position: relative;
  }
  .swiper-slide img {
    width: 100%;
  }
  .word {
  z-index: 10000;
  width: 622px;
  height: 32vw;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
}
.banner-word .word-top {
  width: 100%;
  float: left;
  margin-bottom: 12px;
  position: relative;
}
.word-top span:before, .word-top span:after {
  content: '';                 /*CSS伪类用法*/
  position: absolute;         /*定位背景横线的位置*/
  top: 52%;
  background: #ffffff;       /*宽和高做出来的背景横线*/
  width: 18%;
  height: 1px;
}
.word-top span:before{
  left: 26px;        /*调整背景横线的左右距离*/
}
.word-top span:after {
  right: 26px;
}
.banner-word .word-top span {
  font-size: 1.2vw;
  color: #ffffff;
}
.banner-word .word-mid {
  letter-spacing: 2px;
  margin-bottom: 22px;
}
.banner-word .word-mid span{
  /*width: 38.9rem;*/
  /*height: 2.9rem;*/
  font-size: 48px;
  color: #ffffff;
}
.banner-word .word-foot {
  letter-spacing: 1px;
}
.banner-word .word-foot span{
  text-align: center;
  width: 363px;
  font-size: 18px;
  color: rgba(255, 255, 255, 0.5);
}
.chose {
  width: 314px;
  height: 53px;
  background-color: #d42f31;
  box-shadow: 0 3px 16px 0 rgba(0, 0, 0, 0.3);
  border-radius: 5px;
  line-height: 53px;
  font-size: 24px;
  color: #fff;
  position: absolute;
  left: 50%;
  bottom: 5%;
  transform: translate(-50%);
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
