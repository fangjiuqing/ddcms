<template>
<div class="cover">
  <div class="title">
    <h3>智装设计名家</h3>
    <p class="subhead">万千家庭口碑见证 解决了多种家居问题</p>
  </div>
  <div class="content">
    <swiper class="list" :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="(item, index) in banners" :key="index">
        <div class="back">
          <img class="study" :src="item.imgUrl" alt="">
        </div>
        <div class="famous">
          <div class="f-name">
            <p>{{item.famous}}<span>{{item.design}}</span></p>
            <h4>{{item.name}}</h4>
            <i>{{item.eN}}</i>
            <span class="address">{{item.address}}</span>
            <p class="style">{{item.style}}</p>
            <p class="detail">{{item.idea}}</p>
          </div>
        </div>
      </swiper-slide>
      <div class="swiper-pagination" slot="pagination" id="dot"></div>
    </swiper>
  </div>
</div>
</template>
<script>
import img from '../assets/home/sjmj.png'
import left from '../assets/home/yzhu.png'
import center from '../assets/home/banner1.png'
import '../assets/css/dot.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'famous',
  data () {
    return {
      banners: [
        {
          imgUrl: img,
          famous: 'FAMOUS',
          design: 'DESIGNER',
          name: '张国强',
          eN: 'zhangguoqiang',
          address: '所在地：上海',
          style: '现代简约、欧式风格',
          idea: '设计师理念：擅长处理各种复杂的空间设计，遵行设计理念是设计源于生活，只有懂得和享受生活的人才能更合理的规划生活。生活亦设计，你的生活由“你”来定制。'
        },
        {
          imgUrl: left,
          name: '刘冰洋',
          eN: 'liubingyang',
          address: '所在地：上海',
          style: '欧式风格',
          idea: '生活亦设计，你的生活由"你"来定制。'
        },
        {
          imgUrl: center,
          name: '韩理想',
          eN: 'hanlixiang',
          address: '所在地：上海',
          style: '欧式风格',
          idea: '遵行设计理念是设计源于生活，只有懂得和享受生活的人才能更合理的规划生活。生活亦设计，你的生活由"你"来定制。'
        }
      ],
      swiperOption: {
        loop: false,
        autoplay: false,
        speed: 600,
        pagination: {
          el: '.swiper-pagination',
          clickable: false
        }
      }
    }
  },
  components: {
    swiper, swiperSlide
  }
}
</script>
<style scoped>
.cover {
  width: 100%;
}
.title {
  display: flex;
  justify-content: center;
  flex-direction: column;
  align-items: center;
}
.title h3 {
  color: #3e3a39;
  font-size: 36px;
  margin-bottom: 10px;
}
.subhead {
  color: #595757;
  font-size: 18px;
  margin-bottom: 47px;
}
.back {
  width: 576px;
  height: 390px;
  margin: 0 auto 36px;
  background-color: rgba(255, 255, 255, 0.2);
  box-shadow: 0px 7px 22px 1px rgba(48, 48, 48, 0.15);
}
.study {
  width: 560px;
  height: 374px;
  padding: 8px 0 0 8px;
}
.famous {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-bottom: 72px;
}
.f-name {
  display: flex;
  width: 576px;
  flex-direction: column;
  justify-content: flex-start;
}
.famous p {
  font-size: 24px;
  color: #595757;
  text-align: left;
}
.famous span {
  color: #000;
}
.famous h4 {
  color: #3e3a39;
  font-size: 48px;
  margin-bottom: 8px;
}
.famous i {
  font-size: 30px;
  margin-bottom: 25px;
  color: rgba(0, 0, 0, 0.7);
}
.address {
  font-size: 24px;
  letter-spacing: 1px;
  margin-bottom: 16px;
  color: rgba(89, 87, 87, 0.8);
}
.style {
  font-size: 24px;
  letter-spacing: 1px;
  margin-bottom: 20px;
  color: rgba(89, 87, 87, 0.8);
}
.detail {
  width: 497px;
  height: 178px;
  font-size: 24px;
  letter-spacing: 1px;
  line-height: 42px;
  text-align: justify;
  color: rgba(89, 87, 87, 0.8);
}
</style>
