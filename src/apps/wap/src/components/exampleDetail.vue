<template>
    <div class="exampleDetail">
        <Head></Head>
        <div class="exampleCon">
            <img src="../assets/exampleDetail/top.png" alt="">
            <div class="right">
                <h3>汤臣一品-简约-三居室</h3>
                <div class="coll">
                    <span class="star">2445</span>
                    <span class="transmit">1675</span>
                </div>
                <p class="back">设计背景</p>
                <table border="1" cellspacing="0" cellpadding="0">
                    <tr><th class="font">房主年龄<th class="color">35</th></tr>
                    <tr><th class="font">房主职位</th> <th class="color">销售</th></tr>
                    <tr><td class="font">家庭成员</td> <td class="color">夫妻两人，女儿</td></tr>
                    <tr><td class="font">生活习惯</td> <td class="color">喜欢在家看电影倡导低碳生活；喜欢交友，踏实勤劳</td></tr>
                    <tr><td class="font">风格喜好</td> <td class="color">喜欢中西文化；喜欢现代的家居风格</td></tr>
                    <tr><td class="font">其他要求</td><td class="color">设计需体现现代感，同时保证人性化，不能常规化，可以做风格融入的尝试</td></tr>
                </table>
                <p class="effect">设计背景</p>
                <ul class="showList">
                    <li v-for="(item, index) in style" :key="index">
                        <img :src="item.imgUrl" alt="">
                        <p class="call">{{item.title}}</p>
                        <p class="introduce">{{item.intr}}</p>
                    </li>
                </ul>
                <img src="../assets/exampleDetail/detail.png" alt="" class="detail">
                <img src="../assets/exampleDetail/designer.png" alt="" class="photo">
                <div class="into">
                    <span class="name">于涛</span><span class="work">主案设计师</span>
                    <p>立即预约</p>
                </div>
                <p class="feel">本案采用了北美枫情板材，给人自然温馨的感觉。电视柜设计简约美观，现代简约的风格设计以白色的面板为基调，现代中透露着时尚。</p>
                <p class="brand">汤成一品</p>
                <ul class="show">
                    <li><span>区域</span><span>上海</span></li>
                    <li><span>面积</span><span>180平方(3室2厅)</span></li>
                    <li><span>风格</span><span>简约</span></li>
                    <li><span>造价</span><span>40万</span></li>
                </ul>
                <p class="offer" @click="showPanel">我要这样装&nbsp;立即获取报价</p>
                <div class="ln">
                    <p class="last">上一篇：盛世滨江</p>
                    <p class="next">下一篇：文化名邸</p>
                </div>
                <p class="similar">相似风格</p>
                <ul class="simi">
                    <li v-for="(item, index) in similar" :key="index">
                        <img :src="item" alt="">
                    </li>
                </ul>
            </div>
        </div>
        <Foot></Foot>
        <price :panelShow.sync="panelShow"></price>
    </div>
</template>

<script>
import Head from './head-nav'
import Foot from './footNav'
import price from './price'
import style1 from '../assets/exampleDetail/style1.png'
import style2 from '../assets/exampleDetail/style2.png'
import style3 from '../assets/exampleDetail/style3.png'
import similar1 from '../assets/exampleDetail/similar1.png'
import similar2 from '../assets/exampleDetail/similar2.png'
export default {
  name: 'example-detail',
  data () {
    return {
      panelShow: false,
      style: [
        {
          imgUrl: style1,
          title: '客厅',
          intr: '摈弃一切的复杂，回归到一片简介之中，设计实景白色作为整个空间的主色回归到一片简洁之中现代简约的风格设计以白色的面板为基调，现代中透露着时尚。'
        },
        {
          imgUrl: style2,
          title: '卧室',
          intr: '摈弃一切的复杂，回归到一片简介之中，设计实景白色作为整个空间的主色回归到一片简洁之中现代简约的风格设计以白色的面板为基调，现代中透露着时尚。'
        },
        {
          imgUrl: style3,
          title: '厨房',
          intr: '摈弃一切的复杂，回归到一片简介之中，设计实景白色作为整个空间的主色回归到一片简洁之中现代简约的风格设计以白色的面板为基调，现代中透露着时尚。'
        }
      ],
      similar: [
        similar1, similar2
      ]
    }
  },
  methods: {
    showPanel () {
      this.panelShow = true
    }
  },
  components: {
    Head, Foot, price
  }
}
</script>

<style scoped>
.exampleCon {
    margin-top: 88px;
}
.exampleCon > img {
    width: 100%;
}
.back {
    font-size: 28px;
    line-height: 24px;
    letter-spacing: 1px;
    color: #595757;
    border-left: 3px solid #d42f31;
    padding-left: 14px;
    margin: 33px 0 20px;
}
  table {
      width: 100%;
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
    font-size: 18px;
    line-height: 60px;
    color: #595757;
    font-weight: bold;
  }
  .color {
    font-size: 14px;
    line-height: 36px;
    text-align: left;
    padding-left: 15px;
    color: rgba(89, 87, 87, 0.8);
  }
  .effect {
    font-size: 28px;
    line-height: 24px;
    letter-spacing: 1px;
    color: #595757;
    border-left: 3px solid #d42f31;
    padding-left: 14px;
    margin: 23px 0 19px;
  }
  .showList {
      width: 100%;
  }
  .showList li {
      margin-bottom: 20px;
  }
  .showList img {
      width: 100%;
  }
  .call {
    font-size: 24px;
    line-height: 24px;
    letter-spacing: 1px;
    color: #000000;
    margin: 21px 0 23px;
  }
  .introduce {
    font-size: 24px;
    line-height: 36px;
    letter-spacing: 1px;
    color: #727171;
  }
  .detail {
      width: 100%;
      margin: 17px 0 34px;
  }
  .ln {
      font-size: 24px;
      line-height: 24px;
      letter-spacing: 1px;
      color: #595757;
      margin-top: 52px;
      overflow: hidden;
  }
  .last {
      float: left;
  }
  .next {
      float: right;
  }
  .similar {
    font-size: 28px;
    line-height: 24px;
    letter-spacing: 1px;
    color: #595757;
    border-left: 3px solid #d42f31;
    padding-left: 14px;
    margin: 34px 0 32px;
  }
  .simi {
      margin-bottom: 50px;
  }
  .simi li {
      width: 48%;
      display: inline-block;
  }
  .simi li img {
      width: 100%;
  }
  .simi li:nth-child(1) {
      margin-right: 28px;
  }
.right {
width: 93.6%;
margin: 0 auto;
text-align: left;
overflow: hidden;
}
.coll {
    float: right;
    margin-top: 41px;
}
h3 {
    width: 360px;
    display: inline-block;
    font-size: 36px;
    color: #000000;
    margin: 34px 0;
}
.photo {
width: 97px;
display: inline-block;
vertical-align: middle;
}
.into {
display: inline-block;
margin: auto 38px;
vertical-align: middle;
}
.name {
font-size: 30px;
line-height: 24px;
color: #3e3a39;
}
.work {
font-size: 24px;
line-height: 24px;
color: #3e3a39;
margin-left: 7px;
}
.into p {
width: 90px;
height: 18px;
font-size: 18px;
color: #d42f31;
border-radius: 17px;
border: solid 1px #d42f31;
padding: 8px 9px;
text-align: center;
margin-top: 15px;
}
.feel {
font-size: 24px;
line-height: 36px;
color: rgba(62, 58, 57, 0.8);
margin: 19px 0 21px 0;
}
.brand {
font-size: 30px;
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
font-size: 28px;
line-height: 24px;
color: #595757;
}
.show li span:nth-child(2) {
float: right;
font-size: 24px;
line-height: 24px;
color: #595757;
font-weight: bold;
}
.offer {
width: 420px;
height: 70px;
background-color: #d42f31;
font-size: 28px;
color: #ffffff;
margin: 22px auto 0;
text-align: center;
line-height: 70px;
cursor: pointer;
}
.coll span {
font-size: 24px;
color: #989898;
display: inline-block;
vertical-align:middle;
}
.coll span:before {
content: '';
display: inline-block;
width: 30px;
height: 30px;
vertical-align:middle;
margin-right: 10px;
}
.star:before {
background: url("../assets/exampleDetail/star.png") no-repeat;
background-size: 30px 30px;
}
.transmit:before {
background: url("../assets/exampleDetail/transmit.png") no-repeat;
background-size: 30px 30px;
}
.star {
margin-left: 26px;
}
.transmit {
margin-left: 55px;
}
</style>
