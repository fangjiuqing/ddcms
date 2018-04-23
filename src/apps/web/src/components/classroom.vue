<template>
<div class="classroom">
  <Head></Head>
  <div class="classBanner"></div>
  <div class="conten">
    <swiper class="list" :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="(item, index) in banners" :key="index">
        <p class="new">最新资讯</p>
        <p class="fashion">THE FASHION NEW</p>
        <div class="introduce">
          <h1>{{item.name}}</h1>
          <p class="eN">{{item.eN}}</p>
          <p class="address">{{item.address}}</p>
          <p class="addr">{{item.style}}</p>
        </div>
        <img class="study" :src="item.imgUrl" alt="">
      </swiper-slide>
    </swiper>
    <div class="swiper-button-prev pre" slot="button-prev"></div>
    <div class="swiper-button-next pre" slot="button-next"></div>
  </div>
  <div class="allInformation">
    <h1>全部资讯</h1>
    <div class="middle">
      <div class="con">
        <ul class="experience">
          <li v-for="(item, index) in detail" :key="index" class="ex">
            <router-link :to="{ name: 'class-detail', params: { id: item.article_id }}">
              <div class="design-ex">
                <div class="left">
                    <img :src="item.article_cover_thumb" alt="">
                </div>
                <div class="trait">
                  <div class="tra">
                    <div class="ename">
                      <span class="dname">{{item.article_title}}</span>
                      <div class="cover">
                        <p class="little">{{item.article_admin_nick}}</p><span class="line"></span><span class="time">{{item.article_udate}}</span>
                        <p class="readNum">阅读量：{{item.article_stat_view}}</p>
                      </div>
                      <p class="procedure" v-html="item.article_content"></p>
                    </div>
                  </div>
                </div>
              </div>
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <foot></foot>
  <sideBar></sideBar>
</div>
</template>

<script>
import Head from './head'
import Foot from './foot.vue'
import sideBar from './sidebar'
import fashion from '../assets/class/fashion.png'
// import fashion1 from '../assets/class/fashion1.png'
// import fashion2 from '../assets/class/fashion2.png'
// import fashion3 from '../assets/class/fashion3.png'
// import fashion4 from '../assets/class/fashion4.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'classroom',
  metaInfo () {
    const title = '智装课堂 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      banners: [
        {
          imgUrl: fashion,
          name: 'The untrue truth of intelligent black Technology',
          eN: '智能黑科技 不真实的真实',
          address: '2018年交房手续及流程大全',
          style: '交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。'
        },
        {
          imgUrl: fashion,
          name: 'The untrue truth of intelligent black Technology',
          eN: '智能黑科技 不真实的真实',
          address: '2018年交房手续及流程大全',
          style: '交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。'
        },
        {
          imgUrl: fashion,
          name: 'The untrue truth of intelligent black Technology',
          eN: '智能黑科技 不真实的真实',
          address: '2018年交房手续及流程大全',
          style: '交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。'
        }
      ],
      detail: [
        // {
        //   url: fashion1,
        //   name: 'class-detail',
        //   dname: '智能黑科技 不真实的真实',
        //   time: '2018-04-02 09:26 ',
        //   num: '36万',
        //   procedure: '交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。'
        // },
        // {
        //   url: fashion2,
        //   name: 'class-detail',
        //   dname: '碳歌发泡陶瓷保温墙板',
        //   time: '2018-04-02 09:26 ',
        //   num: '36万',
        //   procedure: '交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。'
        // },
        // {
        //   url: fashion3,
        //   name: 'class-detail',
        //   dname: '智能黑科技 不真实的真实',
        //   time: '2018-04-02 09:26 ',
        //   num: '36万',
        //   procedure: '交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。'
        // },
        // {
        //   url: fashion4,
        //   name: 'class-detail',
        //   dname: '智能黑科技 不真实的真实',
        //   time: '2018-04-02 09:26 ',
        //   num: '36万',
        //   procedure: '交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。'
        // }
      ],
      swiperOption: {
        loop: false,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        }
      }
    }
  },
  created () {
    this.getImg()
  },
  methods: {
    date (time) {
      let date = new Date(time)
      let str = date.getFullYear() + '-' +
        (date.getMonth() + 1) + '-' +
        date.getDate() + ' ' +
        date.getHours() + ':' +
        date.getMinutes() + ':' +
        date.getSeconds()
      return str
    },
    getImg: function () {
      this.$http.post('public/article/index', {}).then(d => {
        // console.log('ddd=========', d)
        if (d.code === 0) {
          for (let i = 0; i < d.data.list.length; i++) {
            let time = new Date(Number(d.data.list[i].article_udate))
            let a = this.date(time)
            this.detail.push(d.data.list[i])
            this.detail[i].article_udate = a
          }
        } else {
        }
      })
    }
  },
  components: {
    Head, swiper, swiperSlide, Foot, sideBar
  }
}
</script>

<style scoped>
.classBanner {
  height: 420px;
  background: url("../assets/class/banner.png")  no-repeat center 0;
  margin-top: 71px;
}
.conten {
  width: 1130px;
  height: 450px;
  position: relative;
  background-color: rgba(0, 0, 0, 0.3);
  left: 0;
  right: 0;
  margin: 105px auto 0;
  background-color: #fcfcfc;
  box-shadow: 0 15px 30px 0
  rgba(0, 0, 0, 0.1);
}
.swiper-slide {
  width: 1130px!important;
}
.list {
  width: 1130px;
  height: 100%;
}
.list li {
  width: 30%;
  display: inline-block;
  margin-left: 2.5%;
  margin-top: 43px;
}
.new {
  font-size: 30px;
  color: #5b5b5b;
  position: absolute;
  /*top: -14px;*/
  top: 0;
  left: 50px;
}
.fashion {
  font-size: 16px;
  color: #5b5b5b;
  position: absolute;
  /*top: 23px;*/
  top: 37px;
  left: 101px;
}
.introduce {
  width: 379px;
  position: absolute;
  left: 57px;
  color: #fff;
  top: 50%;
  transform: translateY(-50%);
}
.study {
  width: 483px;
  /*height: 374px;*/
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(255, 255, 255, 0.2);
  box-shadow: 0 7px 22px 1px rgba(48, 48, 48, 0.15);
}
.address {
  font-family: MicrosoftYaHei Bold;
  font-size: 20px;
  color: #5b5b5b;
  text-align: left;
}
.introduce h1 {
  font-size: 10px;
  color: #5b5b5b;
  text-align: left;
  margin-bottom: 8px;
}
.introduce .eN {
  font-family: MicrosoftYaHei Bold;
  font-size: 24px;
  color: #5b5b5b;
  text-align: left;
  margin-bottom: 36px;
}
.addr {
  font-size: 14px;
  line-height: 21px;
  text-align: left;
  margin-top: 22px;
  color: rgba(91, 91, 91, 0.7);
}
.classroom .pre {
  top: 52%;
  right: -8px;
  width: 52px;
  height: 52px;
  background-size: 15px 25px;
  border: solid 1px #a0a0a0;
  border-radius: 50%;
}
.classroom .swiper-button-prev {
  background: url("../assets/class/left.png") no-repeat center!important;
  left: -27px;
}
.classroom .swiper-button-next {
  background: url("../assets/class/right.png") no-repeat center!important;
  right: -27px;
}
  .allInformation h1 {
    font-family: MicrosoftYaHei Bold;
    font-size: 30px;
    color: #5b5b5b;
  }
  .allInformation {
    position: relative;
    margin-top: 70px;
  }
.allInformation h1:after {
  content: '';
  display: inline-block;
  width: 180px;
  height: 27px;
  margin-left: 8px;
  background: url("../assets/class/new.png") no-repeat center;
  vertical-align: middle;
}

.middle {
  width: 1157px;
  height: 100%;
  display: flex;
  margin: 63px auto 0;
}
.con {
  width: 1157px;
  margin: 0 auto;
}
.experience {
  display: flex;
  flex-direction: column;
}
.experience .ex {
  height: 310px;
  margin-bottom: 9px;
}
.design-ex {
  display: flex;
  justify-content: flex-start;
  padding: 20px 0 19px;
  transition: .5s;
}
.ex .left {
  height: 246px;
  margin-left: 22px;
  display: flex;
}
.experience .design-ex:hover {
  transition: .5s;
  box-shadow: 0 10px 30px 0 rgba(0, 0, 0, 0.2);
}
.trait {
  width: 100%;
  height: 246px;
  margin: 0 47px 0 55px;
}
.tra {
  position: relative;
  top: 50%;
  transform: translateY(-50%);
}
.ename {
  text-align: left;
  overflow: hidden;
}
.trait .dname {
  font-size: 36px;
  color: #333333;
}
.cover {
  height: 32px;
  line-height: 32px;
  margin-top: 9px;
  overflow: hidden;
}
  .little {
    float: left;
    font-size: 12px;
    color: #595757;
  }
  .little:before {
    width: 32px;
    height: 32px;
    content: '';
    display: inline-block;
    background: url("../assets/class/little2.png") no-repeat;
    background-size: 32px;
    margin-right: 8px;
    vertical-align: middle;
  }
  .line {
    width: 1px;
    height: 8px;
    background-color: #716f6e;
    margin: 11px 6px 0;
    float: left;
  }
  .time {
    font-size: 12px;
    color: #595757;
    float: left;
  }
  .readNum {
    font-size: 12px;
    color: #595757;
    float: right;
  }
  .procedure {
    font-size: 14px;
    float: left;
    line-height: 21px;
    margin-top: 12px;
    color: rgba(91, 91, 91, 0.7);
  }
</style>
<style>
  .procedure p {
    display: none;
  }
  .procedure p:first-child {
    display: block;
    overflow:hidden;
    text-overflow:ellipsis;
    display:-webkit-box;
    -webkit-box-orient:vertical;
    -webkit-line-clamp:3;
  }
</style>
