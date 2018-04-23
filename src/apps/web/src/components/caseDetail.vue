<template>
  <div class="cashDetail">
    <Head></Head>
    <div class="cover">
      <div class="cont">
        <p class="title"><span>{{row.case_title}} - </span><span>{{row.type}}</span></p>
        <div class="right ri">
          <div class="to">
            <img :src="designer.des_cover_sm" alt="" class="photo">
            <div class="into">
              <span class="name">{{designer.des_name}}</span>
              <span class="work">{{designer.des_title}}</span>
              <p>立即预约</p>
            </div>
          </div>
          <p class="feel">{{summary}}</p>
          <p class="brand">汤成一品</p>
          <ul class="show">
            <li><span>区域</span><span>{{row.city}}</span></li>
            <li><span>面积</span><span>{{row.case_area}}</span></li>
            <li><span>风格</span><span>{{row.style}}</span></li>
            <li><span>造价</span><span>{{row.case_price}}</span></li>
          </ul>
          <p class="offer" @click="showPanel">我要这样装&nbsp;立即获取报价</p>
          <span class="star">2445</span>
          <span class="transmit">1675</span>
        </div>
        <h1>设计背景</h1>
        <table border="1" cellspacing="0" cellpadding="0" v-for="(item,index) in attrs" :key="index">
          <!--<tr><th class="font">房主年龄<th class="color">35</th><th class="font">房主职位</th> <th class="color">销售</th> </tr>-->
          <tr><td class="font">{{item.key0.key}}</td> <td class="color">{{item.key0.val}}</td> <td class="font">{{item.key1.key}}</td> <td class="color">{{item.key1.val}}</td>  </tr>
          <tr> <td class="font">{{item.key2.key}}</td> <td class="color">{{item.key2.val}}</td><td class="font">{{item.key3.key}}</td> <td class="color">{{item.key3.val}}</td>  </tr>
        </table>
        <ul v-for="items in images" :key="items.index" class="list">
          <span class="location">{{items.name}}</span>
          <li v-for="item in items.images" :key="item.index">
            <img :src="item.image_lg" alt="">
            <p class="loca">
              <!--<span class="det">DETAILS SHOW</span>-->
            </p>
            <p class="intr">{{item.desc}}</p>
          </li>
        </ul>
        <!--<div class="case"></div>-->
        <div class="bt">
          <p class="last">上一篇：{{prev}}</p>
          <p class="next">下一篇：{{next}}</p>
        </div>
        <p class="similar">相似风格</p>
        <ul class="slist">
          <li v-for="(item,index) in more" :key="index" @mouseenter="show(item)" @mouseleave="show(item)">
            <img :src="item.case_cover" alt="">
            <transition name="fade">
              <div class="tasking" v-show="item.toggle">
                <div>
                  <p><span>{{item.case_title}}&nbsp;</span><span>{{item.type}}</span></p>
                </div>
              </div>
            </transition>
          </li>
        </ul>
      </div>
    </div>
    <foot></foot>
    <sideBar></sideBar>
    <Price :panelShow.sync="panelShow"></Price>
  </div>
</template>
<script>
import $ from 'jquery'
import Head from './head.vue'
import foot from './foot.vue'
import sideBar from './sidebar'
import Price from './price'
// import parlor from '../assets/caseDetail/parlor.png'
// import bedroom from '../assets/caseDetail/bedroom.png'
// import kitchen from '../assets/caseDetail/kitchen.png'
// import similar1 from '../assets/caseDetail/similar1.png'
// import similar2 from '../assets/caseDetail/similar2.png'
// import similar3 from '../assets/caseDetail/similar3.png'
export default {
  name: 'caseDetail',
  metaInfo () {
    const title = '案例详情 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      scroll: '',
      panelShow: false,
      id: this.$route.query.caseId || 0,
      attrs: [],
      row: {},
      designer: {},
      summary: '',
      prev: '',
      next: '',
      more: [],
      images: [
        // {
        //   img: parlor,
        //   location: '客厅',
        //   intr: '摒弃一切的复杂，回归到一片简介之中设计实景白色作为整个空间的主色'
        // },
        // {
        //   img: bedroom,
        //   location: '卧室',
        //   intr: '摒弃一切的复杂，回归到一片简介之中设计实景白色作为整个空间的主色'
        // },
        // {
        //   img: kitchen,
        //   location: '厨房',
        //   intr: '摒弃一切的复杂，回归到一片简介之中设计实景白色作为整个空间的主色'
        // }
      ],
      style: [
        // {
        //   img: similar1,
        //   isShow: false,
        //   intr: '盛世滨江 三居室'
        // },
        // {
        //   img: similar2,
        //   isShow: false,
        //   intr: '盛世滨江 三居室'
        // },
        // {
        //   img: similar3,
        //   isShow: false,
        //   intr: '盛世滨江 三居室'
        // }
      ]
    }
  },
  methods: {
    show (item) {
      item.toggle = !item.toggle
    },
    menu () {
      this.scroll = document.documentElement.scrollTop || document.body.scrollTop
      if (this.scroll < 180) {
        $('.cont .right').removeClass('fixed').addClass('ri')
      } else if (this.scroll > 180 && this.scroll <= 1865) {
        $('.cont .right').removeClass('ri bottom').addClass('fixed')
      } else if (this.scroll > 1665) {
        $('.cont .right').removeClass('fixed').addClass('bottom')
      }
    },
    showPanel () {
      this.panelShow = true
    },
    getImg: function () {
      this.$http.post('public/case/get', {
        id: this.id
      }).then(d => {
        console.log('caseDetail=========', d.data)
        if (d.code === 0) {
          this.attrs.push(d.data.attrs)
          $.extend(this.designer, d.data.designer)
          $.extend(this.row, d.data.row)
          this.summary = d.data.summary
          this.prev = d.data.prev.case_title
          this.next = d.data.next.case_title
          for (let i = 0; i < d.data.more.length; i++) {
            this.more.push(d.data.more[i])
          }
          for (let i = 0; i < d.data.images.length; i++) {
            this.images.push(d.data.images[i])
          }
        } else {
        }
      })
    }
  },
  created () {
    this.getImg()
  },
  mounted () {
    document.addEventListener('scroll', this.menu)
    // console.log('this.$route.query.caseId=====', this.$route.query.caseId)
  },
  components: {
    Head, foot, sideBar, Price
  }
}
</script>
<style scoped>
  .cover {
    width: 100%;
    border-top: 1px solid lightgray;
    padding-top: 50px;
    position: relative;
    margin-top: 71px;
  }
  .cont {
    width: 1160px;
    margin: 0 auto;
  }
  .title {
    font-family: PingFangSC-Regular;
    font-size: 16px;
    color: #000000;
    text-align: left;
  }
  .right {
    width: 240px;
    /*height: 600px;*/
    background-color: #fafafa;
    /*position: fixed;*/
    margin-left: 850px;
    padding: 20px;
    text-align: left;
  }
  .ri {
    position: absolute;
    top: 161px;
  }
  .fixed {
    position: fixed;
    top: 101px;
  }
  .bottom {
    position: absolute;
    bottom: 475px;
  }
  .to {
    width: 240px;
    height: 130px;
    position: relative;
  }
  .photo {
    width: 97px;
  }
  .into {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
  }
  .name {
    font-size: 20px;
    line-height: 24px;
    color: #3e3a39;
  }
  .work {
    font-size: 14px;
    line-height: 24px;
    color: #3e3a39;
    display: block;
  }
  .into p {
    width: 64px;
    height: 13px;
    font-size: 14px;
    color: #d42f31;
    border-radius: 15px;
    border: solid 1px #d42f31;
    padding: 7px 9px;
    text-align: center;
    margin-top: 40px;
    cursor: pointer;
  }
  .feel {
    font-size: 14px;
    line-height: 21px;
    color: rgba(62, 58, 57, 0.8);
    margin: 19px 0 21px 0;
  }
  .brand {
    font-size: 20px;
    line-height: 24px;
    color: #595757;
    font-weight: bold;
  }
  .show {
    border-top: 1px solid #583830;
    margin-top: 12px;
  }
  .show li {
    padding: 16px 0;
    border-bottom: 1px solid #d4d4d4;
    overflow: hidden;
  }
  .show li span:nth-child(1) {
    float: left;
    font-size: 16px;
    line-height: 24px;
    color: #595757;
  }
  .show li span:nth-child(2) {
    float: right;
    font-size: 14px;
    line-height: 24px;
    color: #595757;
    font-weight: bold;
  }
  .offer {
    width: 242px;
    height: 40px;
    background-color: #d42f31;
    font-size: 16px;
    color: #ffffff;
    margin-top: 22px;
    text-align: center;
    line-height: 40px;
    cursor: pointer;
  }
  .right > span {
    font-size: 18px;
    color: #989898;
    display: inline-block;
    margin-top: 23px;
  }
  .right > span:before {
    content: '';
    display: inline-block;
    width: 22px;
    height: 22px;
    background-size: 22px;
    vertical-align:middle;
    margin-right: 10px;
  }
  .star:before {
    background: url("../assets/caseDetail/star.png") no-repeat;
  }
  .transmit:before {
    background: url("../assets/caseDetail/transmit.png") no-repeat;
  }
  .star {
    margin-left: 26px;
  }
  .transmit {
    margin-left: 55px;
  }
  h1 {
    font-family: MicrosoftYaHei;
    font-size: 24px;
    line-height: 24px;
    letter-spacing: 1px;
    color: #595757;
    text-align: left;
    border-left: 3px solid #d42f31;
    padding-left: 7px;
    margin-top: 43px;
  }
  table {
    width: 800px;
    border-collapse: collapse;
    margin-top: 30px;
  }
  th, td{
    border: solid #e5e5e5 1px;
    text-align: center;
  }
  .font {
    width: 110px;
    height: 60px;
    font-size: 14px;
    line-height: 60px;
    color: #595757;
    font-weight: bold;
  }
  .color {
    font-size: 14px;
    line-height: 24px;
    text-align: left;
    padding-left: 15px;
    color: rgba(89, 87, 87, 0.8);
  }
  .list {
    width: 800px;
    text-align: left;
    margin-top: 33px;
  }
  .list img {
    width: 800px;
  }
  .loca {
    margin-top: 22px;
  }
  .location {
    font-size: 24px;
    letter-spacing: 1px;
    line-height: 24px;
    color: #000000;
    display: block;
    margin-bottom: 20px;
  }
  .det {
    font-size: 18px;
    line-height: 24px;
    color: #000000;
    margin-left: 5px;
  }
  .intr {
    margin: 13px 0 22px 0;
  }
  .case {
    width: 800px;
    height: 450px;
    background: url("../assets/caseDetail/case.png") no-repeat;
    background-size: 800px 450px;
  }
  .bt {
    width: 800px;
    margin-top: 49px;
    /*overflow: hidden;*/
  }
  .bt p {
    width: 311px;
    height: 15px;
    background-color: #f7f7f7;
    font-size: 16px;
    line-height: 24px;
    color: #595757;
    padding: 19px 0;
    position: relative;
    /*overflow: hidden;*/
  }
  .bt p:hover {
    color: #d42f31;
    box-shadow:    0 15px 30px 0  rgba(0,0,0,0.1);
    transition-duration: 0.5s;
  }
  .last {
    float: left;
    margin-left: 9px;
  }
  .last:before{
    content: '';
    border-top: 9px solid transparent;/*方框上部分背景颜色为透明*/
    border-bottom: 9px solid transparent;/*方框下部分背景为透明*/
    border-right: 9px solid #f7f7f7;/*箭头背景颜色*/
    position: absolute;/*绝对定位1*/
    top: 19px;/*距离顶部位置偏移量2*/
    left: -9px;/*距离左边位置偏移量3*/ /*123都是控制显示位置的*/
  }
  .last:after{
    content: '';
    border-top: 7px solid transparent;
    border-bottom: 7px solid transparent;
    border-right: 7px solid #f7f7f7;/*箭头背景颜色，覆盖前面的#eee颜色，使其颜色与整体颜色一致*/
    position: absolute;
    top: 19px;
    left: -7px;
  }
  .next {
    float: right;
    margin-right: 9px;
  }
  .next:before{
    content: '';
    border-top: 9px solid transparent;/*方框上部分背景颜色为透明*/
    border-bottom: 9px solid transparent;/*方框下部分背景为透明*/
    border-left: 9px solid #f7f7f7;/*箭头背景颜色*/
    position: absolute;/*绝对定位1*/
    top: 19px;/*距离顶部位置偏移量2*/
    right: -9px;/*距离左边位置偏移量3*/ /*123都是控制显示位置的*/
  }
  .next:after{
    content: '';
    border-top: 7px solid transparent;
    border-bottom: 7px solid transparent;
    border-left: 7px solid #f7f7f7;/*箭头背景颜色，覆盖前面的#eee颜色，使其颜色与整体颜色一致*/
    position: absolute;
    top: 19px;
    right: -7px;
  }
  .similar {
    width: 110px;
    font-size: 24px;
    line-height: 24px;
    letter-spacing: 1px;
    color: #595757;
    border-left: 3px solid #d42f31;
    padding-left: 3px;
    margin: 126px 0 37px 0;
  }
  .slist {
    width: 800px;
    margin-bottom: 51px;
    overflow: hidden;
  }
  .slist li {
    display: inline-block;
    float: left;
    position: relative;
  }
  .tasking {
    position: absolute;
    width: 100%;
    height: 66px;
    /*bottom: -100%;*/
    font-size: 0.72vw;
    background: rgba(255, 255, 255, 0.8);
    opacity: 0.8;
    transform:translateY(-69px);
  }
  .tasking p {
    width: 100%;
    font-size: 19px;
    color: #3e3a39;
    position: absolute;
    top: 50%;
    left: 50%;
    padding: 9px 0;
    transform: translate(-50%, -50%);
    z-index: 10;
  }
  .slist li > img {
    width: 252px;
    height: 190px;
  }
  .slist li:nth-child(even) {
    margin: 0 22px;
  }

  .fade-enter-active, .fade-leave-active {
    transition: all 0.5s ease;
  }

  .fade-enter, .fade-leave-active{
    opacity: 0;
  }
</style>
