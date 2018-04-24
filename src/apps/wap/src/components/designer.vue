<template>
  <div>
    <Head></Head>
    <swiper :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="item in designer" :key="item.index">
        <div class="banner">
          <div class="left">
            <h2>{{item.des_name}}</h2>
            <p class="en"></p>
            <p class="intr">{{item.des_slogan}}</p>
            <div class="line"></div>
          </div>
          <div class="right">
            <img :src="item.des_cover" alt="">
          </div>
        </div>
      </swiper-slide>
    </swiper>
    <div class="classify">
      <select name="style" class="style" id="style">
        <option value="index" v-for='(item, index) in style' :key='index'>{{item}}</option>
      </select>
      <select name="room" class="style" id="room">
        <option value="index" v-for='(item, index) in room' :key='index'>{{item}}</option>
      </select>
    </div>
    <ul class="experience">
      <li v-for="(items, index) in designer" :key="index">
        <router-link :to="{name:'designer-detail', query: { designerId: items.des_id}}">
          <img :src="items.des_cover" alt="">
          <div class="all">
            <span class="name">{{items.des_name}}</span>
            <span class="trait">{{items.des_concept_tags}}</span>
            <ul class="detail">
              <li>
                <span>{{items.province}} </span><span>{{items.city}}</span>
              </li>
              <li>
                <span>{{items.des_price}}元/平方米</span>
              </li>
              <li>
                <span>{{items.des_workyears}}年设计经验</span>
              </li>
              <li>
                <span>{{items.des_title}}</span>
              </li>
            </ul>
            <span class="dstyle" v-for="(item, index) in items.stags" :key="index">{{item}}</span>
          </div>
        </router-link>
      </li>
    </ul>
    <Foot></Foot>
  </div>
</template>
<script>
import Head from './head-nav'
import Foot from './footNav'
// import head from '../assets/designer/head.png'
// import designer1 from '../assets/designer/designer1.png'
// import designer2 from '../assets/designer/designer2.png'
// import designer3 from '../assets/designer/designer3.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'designer',
  data () {
    return {
      // head: [
      //   {
      //     img: head,
      //     name: '韩松言',
      //     en: 'Han Songyan',
      //     intr: '全国杰出设计师，注重人与自然的亲合，协调意境之美,以及情景交融的“象外之像”。'
      //   },
      //   {
      //     img: head,
      //     name: '韩松言',
      //     en: 'Han Songyan',
      //     intr: '全国杰出设计师，注重人与自然的亲合，协调意境之美,以及情景交融的“象外之像”。'
      //   },
      //   {
      //     img: head,
      //     name: '韩松言',
      //     en: 'Han Songyan',
      //     intr: '全国杰出设计师，注重人与自然的亲合，协调意境之美,以及情景交融的“象外之像”。'
      //   }
      // ],
      style: [
        '设计分类',
        '全部',
        '现代简约',
        '新中式',
        '后现代',
        '地中海',
        '美式田园',
        '古典欧式'
      ],
      room: [
        '擅长风格',
        '全部',
        '别墅',
        '标准房型'
      ],
      designer: [
        // {
        //   url: designer1,
        //   name: 'designer-detail',
        //   dname: '王德渊',
        //   detail: [
        //     '四川 成都', '999元/平方米', '首席设计师', '7年设计经验'
        //   ],
        //   trait: '/追求潮流化与生活化的最佳融合点',
        //   style: [
        //     '简约', '复古', '轻奢', '美式'
        //   ]
        // }
        // {
        //   url: designer2,
        //   name: 'designer-detail',
        //   dname: '王德渊',
        //   detail: [
        //     '四川 成都', '999元/平方米', '首席设计师', '7年设计经验'
        //   ],
        //   trait: '/追求潮流化与生活化的最佳融合点',
        //   style: [
        //     '简约', '复古', '轻奢'
        //   ]
        // },
        // {
        //   url: designer3,
        //   name: 'designer-detail',
        //   dname: '王德渊',
        //   detail: [
        //     '四川 成都', '999元/平方米', '首席设计师', '7年设计经验'
        //   ],
        //   trait: '/追求潮流化与生活化的最佳融合点',
        //   style: [
        //     '简约', '复古', '轻奢', '美式'
        //   ]
        // },
        // {
        //   url: designer1,
        //   name: 'designer-detail',
        //   dname: '王德渊',
        //   detail: [
        //     '四川 成都', '999元/平方米', '首席设计师', '7年设计经验'
        //   ],
        //   trait: '/追求潮流化与生活化的最佳融合点',
        //   style: [
        //     '简约', '复古', '轻奢', '美式'
        //   ]
        // }
      ],
      swiperOption: {
        autoplay: true,
        speed: 600,
        loop: true
      }
    }
  },
  components: {
    Head, Foot, swiper, swiperSlide
  },
  methods: {
    getImg () {
      this.$http.post('public/designer/index').then(d => {
        console.log(d.msg)
        if (d.code === 0) {
          this.designer = this.designer.concat(d.msg.list)
        }
      })
    }
  },
  mounted () {
    this.getImg()
  }
}
</script>
<style scoped>
.swiper-container {
  margin: 88px auto 0;
}
.banner {
  width: 100%;
  height: 49.8vw;
  position: relative;
  background: url(../assets/designer/bannerBg.png) center/cover no-repeat;
  overflow: hidden;
}
/* @media screen and (min-width: 736px) {
  .banner {
    height: 40vw;
  }
}
@media screen and (min-width: 1024px) {
  .banner {
    height: 30vw;
  }
} */
.left {
  width: 45.2%;
  height: 50%;
  position: absolute;
  left: 6.8vw;
  top: 0;
  bottom: 0;
  margin: auto 0;
}
.left h2 {
  font-size: 36px;
  line-height: 36px;
  letter-spacing: 1px;
  color: #ffffff;
}
.en {
  font-family: Rage-Italic;
  font-size: 30px;
  color: #ffffff;
  margin: 9px 0 33px;
}
.intr {
  font-size: 20px;
  line-height: 30px;
  color: #ffffff;
}
.line {
  width: 101px;
  height: 1px;
  background-color: #ffffff;
  margin-top: 44px;
}
.right {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  right: 11.2vw;
}
.right img {
  width: 224px;
  height: 298px;
}
classify {
  text-align: center
}
.style {
  width: 49.8%;
  height: 100px;
  font-size: 30px;
  line-height: 30px;
  letter-spacing: 1px;
  color: #595757;
  border-bottom: solid 1px #d8d8d8;
  border-top: 0;
  border-left: 0;
  display: inline-block;
}
option {
  font-size: 15px;
}
#room {
  border-right: 0;
  margin-left: -6px;
}
.experience {
  width: 93.6%;
  margin: 25px auto 47px;
}
.experience > li {
  background-color: #ffffff;
  box-shadow: 0 10px 20px 0 rgba(0, 0, 0, 0.1);
  margin-bottom: 15px;
  position: relative;
  overflow: hidden;
}
.experience img {
  width: 22.9%;
  margin: 15px 0 15px 15px;
  float: left;
}
.all {
  margin: auto 20px;
  position: absolute;
  top: 50%;
  left: 25%;
  transform: translateY(-50%);
}
.name {
  font-size: 36px;
  line-height: 20px;
  letter-spacing: 1px;
  color: #333333;
}
.trait {
  font-size: 18px;
  line-height: 16px;
  color: #898989;
}
.detail {
  /* width: 71%; */
  display: flex;
  flex-wrap: wrap;
  margin: 19px 0 29px 0;
}
.detail li {
  width: 50%;
  display: inline-block;
  font-size: 16px;
  line-height: 30px;
  color: #767676;
  vertical-align: middle;
}
.detail li:before {
  content: " ";
  display: inline-block;
  width: 25px;
  height: 25px;
  vertical-align: middle;
  background-size: 25px;
}
.detail li:nth-child(1):before {
  background: url('../assets/designer/house.png') no-repeat;
}
.detail li:nth-child(2):before {
  background: url('../assets/designer/price.png') no-repeat;
}
.detail li:nth-child(3):before {
  background: url('../assets/designer/handson.png') no-repeat;
}
.detail li:nth-child(4):before {
  background: url('../assets/designer/job.png') no-repeat;
}
.dstyle {
  height: 28px;
  display: inline-block;
  border-radius: 14px;
  border: solid 1px #898989;
  text-align: center;
  line-height: 28px;
  font-size: 18px;
  color: #9fa0a0;
  padding: 0 10px;
  margin-right: 10px;
}
</style>
