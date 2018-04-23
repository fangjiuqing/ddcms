<template>
  <div class="strict">
    <div class="title">
      <h2>严格甄选 品质特供</h2>
      <p class="good">用料考究，层层筛选，品质保证</p>
    </div>
    <swiper class="list" :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="(item, index) in banners" :key="index">
        <div class="listmore">
          <img :src="item.imgUrl" alt="swiper-image" class="swiper-image">
          <h3 class="socket">{{item.name}}</h3>
          <p class="smart">{{item.intr}}</p>
        </div>
      </swiper-slide>
    </swiper>
    <div class="more">
      <button class="btn">查看更多</button>
    </div>
  </div>
</template>
<script>
import xgj from '../assets/home/xgj.png'
import cap from '../assets/home/cap.png'
import xgj1 from '../assets/home/voice.png'
import 'swiper/dist/css/swiper.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
export default {
  name: 'strict',
  components: {
    swiper, swiperSlide
  },
  data () {
    return {
      banners: [
        { imgUrl: xgj1,
          name: '小管家智能插座',
          intr: '当你进入黑暗空间时自动亮灯，离开时自动灭灯'
        },
        { imgUrl: cap,
          name: '小智机器人',
          intr: '智能生活，你可以和小智一起开始'
        },
        { imgUrl: xgj,
          name: '多功能智能网关',
          intr: '多功能切换，360°贴合你的作息'
        },
        { imgUrl: xgj1,
          name: '小管家智能插座',
          intr: '当你进入黑暗空间时自动亮灯，离开时自动灭灯'
        },
        { imgUrl: cap,
          name: '小智机器人',
          intr: '智能生活，你可以和小智一起开始'
        },
        { imgUrl: xgj,
          name: '多功能智能网关',
          intr: '多功能切换，360°贴合你的作息'
        }
      ],
      swiperOption: {
        autoplay: false,
        speed: 600,
        loop: true,
        slidesPerView: 3,
        centeredSlides: true
      },
      timer: ''
    }
  }
}
</script>
<style scoped>
.strict .title {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.strict h2 {
  font-size: 36px;
  color: #3e3a39;
  padding: 45px 0 13px;
}
.strict .good {
  font-size: 18px;
  color: #595757;
  margin-bottom: 51px;
}
.socket {
  color: #3e3a39;
  font-size: 24px;
  margin-bottom: 12px;
}
.smart {
  color: #595757;
  font-size: 16px;
  line-height: 20px;
  width: 203px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.listmore {
  width: 239px;
  height: 351px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
  background-color: #ffffff;
  box-shadow: 0px 2px 15px 0px rgba(0, 0, 0, 0.2);
  border-radius: 5px;
}
.listmore img {
  width: 159px;
  height: 189px;
}
.swiper-image {
  margin-bottom: 42px;
}
.more {
  display: flex;
  justify-content: center;
  padding: 45px 0 53px;
}
.btn {
  width: 158px;
  height: 53px;
  background-color: #d42f31;
  box-shadow: 0px 2px 15px 0px rgba(163, 22, 22, 0.2);
  border-radius: 3px;
  outline: none;
  border: none;
  color:#fff;
  font-size: 24px;
  text-align: center;
}
</style>
