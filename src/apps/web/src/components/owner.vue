<template>
  <div class="owner">
    <h3>业主专访</h3>
    <p>真实案例  全面审核  业主售后点评</p>
    <div class="middle">
      <swiper class="list" :options="swiperOption" ref="mySwiper">
        <swiper-slide v-for="(item, index) in banners" :key="index">
          <div class="introduce">
            <span class="lQuo"></span>
            <div class="con">
              <h4>{{item.title}}</h4>
              <p>{{item.appraise}}</p>
            </div>
            <span class="rQuo"></span>
          </div>
          <img class="study" :src="item.imgUrl" alt="">
        </swiper-slide>
        <div class="swiper-button-prev prev" slot="button-prev"></div>
        <div class="swiper-button-next prev" slot="button-next"></div>
        <div class="swiper-pagination" slot="pagination"></div>
      </swiper>
    </div>
  </div>
</template>
<script>
// import img from '../assets/home/banner.png'
import left from '../assets/home/left.png'
// import center from '../assets/home/yzhu.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'owner',
  data () {
    return {
      banners: [
        {
          imgUrl: left,
          title: '别墅——施工队的装修过程',
          appraise: '干装修这行快八年了，从学徒、绘图员、展览、工装、干到家装，一路走来历尽艰辛，终于轮到给自己的房子做设计、操持装修了，赶脚美美哒！'
        },
        {
          imgUrl: left,
          title: '唐山橡树湾——一枚设计师的装修体验',
          appraise: '干装修这行快八年了，从学徒、绘图员、展览、工装、干到家装'
        },
        {
          imgUrl: left,
          title: '别墅——施工队的装修过程',
          appraise: '干装修这行快八年了，从学徒、绘图员、展览、工装、干到家装，一路走来历尽艰辛，终于轮到给自己的房子做设计、操持装修了，赶脚美美哒！'
        }
      ],
      swiperOption: {
        loop: false,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        },
        pagination: {
          bulletClass: 'bullet',
          bulletActiveClass: 'bulletActive',
          el: '.swiper-pagination',
          clickable: true
        }
      }
    }
  },
  components: {
    swiper, swiperSlide
  }
}
</script>
<style>
.owner {
  width: 100%;
  background-color: #fff;
  margin-bottom: 75px;
}
 .owner .middle {
  width: 1280px;
  /*height: 409px;*/
  position: relative;
  left: 0;
  right: 0;
  /*top: 90px;*/
  bottom: 0;
  margin: 0 auto;
}
.owner h3 {
  padding-top: 85px;
  font-size: 40px;
  color: #111111;
  margin-bottom: 16px;
}
.owner > p {
  font-size: 20px;
  color: #595757;
  margin-bottom: 85px;
}
.owner .study {
  width: 661px;
  height: 409px;
  position: absolute;
  left: 0;
  top: 0;
}
.owner .introduce {
  width: 619px;
  height: 409px;
  position: relative;
  left: 661px;
  text-align: left;
}
.owner .introduce span {
  width: 53px;
  height: 46px;
  display: inline-block;
  position: absolute;
}
.owner .lQuo {
  background: url('../assets/home/lQuo.png') no-repeat;
  background-size: 53px 46px;
  left: 3vw;
}
.owner .rQuo {
  background: url('../assets/home/rQuo.png') no-repeat;
  background-size: 53px 46px;
  right: 41px;
  bottom: 41px;
}
.owner .con {
  /*margin: 2vw 0 0 8vw;*/
  position: absolute;
  top: 48px;
  left: 160px;
}
.owner h4 {
  font-size: 24px;
  color: #565656;
}
.owner .introduce p {
  width: 100%;
  font-family: MicrosoftYaHei;
  line-height: 24px;
  font-size: 16px;
  color: #565656;
  margin-top: 40px;
}
  .prev {
    width: 26px;
    height: 53px;
    background-size: 26px 53px;
  }
  .owner .swiper-pagination {
    position: static;
    margin-top: 18px;
  }
</style>
