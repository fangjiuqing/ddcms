<template>
  <div class="home">
    <topHead></topHead>
    <Common :panelShow.sync="panelShow" v-show="panelShow"/>
    <swiper :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="(item, index) in imgs" :key="index" class="imgs">
        <img :src="item.imgUrl" alt="">
      </swiper-slide>
    </swiper>
    <ul class="list">
      <li v-for="(item, index) in list" :key="index">
        <h1>{{item.title}}</h1>
        <p>{{item.subtitle}}</p>
        <img :src="item.img" alt="">
      </li>
    </ul>
    <div class="contents" v-for="items in content" :key="items.index">
      <h1>{{items.title}}</h1>
      <p>全部</p>
      <ul class="ty">
        <li v-for="item in items.type" :key="item.index">{{item}}</li>
      </ul>
      <img :src="items.banner" alt="">
      <ul class="detail">
        <li v-for="item in items.list" :key="item.index">
          <img :src="item.img" alt="">
          <h3>{{item.subtitle}}</h3>
          <p>{{item.intr}}</p>
          <span>{{item.price}}元</span>
        </li>
      </ul>
    </div>
    <ul class="guarantee">
      <li>
        <img src="../assets/home/f2c.png" alt="">
        <p>f2c模式</p>
        <span>工厂直采 缩减中间成本</span>
      </li>
      <li>
        <img src="../assets/home/o2o.png" alt="">
        <p>o2o体验</p>
        <span>线上浏览 线下体验</span>
      </li>
      <li>
        <img src="../assets/home/environment.png" alt="">
        <p>环保保证</p>
        <span>国际标准 严控质量</span>
      </li>
      <li>
        <img src="../assets/home/exchange.png" alt="">
        <p>退换无忧</p>
        <span>7天退换 3年质保</span>
      </li>
      <li>
        <img src="../assets/home/support.png" alt="">
        <p>保价承诺</p>
        <span>30天内 买贵速赔</span>
      </li>
    </ul>
    <Foot/>
  </div>
</template>

<script>
import Foot from './foot'
import topHead from './topHead'
import Common from './common'
import carousel from '../assets/home/carousel.png'
import list1 from '../assets/home/list1.png'
import list2 from '../assets/home/list2.png'
import list3 from '../assets/home/list3.png'
import list4 from '../assets/home/list4.png'
import build1 from '../assets/home/build/build1.png'
import build2 from '../assets/home/build/build2.png'
import build3 from '../assets/home/build/build3.png'
import build4 from '../assets/home/build/build4.png'
import build5 from '../assets/home/build/build5.png'
import build6 from '../assets/home/build/build6.png'
import build7 from '../assets/home/build/build7.png'
import build8 from '../assets/home/build/build8.png'
import buildBanner from '../assets/home/build/buildBanner.png'
import houseBanner from '../assets/home/house/houseBanner.png'
import single from '../assets/home/single/single.png'
import home from '../assets/home/home/home.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'foot',
  data () {
    return {
      panelShow: true,
      imgs: [
        {imgUrl: carousel},
        {imgUrl: carousel},
        {imgUrl: carousel}
      ],
      list: [
        {
          title: '高端尖货',
          subtitle: '低价成团 限时限量',
          img: list1
        },
        {
          title: '新品特惠',
          subtitle: '新品特惠 每周更新',
          img: list2
        },
        {
          title: '人气产品',
          subtitle: '热销产品 惊喜汇聚',
          img: list3
        },
        {
          title: '智能音响',
          subtitle: '极简设计 专业喇叭',
          img: list4
        }
      ],
      content: [
        {
          title: '装修建材',
          banner: buildBanner,
          type: ['照明', '开关', '插座', '空调', '智能锁', '玻璃窗', '窗帘'],
          list: [
            {
              img: build1,
              subtitle: '美国金丝进口地板',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build2,
              subtitle: '无缝瓷砖',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build3,
              subtitle: '多色地板',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build4,
              subtitle: '智能按摩枕',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容量',
              price: '1999'
            },
            {
              img: build5,
              subtitle: '大理石石材',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build6,
              subtitle: '欧米硅藻泥',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build7,
              subtitle: '人体探测器',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build8,
              subtitle: '创意瓷砖',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            }
          ]
        },
        {
          title: '全屋定制',
          banner: houseBanner,
          type: ['整体衣柜', '整体衣柜', '整体衣柜', '整体衣柜', '整体衣柜'],
          list: [
            {
              img: build1,
              subtitle: '美国金丝进口地板',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build2,
              subtitle: '无缝瓷砖',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build3,
              subtitle: '多色地板',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build4,
              subtitle: '智能按摩枕',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容量',
              price: '1999'
            }
          ]
        },
        {
          title: '单品家具',
          banner: single,
          type: ['照明', '开关', '插座', '空调', '智能锁', '玻璃窗', '窗帘'],
          list: [
            {
              img: build1,
              subtitle: '美国金丝进口地板',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build2,
              subtitle: '无缝瓷砖',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build3,
              subtitle: '多色地板',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build4,
              subtitle: '智能按摩枕',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容量',
              price: '1999'
            }
          ]
        },
        {
          title: '智能家电',
          // banner: buildBanner,
          type: ['照明', '开关', '插座', '空调', '智能锁', '玻璃窗', '窗帘'],
          list: [
            {
              img: build1,
              subtitle: '美国金丝进口地板',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build2,
              subtitle: '无缝瓷砖',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build3,
              subtitle: '多色地板',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build4,
              subtitle: '智能按摩枕',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容量',
              price: '1999'
            },
            {
              img: build5,
              subtitle: '大理石石材',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build6,
              subtitle: '欧米硅藻泥',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build7,
              subtitle: '人体探测器',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build8,
              subtitle: '创意瓷砖',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            }
          ]
        },
        {
          title: '家装家饰',
          banner: home,
          type: ['整体衣柜', '整体衣柜', '整体衣柜', '整体衣柜', '整体衣柜'],
          list: [
            {
              img: build1,
              subtitle: '美国金丝进口地板',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build2,
              subtitle: '无缝瓷砖',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build3,
              subtitle: '多色地板',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容',
              price: '1999'
            },
            {
              img: build4,
              subtitle: '智能按摩枕',
              intr: '钢琴烤漆简约百搭经典双层抽屉大容量',
              price: '1999'
            }
          ]
        }
      ],
      swiperOption: {
        autoplay: false,
        speed: 600,
        loop: true
      }
    }
  },
  components: {
    Common, Foot, swiper, swiperSlide, topHead
  }
}
</script>

<style scoped>
  .swiper-container img {
    width: 100vw;
    height: 420px;
    left: 0;
  }
  .list {
    width: 1200px;
    margin: 41px auto 55px;
  }
  .list li {
    width: 279px;
    height: 160px;
    background-color: #f6f6f6;
    display: inline-block;
    text-align: left;
    position: relative;
    overflow: hidden;
  }
  .list li:nth-child(1),
  .list li:nth-child(2),
  .list li:nth-child(3) {
    margin-right: 27px;
  }
  .list li h1 {
    font-size: 18px;
    /*line-height: 31px;*/
    color: #3e3a39;
    margin: 31px 0 9px;
  }
  .list li p {
    font-size: 12px;
    /*line-height: 31px;*/
    color: #3e3a39;
  }
  .list li h1,
  .list li p {
    margin-left: 28px;
  }
  .list li img {
    height: 101px;
    position: absolute;
    left: 165px;
    top: 50%;
    transform: translateY(-50%);
  }
  .contents {
    width: 1200px;
    margin: 55px auto 0;
    overflow: hidden;
  }
  .contents h1 {
    font-size: 30px;
    line-height: 31px;
    color: #595757;
    border-left: 4px solid #d42f31;
    padding-left: 6px;
    float: left;
  }
  .ty {
    float: right;
    margin-right: 40px;
  }
  .ty li {
    display: inline-block;
    font-size: 16px;
    line-height: 31px;
    color: #3e3a39;
    margin-left: 15px;
  }
  .contents > p {
    font-size: 16px;
    line-height: 31px;
    color: #3e3a39;
    float: right;
  }
  .contents > p:after {
    width: 5px;
    height: 11px;
    display: inline-block;
    content: '';
    margin-left: 6px;
    background: url("../assets/home/arrow.png");
  }
  .contents > img {
    width: 100%;
    margin-top: 30px;
  }
  .detail {
    width: 100%;
    margin-top: 35px;
  }
  .detail li {
    width: 279px;
    height: 422px;
    background-color: #f9f9f9;
    display: inline-block;
    margin-bottom: 28px;
    transition-duration: .5s;
    transform:translateY(1px);
  }
  .detail li:hover {
    background-color: #fff;
    transition-duration: 0.5s;
    transform: translateY(-1px);
    box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.1);
  }
  .detail li:nth-child(1),
  .detail li:nth-child(5),
  .detail li:nth-child(2),
  .detail li:nth-child(6),
  .detail li:nth-child(3),
  .detail li:nth-child(7) {
    margin-right: 28px;
  }
  .detail li img {
    height: 197px;
    margin: 52px auto 33px;
  }
  .detail h3 {
    font-size: 18px;
    /*line-height: 31px;*/
    color: #3e3a39;
  }
  .detail p {
    font-size: 14px;
    /*line-height: 31px;*/
    color: #595757;
    margin: 13px 0 22px;
  }
  .detail span {
    font-size: 16px;
    /*line-height: 31px;*/
    color: #d42f31;
  }
  .guarantee {
    width: 1200px;
    margin: 0 auto 63px;
  }
  .guarantee li {
    display: inline-block;
  }
  .guarantee li:nth-child(1),
  .guarantee li:nth-child(2),
  .guarantee li:nth-child(3),
  .guarantee li:nth-child(4) {
    margin-right: 139px;
  }
  .guarantee img {
    width: 61px;
  }
  .guarantee p {
    font-size: 18px;
    color: #000000;
    margin: 20px 0 8px;
  }
  .guarantee span {
    font-size: 14px;
    color: #696969;
  }
</style>
