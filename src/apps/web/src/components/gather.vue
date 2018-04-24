<template>
  <div class="gather">
    <Head></Head>
    <div class="cover">
      <div class="conte">
        <!--<div class="title">-->
          <!--<span>首页</span>-->
          <!--<img src="../assets/gather/arrowRight.png">-->
          <!--<a href="javascript:;">智装案例</a>-->
        <!--</div>-->
        <!--<table border="1" cellspacing="0"  cellpadding="0">-->
          <!--<tr>-->
            <!--<th class="font">风格分类</th>-->
            <!--<th class="color col">-->
              <!--<span v-for="(item, index) in style" :key="index" @click="up($event)">{{item}}</span>-->
            <!--</th>-->
          <!--</tr>-->
          <!--<tr>-->
            <!--<td class="font">房型分类</td>-->
            <!--<td class="color co">-->
              <!--<span v-for="(item, index) in room" :key="index" @click="down($event)">{{item}}</span>-->
            <!--</td>-->
          <!--</tr>-->
        <!--</table>-->
        <p class="nice">{{nice}}
          <!--<span class="change">换一批</span>-->
        </p>
        <ul class="list1">
          <li v-for="(item, index) in img1" :key="index" @mouseenter="show(item)" @mouseleave="show(item)">
            <img :src="item.case_cover_sm" alt="">
            <transition name="fade">
              <router-link class="tasking" :to="{ name: 'caseDetail', query: { caseId: item.case_id }}" v-show="item.toggle">
                <div>
                  <p>{{item.case_title}}</p>
                  <div  class="yuan">
                    <span>面积：{{item.case_area}}</span>
                    <span class="price">造价：{{item.case_price}}</span>
                    <div class="detail">查看详情</div>
                  </div>
                </div>
              </router-link>
            </transition>
          </li>
        </ul>
        <p class="nice ni">{{ni}}
          <!--<span class="change">换一批</span>-->
        </p>
        <ul class="list2">
          <li v-for="(item, index) in img2" :key="index" @mouseenter="show(item)" @mouseleave="show(item)">
            <img :src="item.case_cover_sm" alt="">
            <transition name="fade">
              <router-link class="tasking" :to="{ name: 'caseDetail', query: { caseId: item.case_id }}" v-show="item.toggle">
                <div>
                  <p>{{item.case_title}}</p>
                  <div class="yuan">
                    <span>面积：{{item.case_area}}</span>
                    <span class="price">造价：{{item.case_price}}</span>
                    <div class="detail">查看详情</div>
                  </div>
                </div>
              </router-link>
            </transition>
          </li>
        </ul>
        <p class="nice ni">{{rec}}
          <!--<span class="change">换一批</span>-->
        </p>
        <ul class="list3">
          <router-link tag="li" :to="{ name: 'caseDetail', query: { caseId: item.case_id }}" v-for="(item, index) in img3" :key="index">
            <img v-lazy="item.case_cover_sm" alt="">
            <p>{{item.case_title}}</p>
            <div class="area">
              <span>面积：{{item.case_area}}</span>
              <span class="price">造价：{{item.case_price}}</span>
            </div>
          </router-link>
        </ul>
      </div>
    </div>
    <foot></foot>
    <sideBar></sideBar>
  </div>
</template>
<script>
import $ from 'jquery'
import Head from './head.vue'
import foot from './foot.vue'
import sideBar from './sidebar'
// import img1 from '../assets/gather/img1.png'
// import img12 from '../assets/gather/img12.png'
// import img2 from '../assets/gather/img2.png'
// import img3 from '../assets/gather/img3.png'
export default {
  name: 'gather',
  metaInfo () {
    const title = '优选案例 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      col: '',
      co: '',
      nice: '',
      ni: '',
      rec: '',
      style: [
        '全部',
        '现代简约',
        '新中式',
        '后现代',
        '地中海',
        '美式田园',
        '古典欧式'
      ],
      room: [
        '全部',
        '别墅',
        '标准房型'
      ],
      img1: [
        // {
        //   img: img1,
        //   name: 'caseDetail',
        //   isShow: false,
        //   home: '宝华海湾城'
        // },
        // {
        //   img: img12,
        //   name: 'caseDetail',
        //   isShow: false,
        //   home: '宝华海湾城'
        // },
        // {
        //   img: img12,
        //   name: 'caseDetail',
        //   isShow: false,
        //   home: '宝华海湾城'
        // },
        // {
        //   img: img12,
        //   name: 'caseDetail',
        //   isShow: false,
        //   home: '宝华海湾城'
        // },
        // {
        //   img: img12,
        //   name: 'caseDetail',
        //   isShow: false,
        //   home: '宝华海湾城'
        // }
      ],
      img2: [
        // {
        //   img: img2,
        //   isShow: false,
        //   home: '宝华海湾城'
        // },
        // {
        //   img: img2,
        //   isShow: false,
        //   home: '宝华海湾城'
        // },
        // {
        //   img: img2,
        //   isShow: false,
        //   home: '宝华海湾城'
        // },
        // {
        //   img: img2,
        //   isShow: false,
        //   home: '宝华海湾城'
        // },
        // {
        //   img: img2,
        //   isShow: false,
        //   home: '宝华海湾城'
        // },
        // {
        //   img: img2,
        //   isShow: false,
        //   home: '宝华海湾城'
        // }
      ],
      img3: [
        // {
        //   img: img3,
        //   house: '宝华海湾城'
        // },
        // {
        //   img: img3,
        //   house: '宝华海湾城'
        // },
        // {
        //   img: img3,
        //   house: '宝华海湾城'
        // },
        // {
        //   img: img3,
        //   house: '宝华海湾城'
        // }
      ]
    }
  },
  mounted () {
    this.addClass()
    // console.log('img1-----', this.img1)
  },
  methods: {
    show (item) {
      item.toggle = !item.toggle
    },
    up (e) {
      let ev = e.currentTarget
      $(ev).addClass('act').siblings().removeClass('act')
      this.col = $(ev).text()
      // console.log('this.col===', this.col)
    },
    down (e) {
      let ev = e.currentTarget
      $(ev).addClass('current').siblings().removeClass('current')
      this.co = $(ev).text()
      // console.log('this.co====', this.co)
    },
    addClass () {
      $('.col span:nth-child(1)').addClass('act')
      $('.co span:nth-child(1)').addClass('current')
    },
    getImg: function () {
      this.$http.post('public/case/index', {}).then(d => {
        // console.log('gather=========', d.data)
        if (d.code === 0) {
          // for (let i = 0; i < d.data.length; i++) {
          this.img1 = this.img1.concat(d.data[0].list)
          this.img2 = this.img2.concat(d.data[1].list)
          this.img3 = this.img3.concat(d.data[2].list)
          this.nice = d.data[0].list.length !== 0 ? d.data[0].cat_name : ''
          this.ni = d.data[1].list.length !== 0 ? d.data[1].cat_name : ''
          this.rec = d.data[2].list.length !== 0 ? d.data[2].cat_name : ''
          // }
        } else {
        }
      })
    }
  },
  created () {
    this.getImg()
  },
  components: {
    Head, foot, sideBar
  }
}
</script>
<style scoped>
  .cover {
    width: 100%;
    border-top: 1px solid lightgray;
    padding-top: 30px;
    position: relative;
    margin-top: 71px;
  }
  .conte {
    width: 1050px;
    margin: 0 auto;
    overflow: hidden;
  }
  .title {
    font-size: 14px;
    text-align: left;
  }
  .title img {
    margin: 0 6px;
  }
  .title a {
    font-size: 14px;
    text-decoration: none;
    color: #888;
  }
  table {
    width: 1000px;
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
    background-color: #fafafa;
  }
  .color {
    font-size: 14px;
    line-height: 60px;
    text-align: left;
    padding-left: 15px;
    color: rgba(89, 87, 87, 0.8);
  }
  table span {
    margin-right: 20px;
    cursor: pointer;
  }
  .act,
  .current {
    color: #d42f31;
  }
  .nice {
    font-size: 24px;
    line-height: 24px;
    letter-spacing: 1px;
    color: #595757;
    margin-top: 35px;
    border-left: 3px solid #d42f31;
    padding-left: 9px;
    text-align: left;
  }
  .ni {
    margin: 0;
  }
  .change {
    font-size: 16px;
    line-height: 24px;
    color: #595757;
    /*background: url("../assets/gather/change.png") no-repeat;*/
    /*background-size: 17px;*/
    /*background-position-x: 55px;*/
    /*display: inline-block;*/
    /*width: 72px;*/
    /*vertical-align:middle;*/
    float: right;
  }
  .change:after {
    content: '';
    display: inline-block;
    width: 20px;
    height: 20px;
    background: url("../assets/gather/change.png") no-repeat;
    background-size: 20px;
    vertical-align:middle;
    margin-left: 9px;
  }
  .list1 {
    width: 1050px;
    height: 400px;
    margin: 34px 0 0;
    overflow: hidden;
  }
  .list1 li {
    float: left;
    transition-duration: .5s;
    transform:translateY(1px);
  }
  .list1 li:hover,
  .list2 li:hover,
  .list3 li img:hover{
    box-shadow:    0 15px 30px 0  rgba(0,0,0,0.2);
    transition-duration: 0.5s;
    transform:translateY(-1px);
    cursor: pointer;
  }
  .list1 li:nth-child(1) {
    width: 500px;
    height: 309px;
  }
  .list1 li:nth-child(2),
  .list1 li:nth-child(3) {
    /*margin-bottom: 18px;*/
  }
  .list1 li:nth-child(2),
  .list1 li:nth-child(3),
  .list1 li:nth-child(4),
  .list1 li:nth-child(5) {
     width: 250px;
     /*height: 174px;*/
     margin-left: 15px;
   }
  .list1 li img {
    width: 100%;
  }
  .list2 {
    width: 1000px;
    /*height: 535px;*/
    margin-top: 34px;
    overflow: hidden;
  }
  .list2 li {
    width: 312px;
    /*height: 234px;*/
    float: left;
    transition-duration: .5s;
    transform:translateY(1px);
  }
  .list2 img {
    width: 100%;
  }
  .list2 li:nth-child(1), .list2 li:nth-child(3) {
    margin-bottom: 33px;
  }
  .list2 li:nth-child(2) {
    margin: 0 32px 33px;
  }
  .list2 li:nth-child(5) {
    margin: 0 32px;
  }
  .list3 {
    width: 1000px;
    height: 225px;
    margin: 34px 0 58px;
    overflow: hidden;
  }
  .list3 li {
    width: 232px;
    height: 174px;
    float: left;
  }
  .list3 li img {
    width: 100%;
    margin-top: 1px;
    transition-duration: .5s;
    transform:translateY(1px);
  }
  .list3 li:nth-child(2) {
    margin-left: 24px;
  }
  .list3 li:nth-child(3) {
    margin: 0 24px;
  }
  .list3 p {
    font-size: 16px;
    color: #595757;
    text-align: left;
    margin: 21px 0 8px;
    text-overflow:ellipsis;
    white-space:nowrap;
    overflow:hidden;
  }
  .list3 span {
    font-size: 12px;
    color: #595757;
  }
  .area {
    text-align: left;
  }
  .price {
    border-left: 1px solid #595757;
    margin-left: 5px;
    padding-left: 5px;
    text-align: left;
  }
  .list1 li:nth-child(1) p, .list2 li p {
    font-size: 30px;
  }
  .list1 li:nth-child(1) span {
    font-size: 14px;
  }
  .list1 li:nth-child(2) p,
  .list1 li:nth-child(3) p,
  .list1 li:nth-child(4) p,
  .list1 li:nth-child(5) p {
    font-size: 24px;
  }
  .list1 li:nth-child(2) span,
  .list1 li:nth-child(3) span,
  .list1 li:nth-child(4) span,
  .list1 li:nth-child(5) span {
    font-size: 10px;
  }
  .list1 li,
  .list2 li,
  .list3 li {
    position: relative;
  }
  .tasking {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    font-size: 0.72vw;
    background: #000;
    opacity: 0.8;
    display: inline-block;
    transform: translate(-50%);
  }
  .tasking p {
    width: 80%;
    position: absolute;
    top: 26%;
    left: 50%;
    font-size: 22px;
    color: #ffffff;
    padding: 9px 0;
    transform: translate(-50%, -30%);
    z-index: 10;
    text-overflow:ellipsis;
    white-space:nowrap;
    overflow:hidden;
  }
  .yuan {
    width: 95%;
    position: absolute;
    color: #fff;
    top: 44%;
    left: 40%;
    transform: translate(-40%, -44%);
  }
  .tasking span {
    display: inline-block;
    font-size: 14px;
    margin-top: 12px;
  }
  .tasking i {
    position: absolute;
    color: #fff;
    top: 60%;
    left: 60%;
    transform: translate(-60%, -60%);
  }
  .detail {
    width: 120px;
    height: 36px;
    line-height: 36px;
    font-size: 12px;
    color: #ffffff;
    border: 1px solid #fff;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    margin: 40px auto 0;
  }

  .fade-enter-active, .fade-leave-active {
    transition: all 0.5s ease;
  }

.fade-enter, .fade-leave-active{
  opacity: 0;
}

</style>
