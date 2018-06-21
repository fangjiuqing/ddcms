<template>
  <div class="service">
    <Head></Head>
    <div class="allservice">
      <!--<div class="serviceBanner"></div>-->
      <div class="rig">
        <div class="appointment">
          <p class="gold">预约定制金牌服务</p>
          <input type="text" placeholder="所在地址" class="address">
          <input type="text" placeholder="您的姓名" class="name">
          <input type="text" placeholder="您的电话" class="phone">
          <div class="read">
            <input title="checkbox" type="checkbox" class="checkbox"/><p>我已阅读并接受<span>《装修常见问题条款》</span></p>
          </div>
          <p class="gain" @click="showPanel">立即预约</p>
          <p class="gainService">已有 <span>2425</span>人获得金牌服务</p>
        </div>
      </div>
    </div>
    <div class="free">
      <h3>免费专属装修顾问</h3>
      <p class="subhead">帮您搞定量房、报价、签约等全部问题，装修不被坑！</p>
      <ul class="list">
        <li v-for="(item, index) in frees" :key="index">
          <img :src="item.img" alt="">
          <p class="title">{{item.title}}</p>
          <p class="subtitle">{{item.subtitle}}</p>
          <p class="content">{{item.content}}</p>
        </li>
      </ul>
    </div>
    <div class="trusteeship">
      <h3>装修全程管家托管</h3>
      <p class="subhead">远程工地管理，随时随地看工地</p>
      <ul class="ship">
        <li v-for="(item, index) in trusteeship" :key="index">
          <img :src="item.img" alt="">
          <div class="describe">
            <p class="tit">{{item.title}}</p>
            <p class="sub">{{item.subtitle}}</p>
          </div>
        </li>
      </ul>
    </div>
    <div class="safeguard">
      <h3>道达装修保障</h3>
      <p class="subhead">拒绝恶意增项，辅材假一赔三</p>
      <ul class="safe">
        <li v-for="(item, index) in safeguard" :key="index">
          <img :src="item.img" alt="">
          <p class="title">{{item.title}}</p>
          <p class="subt">{{item.subtitle}}</p>
        </li>
      </ul>
    </div>
    <div class="flowDetail">
      <h3>道达服务流程</h3>
      <p class="subhead">一站式服务流程，专业的服务保障</p>
      <div class="cover">
        <img src="../assets/service/flow.png" alt="" class="flow">
        <ul class="flowList">
          <li>
            <img src="../assets/service/before.png" alt="">
            <p>装修前</p>
          </li>
          <li>
            <img src="../assets/service/sign.png" alt="">
            <p>签约</p>
          </li>
          <li>
            <img src="../assets/service/construction.png" alt="">
            <p>施工</p>
          </li>
          <li>
            <img src="../assets/service/complete.png" alt="">
            <p>竣工</p>
          </li>
        </ul>
        <div class="line"></div>
        <ol class="des">
          <li>1、进行家装资讯，了解家装知识。</li>
          <li>2、客户经理接待，了解需求。</li>
          <li>3、客户经理联系设计师与业主进行沟通。</li>
          <li>4、签订设计协议。</li>
          <li>5、专业人士上门量房。</li>
          <li>6、业主确认预算及设计后，签署施工合同和第三方协议。</li>
          <li>7、道达智装专业施工团队进行施工，装修。</li>
          <li>8、业主通过直播观看施工情况，公司提供质检服务。</li>
          <li>9、施工结束业主进行验收。</li>
          <li>10、业主查看装修满意进行网上评价，获取更多优惠。</li>
        </ol>
      </div>
    </div>
    <p class="quote" @click="showPanel">立即预约报价</p>
    <foot/>
    <sideBar/>
    <Price :panelShow.sync="panelShow"/>
  </div>
</template>
<script>
import Head from './head.vue'
import foot from './foot.vue'
import sideBar from './sidebar'
import Price from './price'
import detection from '../assets/service/detection.png'
import layout from '../assets/service/layout.png'
import style from '../assets/service/style.png'
import contract from '../assets/service/contract.png'
import progress from '../assets/service/progress.png'
import evaluate from '../assets/service/evaluate.png'
import refuse from '../assets/service/refuse.png'
import fake from '../assets/service/fake.png'
export default {
  name: 'service',
  metaInfo () {
    const title = '金牌服务 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      panelShow: false,
      frees: [
        {
          img: detection,
          title: '专业房屋检测',
          subtitle: '检测房屋细节 规范量房标准',
          content: '观察房屋结构，提出合理的拆改方案建议\n' +
          '详细记录测量数据，确保精准。'
        },
        {
          img: layout,
          title: '合理空间布局',
          subtitle: '合理规划空间 提高空间利用率',
          content: '在量房时帮助规划整体空间，最大化利用房屋面积，\n' +
          '避免装修留下遗憾。'
        },
        {
          img: style,
          title: '推荐装修风格',
          subtitle: '依据多年经验 个性化定制',
          content: '根据业主喜好、风格要求、房屋户型、\n' +
          '结构和装修预算等，定制合适的风格。'
        }
      ],
      trusteeship: [
        {
          img: contract,
          title: '电子合同',
          subtitle: '下载app，随时随地查看合同'
        },
        {
          img: progress,
          title: '装修进度同步',
          subtitle: '随时查看工地进度，一目了然'
        },
        {
          img: evaluate,
          title: '装修评价',
          subtitle: '查看已装修完用户的真实评价'
        }
      ],
      safeguard: [
        {
          img: refuse,
          title: '拒绝恶意增项',
          subtitle: '在施工过程中不会恶意增加装修费用，做到增项不能超过总工程额\n' +
          '的30%，实现装修费用透明。'
        },
        {
          img: fake,
          title: '辅材假一赔三',
          subtitle: '所有使用的辅材都是经过道达智装专业挑选辅材，质量保障，天然\n' +
          '环保，假一赔三。'
        }
      ]
    }
  },
  methods: {
    showPanel () {
      this.panelShow = true
    }
  },
  components: {
    Head, foot, sideBar, Price
  }
}
</script>
<style scoped>
  .allservice {
    position: relative;
    height: 500px;
    background: url("../assets/service/banner.png")  no-repeat center 0;
    margin: 0 auto;
  }
  .rig {
    width: 1010px;
    height: 400px;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
  }
  .appointment {
    width: 340px;
    height: 400px;
    background-color: #ffffff;
    position: absolute;
    right: 0;
  }
  .gold {
    font-size: 30px;
    letter-spacing: 1px;
    color: #3e3a39;
    margin-top: 31px;
  }
  .address,
  .name,
  .phone {
    display: block;
    width: 201px;
    height: 40px;
    background-color: #ffffff;
    border: solid 1px #c9caca;
    margin: 0 auto;
    line-height: 40px;
    background-size: 18px 23px;
    padding-left: 44px;
  }
  .address {
    background: url("../assets/service/address.png") no-repeat;
    background-position-x: 13px;
    background-position-y: center;
  }
  .name {
    background: url("../assets/service/name.png") no-repeat;
    background-position-x: 13px;
    background-position-y: center;
  }
  .phone {
    background: url("../assets/service/phone.png") no-repeat;
    background-position-x: 13px;
    background-position-y: center;
  }
  .appointment input:nth-child(2) {
    margin-top: 29px;
  }
  .appointment input:nth-child(3),
  .appointment input:nth-child(4) {
    margin-top: 15px;
  }
  .read {
    width: 247px;
    margin: 8px auto 0;
    text-align: left;
  }
  .checkbox {
    margin: 0 3px 0 0;
    vertical-align: middle;
  }
  .read p {
    vertical-align: middle;
    font-size: 12px;
    color: #b5b5b6;
    display: inline-block;
  }
  .read span {
    color: #d42f31;
  }
  .gain {
    width: 240px;
    height: 40px;
    background-color: #d42f31;
    margin: 29px auto 20px;
    line-height: 40px;
    text-align: center;
    font-size: 16px;
    color: #ffffff;
    cursor: pointer;
  }
  .gainService {
    font-size: 12px;
    color: #b5b5b6;
    margin: 0 auto;
  }
  .gainService span {
    color: #d42f31;
  }
  .free {
    height: 561px;
    padding-top: 78px;
  }
  h3 {
    font-size: 39px;
    color: #000;
    text-align: center;
    margin-bottom: 15px;
  }
  .subhead {
    font-size: 19px;
    color: #595757;
    text-align: center;
    margin-bottom: 11px;
  }
  .list {
    width: 1010px;
    margin: 80px auto 0;
  }
  .list li {
    width: 300px;
    display: inline-block;
  }
  .list li:nth-child(2) {
    margin: 0 50px;
  }
  .list li img {
    width: 300px;
    height: 200px;
  }
  .title {
    font-size: 24px;
    letter-spacing: 1px;
    color: #3e3a39;
    margin-top: 26px;
  }
  .subtitle {
    font-size: 18px;
    color: #727171;
    margin: 22px 0 25px;
  }
  .content {
    font-size: 14px;
    color: #9fa0a0;
    line-height: 23px;
  }
  .trusteeship {
    height: 566px;
    background-color: #fafafa;
    padding-top: 73px;
  }
  .ship {
    width: 1010px;
    margin: 68px auto 0;
  }
  .ship li {
    width: 309px;
    display: inline-block;
  }
  .ship li:nth-child(2) {
    margin: 0 36px;
  }
  .ship li img {
    width: 309px;
    height: 280px;
  }
  .describe {
    width: 272px;
    height: 63px;
    background-color: #ffffff;
    box-shadow: 0 6px 15px 0
    rgba(0, 0, 0, 0.1);
    margin: -30px auto 0;
    position: relative;
    z-index: 1;
    padding-top: 17px;
  }
  .tit {
    font-size: 18px;
    color: #3e3a39;
    margin-bottom: 13px;
  }
  .sub {
    font-size: 14px;
    color: #9fa0a0;
  }
  .safeguard {
    height: 644px;
    padding-top: 81px;
  }
  .safe {
    width: 1010px;
    margin: 77px auto 0;
  }
  .safe li {
    width: 485px;
    display: inline-block;
  }
  .safe li:nth-child(1) {
    margin-right: 30px;
  }
  .subt {
    margin-top: 17px;
    font-size: 16px;
    line-height: 34px;
    color: #9fa0a0;
    text-align: left;
  }
  .flowDetail {
    height: 668px;
    background-color: #fafafa;
    padding-top: 66px;
  }
  .cover {
    width: 900px;
    margin: 73px auto 0;
    overflow: hidden;
  }
  .flow {
    width: 342px;
    height: 450px;
    float: left;
  }
  .flowList {
    width: 72px;
    margin: 0 23px 0 49px;
    float: left;
  }
  .flowList li:nth-child(2),
  .flowList li:nth-child(3),
  .flowList li:nth-child(4) {
    margin-top: 26px;
  }
  .flowList img {
    width: 72px;
    height: 72px;
    box-shadow: 0 6px 15px 0
    rgba(0, 0, 0, 0.1);
    border-radius: 50%;
  }
  .flowList p {
    font-size: 14px;
    color: #595757;
    margin-top: 4px;
  }
  .line {
    width: 11px;
    height: 431px;
    background: url("../assets/service/line.png") no-repeat;
    background-size: 11px 431px;
    float: left;
  }
  .des {
    float: left;
    margin-left: 19px;
    font-size: 14px;
    color: #727171;
    text-align: left;
  }
  .des li:nth-child(2),
  .des li:nth-child(3),
  .des li:nth-child(4),
  .des li:nth-child(6),
  .des li:nth-child(8),
  .des li:nth-child(10) {
    margin-top: 14px;
  }
  .des li:nth-child(5),
  .des li:nth-child(7),
  .des li:nth-child(9){
    margin-top: 69px;
  }
  .quote {
    width: 290px;
    height: 50px;
    background-color: #d42f31;
    margin: 73px auto;
    font-size: 20px;
    color: #ffffff;
    text-align: center;
    line-height: 50px;
    cursor: pointer;
  }
</style>
