<template>
  <div class="personalTailor">
    <Head/>
    <img src="../assets/personalTailor/banner.png" alt="" class="banner">
    <div class="exclusive">
        <div class="exclusiveContent">
            <h1>专属定制 让家更懂你</h1>
            <p class="title">1V1 私享方案  彰显品味人生</p>
            <p>一个家庭 一种个性 设计家亦是设计生活</p>
            <ul>
                <li v-for='(item, index) in back' :key="index">
                    <img :src="item.imgBack" alt="">
                </li>
            </ul>
        </div>
    </div>
    <future-home/>
    <div class="designer">
        <h1>配备完整设计团队 - 360度为你服务</h1>
        <p>设计团队科学匹配 适合你的才是最好的</p>
        <div class="creator">
            <img src="../assets/personalTailor/creator.png" alt="">
            <p>主创设计师</p>
        </div>
        <ul>
            <li v-for='(item, index) in designer' :key="index">
                <img :src="item.img" alt="">
                <p class="tit">{{item.title}}</p>
                <p class="intr">{{item.intr}}</p>
            </li>
        </ul>
    </div>
    <div class="live">
        <h1>现场施工直播</h1>
        <swiper :options="swiperOption" class="list">
            <swiper-slide v-for="(item, index) in live" :key="index">
                <img :src="item">
            </swiper-slide>
            <div class="swiper-button-prev swiper-button-white" slot="button-prev"></div>
            <div class="swiper-button-next swiper-button-white" slot="button-next"></div>
        </swiper>
    </div>
    <div class="supervise">
        <h1>客户APP 监察</h1>
        <p>客户签约后即可安装客户端APP，与工程EPR联通实时查看施工进度，现场监控随时看</p>
        <div class="superviseCont">
            <div class="left">
                <p class="superT">现场监控</p>
                <p class="superIn">利用可移动摄像装置，进行实时监管。客户即使在家
                    ，甚至在国外，都能通过手机实时监看家中的施工情况，检查施工质量。
                </p>
                <img src="../assets/personalTailor/left.png" alt="">
            </div>
            <img src="../assets/personalTailor/supervise.png" alt="">
            <div class="right">
                <p class="superT">进度查看</p>
                <p class="superIn">通过手机端APP，实时查看施工进度，如果发现问题需要
                    沟通时，直接联系项目经理，项目监理，大大解决了时间和交通成本
                </p>
                <img src="../assets/personalTailor/right.png" alt="">
            </div>
        </div>
    </div>
    <div class="ready"></div>
    <div class="fiveStar">
        <h1>“五心级”尊享服务</h1>
        <p class="fiveTit">承诺最高标准 畅想极致体验</p>
        <ul class="starList">
            <li v-for='(item, index) in star' :key="index">
                <img :src="item.img" alt="">
                <p>{{item.intr}}</p>
            </li>
        </ul>
        <p class="team" @click='typeShow'>智能匹配设计团队</p>
    </div>
    <div class="content" v-show="type">
        <div class="tasking" @click="typeHide"></div>
        <div class="confirm">
            <h3>01 请选择您的户型</h3>
            <ul class="typeList">
                <li v-for='(item, index) in houseType' :key="index">
                    <img :src="item.img" alt="">
                    <div class="choose">
                        <input type="radio" name='houseType'>
                        <span>{{item.type}}</span>
                    </div>
                </li>
            </ul>
            <p class="next" @click='sexShow'>下一步</p>
        </div>
    </div>
    <div class="content" v-show="sex">
        <div class="tasking" @click="sexHide"></div>
        <div class="confirm">
            <h3>02 您的年龄与性别</h3>
            <div class="sexCon">
                <div class="sex">
                    <img src="../assets/personalTailor/man.png" alt="">
                    <input type="radio" name='sex'>
                    <span>男</span>
                </div>
                <div class="sex">
                    <img src="../assets/personalTailor/woman.png" alt="">
                    <input type="radio" name='sex'>
                    <span>女</span>
                </div>
            </div>
            <ul class="age">
                <li v-for='(item, index) in age' :key="index">
                    <input type="radio" name='age'>
                    <span>{{item}}</span>
                </li>
            </ul>
            <p class="next" @click='animalShow'>下一步</p>
        </div>
    </div>
    <div class="content" v-show="animal">
        <div class="tasking" @click="animalHide"></div>
        <div class="confirm">
            <h3>03 如果可以变成一种动物，您希望是哪一种？</h3>
            <ul class="animal">
                <li v-for='(item, index) in animals' :key="index">
                    <img :src="item.img" alt="">
                    <div class="choose">
                        <input type="radio" name='animal'>
                        <span>{{item.name}}</span>
                    </div>
                </li>
            </ul>
            <p class="next" @click='sofaShow'>下一步</p>
        </div>
    </div>
    <div class="content" v-show="sofa">
        <div class="tasking" @click="sofaHide"></div>
        <div class="confirm">
            <h3>04 下面几组沙发，你更喜欢哪一组？</h3>
            <ul class="sofa">
                <li v-for='(item, index) in sofas' :key="index">
                    <img :src="item" alt="">
                    <input type="radio" name='sofa'>
                </li>
            </ul>
            <p class="next" @click='styleShow'>下一步</p>
        </div>
    </div>
    <div class="content" v-show="style">
        <div class="tasking" @click="styleHide"></div>
        <div class="confirm">
            <h3 class="inquire">05 风格测试结果查询</h3>
            <input class="impo im" type="text" placeholder="请输入您的姓名">
            <input class="impo" type="text" maxlength="11" placeholder="请输入您的手机号码">
            <p class="next" @click="styleHide">获取</p>
        </div>
    </div>
    <foot/>
  </div>
</template>
<script>
import Head from './head.vue'
import futureHome from './futureHome.vue'
import foot from './foot.vue'
import back1 from '../assets/personalTailor/back1.png'
import back2 from '../assets/personalTailor/back2.png'
import back3 from '../assets/personalTailor/back3.png'
import back4 from '../assets/personalTailor/back4.png'
import back5 from '../assets/personalTailor/back5.png'
import back6 from '../assets/personalTailor/back6.png'
import designer1 from '../assets/personalTailor/designer1.png'
import designer2 from '../assets/personalTailor/designer2.png'
import designer3 from '../assets/personalTailor/designer3.png'
import designer4 from '../assets/personalTailor/designer4.png'
import designer5 from '../assets/personalTailor/designer5.png'
import designer6 from '../assets/personalTailor/designer6.png'
import designer7 from '../assets/personalTailor/designer7.png'
import designer8 from '../assets/personalTailor/designer8.png'
import designer9 from '../assets/personalTailor/designer9.png'
import designer10 from '../assets/personalTailor/designer10.png'
// import live1 from '../assets/personalTailor/live1.png'
import live2 from '../assets/personalTailor/live2.png'
import live3 from '../assets/personalTailor/live3.png'
import star1 from '../assets/personalTailor/star1.png'
import star2 from '../assets/personalTailor/star2.png'
import star3 from '../assets/personalTailor/star3.png'
import star4 from '../assets/personalTailor/star4.png'
import star5 from '../assets/personalTailor/star5.png'
import houseType1 from '../assets/personalTailor/houseType1.png'
import houseType2 from '../assets/personalTailor/houseType2.png'
import houseType3 from '../assets/personalTailor/houseType3.png'
import houseType4 from '../assets/personalTailor/houseType4.png'
import houseType5 from '../assets/personalTailor/houseType5.png'
import animal1 from '../assets/personalTailor/animal1.png'
import animal2 from '../assets/personalTailor/animal2.png'
import animal3 from '../assets/personalTailor/animal3.png'
import animal4 from '../assets/personalTailor/animal4.png'
import sofa1 from '../assets/personalTailor/sofa1.png'
import sofa2 from '../assets/personalTailor/sofa2.png'
import sofa3 from '../assets/personalTailor/sofa3.png'
import sofa4 from '../assets/personalTailor/sofa4.png'
import sofa5 from '../assets/personalTailor/sofa5.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
export default {
  name: 'personal-tailor',
  metaInfo () {
    const title = '私人定制 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      type: false,
      sex: false,
      animal: false,
      sofa: false,
      style: false,
      back: [
        {
          imgBack: back1
        },
        {
          imgBack: back2
        },
        {
          imgBack: back3
        },
        {
          imgBack: back4
        },
        {
          imgBack: back5
        },
        {
          imgBack: back6
        }
      ],
      designer: [
        {
          img: designer1,
          title: '土建设计师',
          intr: '以人为本打造功能合理和谐统一风格独特的家居人文环境'
        },
        {
          img: designer2,
          title: '园林设计师',
          intr: '建筑、植物、美学相结合，对自然环境进行有意识的改造和思维筹划'
        },
        {
          img: designer3,
          title: '空间设计师',
          intr: '充分利用每寸空间增大储藏功能'
        },
        {
          img: designer4,
          title: '水电设计师',
          intr: '根据装修配置、家庭人口、生活习惯、审美观念对水电重新规划达到即安全又隐蔽'
        },
        {
          img: designer5,
          title: '设备工程师',
          intr: '设备管理，设备功能合理布局设备维护检修'
        },
        {
          img: designer6,
          title: '材料设计师',
          intr: '全程化的家装顾问保证效果图到实景的转化'
        },
        {
          img: designer7,
          title: '全屋定制设计师',
          intr: '合理利用空间将不规则的空间灵活运用'
        },
        {
          img: designer8,
          title: '家居配饰设计师',
          intr: '家具、软装、窗帘灯饰创意搭配，画龙点睛实现“拎包入住”'
        },
        {
          img: designer9,
          title: '灯光设计师',
          intr: '借助灯光来创造色彩与魅力生动世界的艺术家'
        },
        {
          img: designer10,
          title: '智能规划师',
          intr: '园林安防、智能家居一体化统筹布局'
        }
      ],
      live: [
        live3, live2, live3, live3, live2, live3
      ],
      star: [
        {
          img: star1,
          intr: '精心服务'
        },
        {
          img: star2,
          intr: '心于专研'
        },
        {
          img: star3,
          intr: '用心甄选'
        },
        {
          img: star4,
          intr: '匠心品质'
        },
        {
          img: star5,
          intr: '用心呵护'
        }
      ],
      houseType: [
        {
          img: houseType1,
          type: '三居室'
        },
        {
          img: houseType2,
          type: '四居室'
        },
        {
          img: houseType3,
          type: '五居室'
        },
        {
          img: houseType4,
          type: '复式'
        },
        {
          img: houseType5,
          type: '别墅'
        }
      ],
      age: [
        '24岁以下', '25～34岁', '35～45岁', '45岁以上'
      ],
      animals: [
        {
          img: animal1,
          name: '老虎'
        },
        {
          img: animal2,
          name: '熊'
        },
        {
          img: animal3,
          name: '牛'
        },
        {
          img: animal4,
          name: '兔子'
        }
      ],
      sofas: [
        sofa1, sofa2, sofa3, sofa4, sofa5
      ],
      swiperOption: {
        autoplay: true,
        speed: 1000,
        effect: 'coverflow',
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        },
        coverflowEffect: {
          rotate: 0,
          stretch: -30,
          depth: 100,
          modifier: 2,
          slideShadows: true
        },
        slidesPerView: 3,
        loop: true,
        centeredSlides: true
      }
    }
  },
  methods: {
    typeShow () {
      this.type = true
    },
    typeHide () {
      this.type = false
    },
    sexShow () {
      this.type = false
      this.sex = true
    },
    sexHide () {
      this.sex = false
    },
    animalShow () {
      this.sex = false
      this.animal = true
    },
    animalHide () {
      this.animal = false
    },
    sofaShow () {
      this.animal = false
      this.sofa = true
    },
    sofaHide () {
      this.sofa = false
    },
    styleShow () {
      this.style = true
      this.sofa = false
    },
    styleHide () {
      this.style = false
    }
  },
  components: {
    Head, foot, futureHome, swiper, swiperSlide
  }
}
</script>
<style scoped>
    .banner {
        width: 100%;
    }
    .exclusive {
        height: 900px;
        position: relative;
        margin-top: -3px;
        background: url('../assets/personalTailor/exclusiveBanner.png') no-repeat center 0;
    }
    .exclusiveContent {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        margin: auto;
    }
    h1 {
        font-size: 60px;
        color: #ffffff;
    }
    .exclusiveContent h1 {
        margin-top: 100px;
    }
    .exclusiveContent > p {
        font-size: 24px;
        color: #ffffff;
    }
    .title {
        margin: 22px 0 12px;
    }
    .exclusiveContent ul {
        width: 1110px;
        margin: 100px auto 0;
        overflow: hidden;
    }
    .exclusiveContent ul li {
        float: left;
        margin-right: 30px;
    }
    .exclusiveContent ul li:last-child {
        margin-right: 0;
    }
    .designer {
        height: 1268px;
        position: relative;
        background: url('../assets/personalTailor/designerBack.png') no-repeat center 0;
        padding-top: 100px;
        box-sizing: border-box;
    }
    .designer > p {
        font-size: 24px;
        color: #ffffff;
        margin: 26px 0 100px;
    }
    .creator {
        width: 140px;
        margin: 0 auto;
    }
    .creator p {
        font-size: 16px;
        color: #e6cc96;
        margin-top: 17px;
    }
    .designer ul {
        width: 1280px;
        margin: 78px auto 0;
    }
    .designer ul li {
        width: 210px;
        float: left;
    }
    .designer ul li:nth-child(1),
    .designer ul li:nth-child(2),
    .designer ul li:nth-child(3),
    .designer ul li:nth-child(4),
    .designer ul li:nth-child(6),
    .designer ul li:nth-child(7),
    .designer ul li:nth-child(8),
    .designer ul li:nth-child(9) {
        margin-right: 57px;
    }
    .designer ul li:nth-child(1),
    .designer ul li:nth-child(2),
    .designer ul li:nth-child(3),
    .designer ul li:nth-child(4),
    .designer ul li:nth-child(5) {
        margin-bottom: 63px;
    }
    .tit {
        font-size: 16px;
        color: #e6cc96;
        margin: 40px 0 20px;
    }
    .intr {
        font-size: 14px;
        line-height: 25px;
        color: #ffffff;
    }
    .live {
        height: 900px;
        position: relative;
        background: url('../assets/personalTailor/live.png') no-repeat center 0;
        padding-top: 100px;
        box-sizing: border-box;
    }
    .list {
        margin-top: 156px;
    }
    .supervise {
        height: 900px;
        position: relative;
        background: url('../assets/personalTailor/superviseBack.png') no-repeat center 0;
        padding-top: 60px;
        box-sizing: border-box;
    }
    .supervise h1 {
        font-size: 60px;
        color: #000000;
    }
    .supervise > p {
        width: 509px;
        font-size: 24px;
        line-height: 40px;
        color: #000000;
        margin: 27px auto 45px;
    }
    .superviseCont {
        width: 1276px;
        margin: 0 auto;
        overflow: hidden;
    }
    .left,
    .superviseCont > img,
    .right {
        float: left;
    }
    .superviseCont > img {
        width: 546px;
    }
    .right, .left {
        width: 332px;
    }
    .left {
        text-align: right;
        margin-top: 155px;
    }
    .right {
        text-align: left;
        margin-top: 62px;
    }
    .superT {
        font-size: 36px;
        color: #000000;
    }
    .superIn {
        font-size: 16px;
        line-height: 26px;
        color: #000000;
        margin: 23px 0;
    }
    .ready {
        height: 900px;
        position: relative;
        background: url('../assets/personalTailor/allReady.png') no-repeat center 0;
    }
    .fiveStar {
        width: 896px;
        height: 679px;
        margin: 0 auto;
        padding-top: 80px;
        box-sizing: border-box;
    }
    .fiveStar h1 {
        color: #000000;
    }
    .fiveTit {
        font-size: 24px;
        color: #000000;
        margin: 27px 0 77px;
    }
    .starList li {
        display: inline-block;
        margin-right: 74px;
    }
    .starList li:last-child {
        margin-right: 0;
    }
    .starList li p {
        font-size: 30px;
        color: #000000;
        margin-top: 53px;
    }
    .team {
        width: 437px;
        height: 56px;
        background-color: #b28850;
        margin: 93px auto 0;
        font-size: 32px;
        color: #ffffff;
        text-align: center;
        line-height: 56px;
        cursor: pointer;
    }
    /*户型浮层开始*/
    .confirm {
        width: 960px;
        height: 400px;
        background-color: #ffffff;
        box-shadow: 0 15px 90px 0 rgba(0, 0, 0, 0.1);
        position: fixed;
        left: 50%;
        top: 50%;
        margin: -200px 0 0 -480px;
        z-index: 9999;
        overflow: hidden;
        padding: 37px 68px;
        box-sizing: border-box;
    }
    .confirm h3 {
        font-size: 32px;
        color: #000000;
        text-align: left;
    }
    .typeList {
        width: 804px;
        margin: 45px auto 0;
    }
    .typeList li {
        margin-right: 43px;
        display: inline-block;
    }
    .typeList li:last-child {
        margin-right: 0;
    }
    .choose {
        margin-top: 12px;
    }
    .choose input {
        vertical-align: middle;
    }
    .choose span {
        font-size: 13px;
        color: #000000;
        vertical-align: middle;
    }
    .next {
        width: 198px;
        height: 36px;
        text-align: center;
        line-height: 36px;
        background-color: #b28850;
        font-size: 20px;
        color: #ffffff;
        margin: 50px auto 0;
        cursor: pointer;
    }
    /*户型浮层结束*/
    /*性别浮层开始*/
    .sexCon {
        overflow: hidden;
    }
    .sex {
        float: left;
        margin: 41px 133px 0 0;
    }
    .age {
        margin-top: 48px;
        overflow: hidden;
    }
    .age li {
        float: left;
        margin-right: 107px;
    }
    .age li:last-child {
        margin-right: 0;
    }
    .age li span {
        font-size: 13px;
        color: #000000;
    }
    /*性别浮层结束*/
    /*动物浮层开始*/
    .animal {
        margin-top: 65px;
    }
    .animal li {
        margin-right: 81px;
        display: inline-block;
    }
    .animal li:last-child {
        margin-right: 0;
    }
    /*动物浮层结束*/
    /*沙发浮层开始*/
    .sofa {
        margin-top: 68px;
    }
    .sofa li {
        margin-right: 33px;
        display: inline-block;
    }
    .sofa li:last-child {
        margin-right: 0;
    }
    .sofa li img {
        display: block;
    }
    /*沙发浮层结束*/
    /*查询浮层开始*/
    .inquire {
        text-align: center!important;
    }
    .impo {
        width: 370px;
        height: 40px;
        background-color: #ffffff;
        border: solid 1px #9fa0a0;
        outline: none;
        display: block;
        margin: 0 auto;
        text-align: center;
    }
    .im {
        margin: 72px auto 21px;
    }
    /*查询浮层结束*/
    .tasking {
        position: fixed;
        z-index: 9998;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.2);
    }
</style>
<style>
    .live .swiper-slide {
        margin-top: 50px!important;
    }
    .live .swiper-slide-active {
        width: 634px!important;
        height: 475px;
        margin-top: 0!important;
    }
    .live .swiper-slide-active img {
        width: 634px;
        height: 475px;
    }
</style>
