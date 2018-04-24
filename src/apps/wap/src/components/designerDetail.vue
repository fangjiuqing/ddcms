<template>
  <div>
    <Head></Head>
    <div class="cont">
      <div v-for="(item, index) in head" :key="index">
        <div class="banner">
          <div class="left">
            <h2>{{item.name}}</h2>
            <p class="en">{{item.en}}</p>
            <p class="intr">{{item.intr}}</p>
            <div class="line"></div>
          </div>
          <div class="right">
            <img :src="item.img" alt="">
          </div>
        </div>
      </div>
    </div>
    <ul class="list">
      <li>
        <div class="con">
          <p class="title">{{row.des_title}}</p>
          <p class="subtitle">职位</p>
        </div>
      </li>
      <li>
        <div class="con">
          <p class="title">{{row.province}}</p>
          <p class="subtitle">所在地</p>
        </div>
      </li>
      <li>
        <div class="con">
          <p class="title">{{len}}</p>
          <p class="subtitle">奖项</p>
        </div>
      </li>
      <li>
        <div class="con">
          <p class="title">{{row.des_workyears}}</p>
          <p class="subtitle">工作年限</p>
        </div>
      </li>
    </ul>
    <div class="detail">
      <h1 class="represent">代表作品</h1>
      <span class="work">REPRESENTATIVE WORK</span>
      <div class="cutLine"></div>
      <p v-html="row.case_content" class="ccontent"></p>
      <!-- <div class="performance">
          <p>项目名称：</p>
          <p>项目性质：{{item.des_slogan}}</p>
          <p>项目地点：</p>
          <p>设计面积：</p>
          <p>创意总监：</p>
          <p></p>
          <img :src="item.img1" alt="">
          <img :src="item.img2" alt="">
      </div> -->
      <ul class="img-list">
        <li v-for="(item, index) in imgs" :key="index">
          <img :src="item.lg" alt="">
        </li>
      </ul>
    </div>
    <Foot></Foot>
  </div>
</template>
<script>
import Head from './head-nav'
import Foot from './footNav'
import head from '../assets/designer/head.png'
// import img1 from '../assets/designer/img1.png'
// import img2 from '../assets/designer/img2.png'
export default {
  name: 'designer-detail',
  data () {
    return {
      row: {},
      stages: '',
      awards: [],
      len: '',
      id: this.$route.query.designerId || 0,
      imgs: [],
      head: [
        {
          img: head,
          name: '韩松言',
          en: 'Han Songyan',
          intr: '全国杰出设计师，注重人与自然的亲合，协调意境之美,以及情景交融的“象外之像”。'
        }
      ]
      // list: [
      //   {
      //     title: '创意总监',
      //     subtitle: '职位'
      //   },
      //   {
      //     title: '上海',
      //     subtitle: '所在地'
      //   },
      //   {
      //     title: '10',
      //     subtitle: '奖项'
      //   },
      //   {
      //     title: '13',
      //     subtitle: '工作年限'
      //   }
      // ],
      // project: [
      //   {
      //     name: 'W•House',
      //     nature: '别墅',
      //     address: '扬州',
      //     area: '420㎡',
      //     director: '韩松言',
      //     style: '空间设计要有气场、要有气势、并且要有温度！这样的情怀才能有内在魅力！ ----韩松言在这套作品中可以感受到时尚与艺术的交相呼应！韩松言对色彩和材料有着天生的敏感，其设计哲学亦强调用特殊的质感表现永恒的空间价值，并将其称之为‘惊喜’客厅使用定制的天蓝色织物沙发与皮纹高背椅以及皮毛懒人沙发相围合，餐厅铸铝餐椅、和蜂窝状吊灯相搭配，成功演绎出时尚华丽的空间氛围。地面树脂艺术漆与缤纷多彩的地毯与墙面的蜂窝状瓷砖相辅相成，表现了独有的‘奢华心绪’',
      //     img1: img1,
      //     img2: img2
      //   },
      //   {
      //     name: 'W•House',
      //     nature: '别墅',
      //     address: '扬州',
      //     area: '420㎡',
      //     director: '韩松言',
      //     style: '空间设计要有气场、要有气势、并且要有温度！这样的情怀才能有内在魅力！ ----韩松言在这套作品中可以感受到时尚与艺术的交相呼应！韩松言对色彩和材料有着天生的敏感，其设计哲学亦强调用特殊的质感表现永恒的空间价值，并将其称之为‘惊喜’客厅使用定制的天蓝色织物沙发与皮纹高背椅以及皮毛懒人沙发相围合，餐厅铸铝餐椅、和蜂窝状吊灯相搭配，成功演绎出时尚华丽的空间氛围。地面树脂艺术漆与缤纷多彩的地毯与墙面的蜂窝状瓷砖相辅相成，表现了独有的‘奢华心绪’',
      //     img1: img1,
      //     img2: img2
      //   }
      // ]
    }
  },
  components: {
    Head, Foot
  },
  methods: {
    getImg () {
      this.$http.post('public/designer/get', {
        id: this.id
      }).then(d => {
        // console.log(d.data)
        if (d.code === 0) {
          this.row = d.data.row
          // console.log(this.row)
          this.stages = d.data.stags.join('、')
          this.awards = this.awards.concat(d.data.awards)
          if (d.data.case_images) {
            this.imgs = this.imgs.concat(d.data.case_images)
          }
          if (d.data.awards) {
            this.len = d.data.awards.length
          }
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
.cont {
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
.list {
    width: 100%;
    height: 100px;
    background-color: #fafafa;
    padding-top: 16px;
    box-sizing: border-box;
}
.list li {
    width: 24%;
    display: inline-block;
    text-align: center;
    position: relative;
}
.con {
    display: inline-block;
}
.cut {
    display: inline-block;
    width: 1px;
    height: 30px;
    background-color: rgba(142, 140, 140, 0.5);
    opacity: 0.5;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
}
.list li:nth-child(4) .cut {
    width: 0;
    height: 0;
}
.title {
    font-size: 29px;
    letter-spacing: 1px;
    color: #000000;
}
.subtitle {
    font-size: 20px;
    color: #727171;
    margin-top: 14px;
}
.detail {
    width: 93.6%;
    margin: 29px auto 0;
}
.represent {
    font-size: 30px;
    line-height: 24px;
    letter-spacing: 1px;
    color: #000000;
    display: inline-block;
}
.work {
    font-size: 18px;
    font-weight: normal;
    font-stretch: normal;
    line-height: 0px;
    letter-spacing: 0px;
    color: #000000;
}
.cutLine {
    height: 1px;
    background-color: #cdcdcd;
    margin: 22px 0 0;
}
.performance {
    border-bottom: 1px solid #cdcdcd;
    margin-top: 22px;
}
.performance:last-child {
    border-bottom: 0;
}
.performance p {
    font-size: 24px;
    line-height: 40px;
    letter-spacing: 1px;
    color: #000000;
    margin-bottom: 16px;
}
.performance p:nth-child(5) {
    margin-bottom: 22px;
}
.performance p:nth-child(6) {
    font-size: 24px;
    line-height: 36px;
    letter-spacing: 1px;
    color: #727171;
}
.performance img {
    width: 100%;
    margin: 32px 0 20px;
}
.ccontent {
  max-height: 100%;
}
</style>
<style>
.detail p p {
  line-height: 40px;
}
.detail p p:last-child {
  margin-bottom: 16px;
}
.detail p p:nth-child(9),
.detail p p:nth-child(10),
.detail p p:nth-child(11) {
  font-size: 24px;
  color: #727171;
}
.detail p p:nth-child(1),
.detail p p:nth-child(2),
.detail p p:nth-child(3),
.detail p p:nth-child(4),
.detail p p:nth-child(5),
.detail p p:nth-child(6) {
  font-size: 24px;
  color: #000000;
}
</style>
