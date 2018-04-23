<template>
  <div class="designlist">
    <swiper :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="(item, index) in banners" :key="index">
        <div class="banner">
          <div class="tasking">
            <div class="middle">
              <div class="word">
                <div class="left">
                  <h2>{{item.dname}}</h2>
                  <img :src="item.img" alt="" class="ename">
                  <p>{{item.synopsisa}}</p>
                  <p class="synopsisa">{{item.synopsis}}</p>
                  <ul class="work-img">
                    <li>
                      <router-link v-for="(item, index) in imgs" :key="index" :to="{name:item.name}">
                        <img :src="item.imga" alt="">
                      </router-link>
                    </li>
                  </ul>
                </div>
                <div class="right">
                  <router-link :to="{name:item.name}">
                    <img :src="item.imgUrl" alt="">
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </swiper-slide>
    </swiper>
    <div class="filter">
      <!--<ul class="dsort bsort">-->
        <!--<li class="title">设计分类</li>-->
        <!--<li v-for="(item, index) in sort" :key="index" class="design-sort">{{item.dsort}}</li>-->
      <!--</ul>-->
      <!--<ul class="dsort ssort">-->
        <!--<li class="title">擅长风格</li>-->
        <!--<li v-for="(item, index) in manner" :key="index" class="sort-design">{{item.manner}}</li>-->
      <!--</ul>-->
      <div class="find">
        <div class="f-d">
          <span class="f-design"></span>
          <div class="error">x</div>
        </div>
        <div class="f-s">
          <span class="f-style"></span>
          <div class="error-s">x</div>
        </div>
      </div>
    </div>
    <div class="middle">
      <div class="content">
        <ul class="experience">
          <li v-for="(item, index) in detail" :key="index" class="ex">
            <router-link :to="{ name: 'designerDetail', query: { designerId: item.des_id}}">
              <div class="design-ex">
                <div class="left">
                  <img :src="item.des_cover" alt="">
                </div>
                <div class="trait">
                  <div class="tra">
                    <div class="ename">
                      <span class="dname">{{item.des_name}}</span>
                      <span class="slant">/ </span>
                      <i>{{item.des_concept_tags}}</i>
                    </div>
                    <ul class="list">
                      <li>
                        <span class="traitlist">{{item.province}} </span><span>{{item.city}}</span>
                      </li>
                      <li>
                        <span class="money">{{item.des_price}}元/平方米</span>
                      </li>
                      <li>
                        <span class="handson">{{item.des_workyears}}年设计经验</span>
                      </li>
                      <li>
                        <span class="job">{{item.des_title}}</span>
                      </li>
                    </ul>
                    <div class="rang">
                      <span>服务范围：</span>
                      <p class="range">{{item.des_slogan}}</p>
                    </div>
                    <!--<ul class="work">-->
                      <!--<li v-for="(item, index) in images" :key="index">-->
                        <!--<img :src="item.img" alt="">-->
                      <!--</li>-->
                    <!--</ul>-->
                  </div>
                </div>
              </div>
              <div class="footline"></div>
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
import designer from '../assets/designList/photoa.png'
import eName from '../assets/designList/ename.png'
import worka from '../assets/designList/worka.png'
import workb from '../assets/designList/workb.png'
import workc from '../assets/designList/workc.png'
import workd from '../assets/designList/workd.png'
// import photob from '../assets/designList/photob.png'
// import photoc from '../assets/designList/photoc.png'
// import photod from '../assets/designList/photod.png'
// import photoe from '../assets/designList/photoe.png'
// import photof from '../assets/designList/photof.png'
import owna from '../assets/designList/ownworka.png'
import ownb from '../assets/designList/wonworkb.png'
import ownc from '../assets/designList/wonworkc.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'designList',
  data () {
    return {
      sort: [
        {dsort: '别墅/大宅设计师'},
        {dsort: '总监设计师'},
        {dsort: '首席设计师'},
        {dsort: '主案设计师'},
        {dsort: '专员设计师'}
      ],
      manner: [
        {manner: '欧式'},
        {manner: '法式'},
        {manner: '现代'},
        {manner: '新中式'},
        {manner: '海派'},
        {manner: '美式'},
        {manner: '新古典'},
        {manner: '东南亚'}
      ],
      banners: [
        {
          imgUrl: designer,
          img: eName,
          name: 'designerDetail',
          dname: '韩松言',
          ename: 'Han  Songyan',
          synopsisa: '全国杰出设计师，注重人与自然的亲合，协调意境之美，',
          synopsis:
            '以及情景交融的“象外之像”，化意入境，于镜中浸透着意建筑与室内环境的研究与设计。'
        },
        {
          imgUrl: designer,
          dname: '韩理想',
          img: eName,
          name: 'designerDetail',
          ename: 'Han  Songyan',
          synopsisa: '全国杰出设计师，注重人与自然的亲合，协调意境之美，',
          synopsis:
            '以及情景交融的“象外之像”，化意入境，于镜中浸透着意建筑与室内环境的研究与设计。'
        },
        {
          imgUrl: designer,
          dname: '于涛',
          img: eName,
          name: 'designerDetail',
          ename: 'Han  Songyan',
          synopsisa: '全国杰出设计师，注重人与自然的亲合，协调意境之美，',
          synopsis:
            '以及情景交融的“象外之像”，化意入境，于镜中浸透着意建筑与室内环境的研究与设计。'
        }
      ],
      imgs: [
        {
          imga: worka,
          name: 'designerDetail'
        },
        {
          imga: workb,
          name: 'designerDetail'
        },
        {
          imga: workc,
          name: 'designerDetail'
        },
        {
          imga: workd,
          name: 'designerDetail'
        }
      ],
      detail: [
        // {
        //   url: photob,
        //   name: 'designerDetail',
        //   asst: '四川 成都',
        //   money: '999',
        //   handson: '7',
        //   job: '首席设计师',
        //   dname: '王德渊',
        //   content: '建筑与室内环境的研究与设计，同时涉足工业设计、视觉传达及企业策划，在不同的艺术及设计范畴以及东西文化的交融中，感受和谐的魅力。',
        //   trait: '追求潮流化与生活化的最佳融合点'
        // },
        // {
        //   url: photoc,
        //   name: 'designerDetail',
        //   asst: '四川 成都',
        //   money: '999',
        //   handson: '7',
        //   job: '首席设计师',
        //   content: '建筑与室内环境的研究与设计，同时涉足工业设计、视觉传达及企业策划，在不同的艺术及设计范畴以及东西文化的交融中，感受和谐的魅力。',
        //   dname: '王德渊',
        //   trait: '追求潮流化与生活化的最佳融合点'
        // },
        // {
        //   url: photod,
        //   asst: '四川 成都',
        //   name: 'designerDetail',
        //   money: '999',
        //   handson: '7',
        //   job: '首席设计师',
        //   dname: '王德渊',
        //   content: '建筑与室内环境的研究与设计，同时涉足工业设计、视觉传达及企业策划，在不同的艺术及设计范畴以及东西文化的交融中，感受和谐的魅力。',
        //   trait: '追求潮流化与生活化的最佳融合点'
        // },
        // {
        //   url: photoe,
        //   asst: '四川 成都',
        //   name: 'designerDetail',
        //   money: '999',
        //   handson: '7',
        //   job: '首席设计师',
        //   dname: '王德渊',
        //   content: '建筑与室内环境的研究与设计，同时涉足工业设计、视觉传达及企业策划，在不同的艺术及设计范畴以及东西文化的交融中，感受和谐的魅力。',
        //   trait: '追求潮流化与生活化的最佳融合点'
        // },
        // {
        //   url: photof,
        //   name: 'designerDetail',
        //   asst: '四川 成都',
        //   money: '999',
        //   handson: '7',
        //   job: '首席设计师',
        //   dname: '王德渊',
        //   content: '建筑与室内环境的研究与设计，同时涉足工业设计、视觉传达及企业策划，在不同的艺术及设计范畴以及东西文化的交融中，感受和谐的魅力。',
        //   trait: '追求潮流化与生活化的最佳融合点'
        // }
      ],
      swiperOption: {
        autoplay: true,
        speed: 600,
        loop: true,
        pagination: {
          el: '.swiper-pagination',
          clickable: true
        }
      },
      images: [
        {
          img: owna
        },
        {
          img: ownb
        },
        {
          img: ownc
        },
        {
          img: ownc
        }
      ]
    }
  },
  components: {
    swiper, swiperSlide
  },
  mounted () {
    (function () {
      $('.design-sort').click(function () {
        $(this).addClass('active').siblings().removeClass('active')
        const word = $(this).text()
        $('.f-design').empty().append(word).show()
        $('.find').find('.error').show()
      })
      $('.sort-design').click(function () {
        $(this).addClass('current').siblings().removeClass('current')
        const style = $(this).text()
        $('.f-style').empty().append(style)
        $('.find').find('.error-s').show()
      })
      $('.error').click(function () {
        $(this).siblings().text('')
        $('.design-sort').removeClass('active')
        $(this).hide()
      })
      $('.error-s').click(function () {
        $(this).siblings().text('')
        $('.sort-design').removeClass('current')
        $(this).hide()
      })
    }())
    this.getImg()
  },
  methods: {
    getImg: function () {
      this.$http.post('public/designer/index', {}).then(d => {
        // console.log('dddsss=========', d.msg.list)
        if (d.code === 0) {
          this.detail = this.detail.concat(d.msg.list)
        } else {
        }
      })
    }
  }
}
</script>
<style scoped>
.swiper-container {
  margin: 71px auto 0;
}
.banner {
  height: 520px;
  background: url(../assets/designer/whiteb.png) center/cover no-repeat;
}
.filter {
  width: 1000px;
  margin: 0 auto;
  padding-top: 40px;
}
.dsort {
  display: flex;
	border: solid 1px #e5e5e5;
}
.bsort {
  border-bottom: 0;
}
.ssort {
  margin-bottom: 30px;
}
.design-sort, .sort-design {
  margin-left: 19px;
  line-height: 60px;
  color: #595757;
  cursor: pointer;
}
.dsort li:nth-child(2) {
  margin-left: 29px;
}
.title {
  width: 132px;
	height: 60px;
  line-height: 60px;
  border-right: solid 1px #e5e5e5;
	background-color: #fafafa;
}
.active, .current {
  color: #d42f31;
}
.tasking {
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
}
.middle {
  width: 1200px;
  height: 100%;
  display: flex;
  margin: 0 auto;
}
.word {
  display: flex;
  width: 1000px;
  padding: 18px 100px 0 100px;
  text-align: left;
  justify-content: space-between;
  align-items: flex-start;
}
.left {
  height: 454px;
}
.design-ex .left img {
  width: 226px;
  height: 301px;
}
.left h2 {
  font-size: 36px;
  letter-spacing: 1px;
  color: #ffffff;
  margin-bottom: 19px;
  padding-top: 92px;
}
.left p {
  line-height: 21px;
  font-size: 14px;
  color: #ffffff;
}
.synopsisa {
  margin-bottom: 40px;
}
.work-img {
  display: flex;
}
.work-img li img {
  margin-right: 30px;
  border-top: 1px solid #fafafa;
  border-bottom: 1px solid #fafafa;
}
.work-img li a:nth-child(4) {
  margin: 0;
}
.right {
  display: flex;
}
.right img {
  vertical-align: bottom;
}
.content {
  width: 1000px;
  margin: 0 auto;
}
.experience {
  display: flex;
  flex-direction: column;
}
.experience .ex {
  display: flex;
  height: 100%;
  flex-direction: column;
  justify-content: space-between;
  width: 1000px;
  margin-bottom: 50px;
}
.design-ex {
  display: flex;
  height: 301px;
  justify-content: flex-start;
  padding: 20px 0 19px;
}
.footline {
  width: 1000px;
  border-bottom: dashed 1px #bfbfbf;
  margin-top: 30px;
}
.ex .left {
  height: 340px;
  margin-left: 22px;
  display: flex;
}
.experience .design-ex:hover {
  transition: .5s;
	box-shadow: 0px 10px 30px 0px rgba(0, 0, 0, 0.2);
}
.trait {
  width: 100%;
  height: 340px;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  margin: 0 47px 0 55px;
}
.tra {
  height: 301px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.ename {
  text-align: left;
  margin-top: 7px;
}
.slant {
  font-size: 24px;
	line-height: 16px;
	color: #999999;
}
.trait .dname {
	font-size: 36px;
	color: #333333;
}
.trait i {
  font-size: 14px;
  color: #3e3a39;
}
.list {
  display: flex;
  justify-content: space-between;
}
.list li {
  display: flex;
  justify-content: space-between;
}
.list li span {
  line-height: 30px;
  font-size: 16px;
  color: #767676;
}
.traitlist:before {
  content: " ";
  display: inline-block;
  width: 25px;
  height: 25px;
  vertical-align: middle;
  background-size: 25px 25px;
  background: url('../assets/designList/house.png');
}
.money:before {
  content: " ";
  display: inline-block;
  width: 25px;
  height: 25px;
  vertical-align: middle;
  background-size: 25px 25px;
  background: url('../assets/designList/price.png');
}
.handson:before {
  content: " ";
  display: inline-block;
  width: 25px;
  height: 25px;
  vertical-align: middle;
  background-size: 25px 25px;
  background: url('../assets/designList/handson.png');
}
.job:before {
  content: " ";
  display: inline-block;
  width: 25px;
  height: 25px;
  vertical-align: middle;
  background-size: 25px 25px;
  background: url('../assets/designList/job.png');
}
.rang {
  display: flex;
}
.range {
  width: 576px;
  font-size: 14px;
  text-align: left;
	line-height: 30px;
  text-align: justify;
  letter-spacing: 0.6px;
	color: #727171;
}
.rang span {
  color: #3e3a39;
	font-size: 14px;
  line-height: 30px;
}
.work {
  display: flex;
  justify-content: space-between;
}
.find {
  display: flex;
  text-align: left;
  margin-bottom: 33px;
}
.f-d, .f-s {
  display: flex;
}
.f-design, .f-style {
  margin-right: 5px;
	font-size: 14px;
	color: #595757;
}
.error,.error-s {
  width: 15px;
  height: 15px;
  line-height: 12px;
  box-sizing: border-box;
  display: none;
  text-align: center;
  font-size: 12px;
  border-radius: 3px;
	border: solid 1px #8e8c8c;
}
.error {
  margin-right: 15px;
}
</style>
