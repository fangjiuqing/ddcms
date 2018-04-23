<template>
<div class="cover">
  <div class="title">
    <h3>业主寄语</h3>
    <p class="subhead">万千家庭口碑见证 解决了多种家居问题</p>
  </div>
  <div class="content">
    <swiper class="list" :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="(item, index) in banners" :key="index">
        <div class="back">
          <img class="study" :src="item.imgUrl" alt="">
        </div>
        <div class="famous">
          <img src="../assets/home/hind.png" alt="" class="hind">
          <h4>{{item.title}}</h4>
          <p>{{item.content[0]}}</p>
          <p>{{item.content[1]}}</p>
          <div class="behind">
            <img src="../assets/home/behind.png" alt="">
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
          title: '唐山橡树湾——一枚设计师的装修体验',
          content: [
            `干装修这行快八年了，从学徒、绘图员、展览、工装、干到家装，一路走来历尽艰辛，终于轮到给自己的房子做设计、操持装修了，赶脚美美哒！ 房子是三居两卫，看遍了唐山的大小楼盘，才选择了这一款。`,
            `我是唐山的房子，在上海上班，无意间路过上海浦东周浦的一家道达智装店铺，本来没打算签约，销售给我搭配后，觉得很满意，当场考虑一番后果断下单，从硬装、软装、灯具、再到家具、窗帘......`
          ]
        },
        {
          imgUrl: left,
          title: '唐山橡树湾——一枚设计师的装修体验',
          content: [
            `干装修这行快八年了，从学徒、绘图员、展览、工装、干到家装，一路走来历尽艰辛，终于轮到给自己的房子做设计、操持装修了，赶脚美美哒！ 房子是三居两卫，看遍了唐山的大小楼盘，才选择了这一款。`,
            `我是唐山的房子，在上海上班，无意间路过上海浦东周浦的一家道达智装店铺，本来没打算签约，销售给我搭配后，觉得很满意，当场考虑一番后果断下单，从硬装、软装、灯具、再到家具、窗帘......`
          ]
        },
        {
          imgUrl: center,
          title: '唐山橡树湾——一枚设计师的装修体验',
          content: [
            `干装修这行快八年了，从学徒、绘图员、展览、工装、干到家装，一路走来历尽艰辛，终于轮到给自己的房子做设计、操持装修了，赶脚美美哒！ 房子是三居两卫，看遍了唐山的大小楼盘，才选择了这一款。`,
            `我是唐山的房子，在上海上班，无意间路过上海浦东周浦的一家道达智装店铺，本来没打算签约，销售给我搭配后，觉得很满意，当场考虑一番后果断下单，从硬装、软装、灯具、再到家具、窗帘......`
          ]
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
  flex-direction: column;
  align-items: center;
}
.title h3 {
  color: #3e3a39;
  padding-top: 36px;
  font-size: 36px;
  margin-bottom: 11px;
}
.subhead {
  font-size: 18px;
  color: #595757;
  margin-bottom: 32px;
}
.back {
  width: 661px;
  height: 410px;
  margin: 0 auto 38px;
}
.study {
  width: 661px;
  height: 410px;
}
.famous {
  width: 515px;
  margin: 0 auto 89px;
}
.famous h4 {
  letter-spacing: 1px;
  color: #3e3a39;
  font-size: 28px;
  margin-bottom: 36px;
}
.famous p {
  font-size: 24px;
  line-height: 36px;
  letter-spacing: 1px;
  color: #565656;
}
.famous img {
  width: 53px;
  height: 46px;
}
.hind {
  transform: translate(-140%, 0);
}
.behind {
  transform: translate(100%, 0);
}
</style>
