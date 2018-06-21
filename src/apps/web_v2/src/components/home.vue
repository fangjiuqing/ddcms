<template>
  <div class="home">
    <Head/>
    <div class="swiper-contain">
      <div class="tasks">
        <swiper :options="swiperOption" ref="mySwiper">
          <swiper-slide v-for="(item, index) in banners" :key="index">
            <img :src="item" alt="swiper-image" class="swiper-image">
          </swiper-slide>
        </swiper>
      </div>
    </div>
    <div class="reason">
      <ul>
        <li v-for="(item, index) in reason" :key="index">
          <img :src="item.img" alt="">
          <p class="reasonT">{{item.title}}</p>
          <p class="reasonSub">{{item.subtitle}}</p>
          <p class="reasonIntr">{{item.intr}}</p>
        </li>
      </ul>
    </div>
    <div class="office">
      <h1>专注别墅、公寓、总裁办公装修服务</h1>
      <p class="subtitle">因为专注，所以专业！因为专业，所以值得信赖</p>
      <ul class="tabs">
        <li v-for="(item, index) in office" :key="index" :class="{active: index === ind}" @click="tab(index)">
          {{item.tab}}
        </li>
      </ul>
      <ul class="imgList">
        <li v-for="(item, index) in office" :key="index">
          <router-link :to="{name: 'personal-tailor'}">
            <img :src="item.img" alt="" v-show="index === ind">
            <div class="three" v-show="index === ind">
              <div class="negative">
                <p class="profession">{{item.profession}}<span>{{item.job}}</span></p>
                <p class="scheme">{{item.scheme}}</p>
                <p class="con">{{item.con}}</p>
              </div>
            </div>
          </router-link>
        </li>
      </ul>
    </div>
    <div class="office">
      <h1>智能系统，给家注入思维</h1>
      <p class="subtitle">自有芯片核心技术，道达造，真智能！</p>
      <ul class="tabs">
        <li v-for="(item, index) in intelligent" :key="index" :class="{active: index === inde}" @click="tabs(index)">
          {{item.tab}}
        </li>
      </ul>
      <ul class="imgLists">
        <li v-for="(item, index) in intelligent" :key="index" v-show="index === inde">
          <img :src="item.img" alt="">
          <div class="intelligentCon">
            <div class="model">
              <p class="tit">{{item.title}}</p>
              <p class="control">{{item.control}}</p>
              <ul class="modelList">
                <li v-for="(it, index) in item.model" :key="index">
                  {{it}}
                </li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="office">
      <h1>100%私人定制，满足你对设计的所有想象</h1>
      <p class="subtitle">高端定制，个性设计。合适你的，才是最好的</p>
      <ul class="prive">
        <li v-for="(item, index) in privates" :key="index" :class="{act: index === indexs}" @click="tabss(index)">
          {{item.tab}}
        </li>
      </ul>
      <ul class="privates">
        <li v-for="(items, index) in privates" :key="index" v-show="index === indexs">
          <ul class="lis">
            <li v-for="(item, index) in items.img" :key="index" @mouseenter="show(item)" @mouseleave="show(item)">
              <img :src="item.image" alt="">
              <transition name="fade">
                <a class="tasking" v-show="item.toggle">
                  <div>
                    <p>{{items.title}}</p>
                    <div class="yuan">
                      <span>面积：{{items.area}}</span>
                      <span class="price">造价：{{items.price}}</span>
                      <div class="detail">查看详情</div>
                    </div>
                  </div>
                </a>
              </transition>
            </li>
          </ul>
        </li>
      </ul>
      <p class="all">查看全部</p>
    </div>
    <div class="team">
      <h1>超30年行业经验设计大师坐阵的设计团队，让生活邂逅艺术</h1>
      <p class="subtitle">生活智慧大师，空间设计专家。会生活，所以更懂你
        经历不可逾越，荣誉不可磨灭，实力决定满意度</p>
      <img src="../assets/home/team/team.png" alt="">
    </div>
    <div class="standard">
      <h1>八星级施工验收标准，重新定义行业高端标准</h1>
      <ul class="stan">
        <li v-for="(item, index) in standard" :key="index">
          <p>{{item.intr}}</p>
          <img :src="item.img" alt="">
        </li>
      </ul>
    </div>
    <div class="material sfq">
      <h1>十维选材标准，用科学选出好产品</h1>
      <p class="subtitle"> 材料专家为你层层把关，全球搜寻，工厂直采，砍掉中间环节
        比天猫低35%，比区域代理低45%</p>
      <div class="material sfq">
        <ul>
          <li v-for="(item, index) in material" :key="index" :class="{curr: index === indexss}" @mouseenter="mate(index, $event)">
            <a href="javascript:;">
              <img :src="item.img" alt="">
            </a>
            <div class="layer">
              <img :src="item.mat" alt="">
              <div class="shadow"></div>
              <p class="p1"><span class="col2">{{item.intro}}</span></p>
              <p class="p2"><span class="col1">{{item.intro}}</span></p>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="partner">
      <span class="title">战略合作伙伴</span>
      <ul class="brand">
        <li v-for="(item, index) in brand" :key="index">
          <img :src="item" alt="">
        </li>
      </ul>
    </div>
    <div class="case">
      <h1>道达智装燃爆黄山，有真相，不忽悠</h1>
      <p class="subtitle">户型方案-深度解析</p>
      <ul class="caseList">
        <li v-for="(item, index) in cash" :key="index" @mouseenter="show(item)" @mouseleave="show(item)">
          <img :src="item.img" alt="">
          <transition name="fade">
            <a class="tasking task" v-show="item.toggle">
              <div class="look">看工地</div>
            </a>
          </transition>
          <p>
            <span>{{item.style}}</span>
            <span>已服务{{item.num}}家</span>
          </p>
        </li>
      </ul>
      <p class="all">查看全部</p>
    </div>
    <div class="owner">
      <h1>业主心声</h1>
      <p class="subtitle">迄今为止，道达智装客户投诉数为0</p>
      <ul class="ownerList">
        <li v-for="(item, index) in ownerBanner" :key="index" v-show="index === owners">
          <img :src="item" alt="">
        </li>
      </ul>
      <ul class="owners">
        <li v-for="(item, index) in owner" :key="index" @click="own(index)">
          <img :src="item" alt="">
          <div :class="{heart: index === owners}"></div>
        </li>
      </ul>
    </div>
    <div class="process">
      <h1>服务流程</h1>
      <ul class="processImg">
        <li v-for="(item, index) in process" :key="index">
          <img :src="item.img" alt="">
          <p>{{item.name}}</p>
        </li>
      </ul>
      <img src="../assets/home/process/process.png" alt="" class="line">
      <ul class="flow">
        <li v-for="(item, index) in process" :key="index">
          {{item.flow}}
        </li>
      </ul>
    </div>
    <div class="guarantee">
      <h1>你要选择的企业，应该是敢于承诺的企业</h1>
      <img src="../assets/home/guarantee/list.png" alt="">
    </div>
    <div class="order">
      <p>现在预约智装方案，即可领取<span>¥1000</span>现金抵用券，另有<span>1V1</span>VIP服务</p>
      <div class="tele">
        <span class="number"><input type="text" placeholder="请输入您的手机号" :maxlength="11" /></span>
        <span class="program">预约智装方案</span>
        <span class="phone"></span>
        <div class="right">
          <span class="nu">400-855-7785</span>
          <span class="time">服务时间：9:00～20:00</span>
        </div>
      </div>
    </div>
    <Foot/>
    <sideBar/>
  </div>
</template>
<script>
import $ from 'jquery'
import Head from './head.vue'
import Foot from './foot.vue'
import sideBar from './sidebar'
import banner1 from '../assets/home/banner/banner1.png'
import banner2 from '../assets/home/banner/banner2.png'
import banner3 from '../assets/home/banner/banner3.png'
import reason1 from '../assets/home/reason/reason1.png'
import reason2 from '../assets/home/reason/reason2.png'
import reason3 from '../assets/home/reason/reason3.png'
import reason4 from '../assets/home/reason/reason4.png'
import office1 from '../assets/home/office/office1.png'
import office2 from '../assets/home/office/office2.png'
import intelligent from '../assets/home/intelligent/intelligent.png'
import private1 from '../assets/home/private/private1.png'
import private2 from '../assets/home/private/private2.png'
import private3 from '../assets/home/private/private3.png'
import private4 from '../assets/home/private/private4.png'
import standard1 from '../assets/home/standard/standard1.png'
import standard2 from '../assets/home/standard/standard2.png'
import standard3 from '../assets/home/standard/standard3.png'
import standard4 from '../assets/home/standard/standard4.png'
import standard5 from '../assets/home/standard/standard5.png'
import standard6 from '../assets/home/standard/standard6.png'
import standard7 from '../assets/home/standard/standard7.png'
import standard8 from '../assets/home/standard/standard8.png'
import material1 from '../assets/home/material/material1.png'
import material2 from '../assets/home/material/material2.png'
import material3 from '../assets/home/material/material3.png'
import material4 from '../assets/home/material/material4.png'
import material5 from '../assets/home/material/material5.png'
import material6 from '../assets/home/material/material6.png'
import material7 from '../assets/home/material/material7.png'
import material8 from '../assets/home/material/material8.png'
import material9 from '../assets/home/material/material9.png'
import material10 from '../assets/home/material/material10.png'
import mat1 from '../assets/home/material/mat1.png'
import mat2 from '../assets/home/material/mat2.png'
import mat3 from '../assets/home/material/mat3.png'
import mat4 from '../assets/home/material/mat4.png'
import mat5 from '../assets/home/material/mat5.png'
import mat6 from '../assets/home/material/mat6.png'
import mat7 from '../assets/home/material/mat7.png'
import mat8 from '../assets/home/material/mat8.png'
import mat9 from '../assets/home/material/mat9.png'
import mat10 from '../assets/home/material/mat10.png'
import brand1 from '../assets/home/brand/brand1.png'
import brand2 from '../assets/home/brand/brand2.png'
import brand3 from '../assets/home/brand/brand3.png'
import brand4 from '../assets/home/brand/brand4.png'
import brand5 from '../assets/home/brand/brand5.png'
import brand6 from '../assets/home/brand/brand6.png'
import brand7 from '../assets/home/brand/brand7.png'
import brand8 from '../assets/home/brand/brand8.png'
import brand9 from '../assets/home/brand/brand9.png'
import brand10 from '../assets/home/brand/brand10.png'
import brand11 from '../assets/home/brand/brand11.png'
import brand12 from '../assets/home/brand/brand12.png'
import brand13 from '../assets/home/brand/brand13.png'
import brand14 from '../assets/home/brand/brand14.png'
import brand15 from '../assets/home/brand/brand15.png'
import brand16 from '../assets/home/brand/brand16.png'
import brand17 from '../assets/home/brand/brand17.png'
import brand18 from '../assets/home/brand/brand18.png'
import case1 from '../assets/home/case/case1.png'
import case2 from '../assets/home/case/case2.png'
import case3 from '../assets/home/case/case3.png'
import case4 from '../assets/home/case/case4.png'
import case5 from '../assets/home/case/case5.png'
import case6 from '../assets/home/case/case6.png'
import owner1 from '../assets/home/owner/owner1.png'
import owner2 from '../assets/home/owner/owner2.png'
import owner3 from '../assets/home/owner/owner3.png'
import owner4 from '../assets/home/owner/owner4.png'
import owner5 from '../assets/home/owner/owner5.png'
import ownerBanner from '../assets/home/owner/ownerBanner.png'
import process1 from '../assets/home/process/process1.png'
import process2 from '../assets/home/process/process2.png'
import process3 from '../assets/home/process/process3.png'
import process4 from '../assets/home/process/process4.png'
import process5 from '../assets/home/process/process5.png'
import process6 from '../assets/home/process/process6.png'
import process7 from '../assets/home/process/process7.png'
import process8 from '../assets/home/process/process8.png'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
export default {
  name: 'home',
  data () {
    return {
      ind: 0,
      inde: 0,
      indexs: 0,
      indexss: 0,
      owners: 0,
      banners: [
        banner1, banner2, banner3
      ],
      reason: [
        {
          img: reason1,
          title: '绿色健康',
          subtitle: 'ENVIRONMENTAL  PROTECTION',
          intr: '材料环保、工艺环保、设计环保'
        },
        {
          img: reason2,
          title: '超智能设计',
          subtitle: 'INTELLIGENT DESIGN',
          intr: '人体工学设计，艺术和体验并重,\n' +
          '自有芯片核心技术，使家更智能'
        },
        {
          img: reason3,
          title: '品质承诺',
          subtitle: 'QUALITY ASSURANCE',
          intr: '设计、材料、工艺各纬度\n' +
          '重新定义行业高端标准'
        },
        {
          img: reason4,
          title: '透明省心',
          subtitle: ' PROVINCIAL HEART',
          intr: '工程透明、材料透明、管理透明\n' +
          '明白自己的每一分钱花在哪里'
        }
      ],
      office: [
        {
          img: office1,
          tab: '私人定制',
          profession: '总经理',
          job: '办公',
          scheme: '风水大师坐阵\n' +
          '顶级设计师设计\n' +
          '提供全套解决方案',
          con: '高标绿色选材，极速工期、\n' +
          '即装即用。'
        },
        {
          img: office2,
          tab: '省心整装',
          profession: '总裁',
          job: '办公',
          scheme: '风水大师坐阵\n' +
          '顶级设计师设计\n' +
          '提供全套解决方案',
          con: '高标绿色选材，极速工期、\n' +
          '即装即用。'
        }
      ],
      intelligent: [
        {
          img: intelligent,
          tab: '智能场景',
          title: '十二大场景个性设置',
          control: '通过对灯、家电、窗帘、音视频、门窗、安防等的智能化控制，结合你的生活规律、活动路线、打造个性化智能场景。',
          model: [
            '回家模式', '离家模式', '娱乐模式', '迎驾模式', '影音模式', '会客模式',
            '就餐模式', '起床模式', '起夜模式', '灌溉模式', '安防模式', '睡眠模式'
          ]
        },
        {
          img: intelligent,
          tab: '智能系统',
          title: '十二大系统个性定制',
          control: '通过对灯、家电、窗帘、音视频、门窗、安防等的智能化控制，结合你的生活规律、活动路线、打造个性化智能场景。',
          model: [
            '回家模式', '离家模式', '娱乐模式', '迎驾模式', '影音模式', '会客模式',
            '就餐模式', '起床模式', '起夜模式', '灌溉模式', '安防模式', '睡眠模式'
          ]
        }
      ],
      privates: [
        {
          title: '宝华海湾城',
          area: '120平米(3室2厅)',
          price: '40万',
          toggle: false,
          img: [
            {
              image: private3,
              toggle: false
            },
            {
              image: private2,
              toggle: false
            },
            {
              image: private1,
              toggle: false
            },
            {
              image: private4,
              toggle: false
            }
          ],
          tab: '别墅大宅'
        },
        {
          title: '宝华海湾城',
          area: '120平米(3室2厅)',
          price: '40万',
          toggle: false,
          img: [
            {
              image: private2,
              toggle: false
            },
            {
              image: private1,
              toggle: false
            },
            {
              image: private3,
              toggle: false
            },
            {
              image: private4,
              toggle: false
            }
          ],
          tab: '公寓案例'
        }
        // {
        //   title: '宝华海湾城',
        //   area: '120平米(3室2厅)',
        //   price: '40万',
        //   toggle: false,
        //   img: [
        //     {
        //       image: private3,
        //       toggle: false
        //     },
        //     {
        //       image: private4,
        //       toggle: false
        //     },
        //     {
        //       image: private1,
        //       toggle: false
        //     },
        //     {
        //       image: private2,
        //       toggle: false
        //     }
        //   ],
        //   tab: '办公项目'
        // }
      ],
      standard: [
        {
          img: standard1,
          intr: '自建施工团队'
        },
        {
          img: standard2,
          intr: '200道施工工序'
        },
        {
          img: standard3,
          intr: '5层质量监管体系'
        },
        {
          img: standard4,
          intr: '234项验收标准'
        },
        {
          img: standard5,
          intr: '6大环保防护体系'
        },
        {
          img: standard6,
          intr: '5大称心保障系统'
        },
        {
          img: standard7,
          intr: '一站式全包服务'
        },
        {
          img: standard8,
          intr: '24小时管家式服务'
        }
      ],
      material: [
        {
          img: material1,
          intro: '环保',
          mat: mat1
        },
        {
          img: material2,
          intro: '品质',
          mat: mat2
        },
        {
          img: material3,
          intro: '做工',
          mat: mat3
        },
        {
          img: material4,
          intro: '设计',
          mat: mat4
        },
        {
          img: material5,
          intro: '智能',
          mat: mat5
        },
        {
          img: material6,
          intro: '体验',
          mat: mat6
        },
        {
          img: material7,
          intro: '工厂',
          mat: mat7
        },
        {
          img: material8,
          intro: '售后',
          mat: mat8
        },
        {
          img: material9,
          intro: '交期',
          mat: mat9
        },
        {
          img: material10,
          intro: '物流',
          mat: mat10
        }
      ],
      brand: [
        brand1, brand2, brand3, brand4, brand5, brand6, brand7, brand8, brand9,
        brand10, brand11, brand12, brand13, brand14, brand15, brand16, brand17, brand18
      ],
      cash: [
        {
          img: case1,
          style: '现代御墅',
          num: '24',
          toggle: false
        },
        {
          img: case2,
          style: '现代御墅',
          num: '24',
          toggle: false
        },
        {
          img: case3,
          style: '现代御墅',
          num: '24',
          toggle: false
        },
        {
          img: case4,
          style: '现代御墅',
          num: '24',
          toggle: false
        },
        {
          img: case5,
          style: '现代御墅',
          num: '24',
          toggle: false
        },
        {
          img: case6,
          style: '现代御墅',
          num: '24',
          toggle: false
        }
      ],
      owner: [
        owner1, owner2, owner3, owner4, owner5
      ],
      ownerBanner: [
        ownerBanner, ownerBanner, ownerBanner, ownerBanner, ownerBanner
      ],
      process: [
        {
          img: process1,
          name: '在线预约',
          flow: '第一步'
        },
        {
          img: process2,
          name: '咨询洽谈',
          flow: '第二步'
        },
        {
          img: process3,
          name: '免费量房',
          flow: '第三步'
        },
        {
          img: process4,
          name: '设计阶段',
          flow: '第四步'
        },
        {
          img: process5,
          name: '施工阶段',
          flow: '第五步'
        },
        {
          img: process6,
          name: '竣工验收',
          flow: '第六步'
        },
        {
          img: process7,
          name: '装修保障',
          flow: '第七步'
        },
        {
          img: process8,
          name: '装修保障',
          flow: '第八步'
        }
      ],
      swiperOption: {
        autoplay: true,
        speed: 400,
        loop: true
      }
    }
  },
  methods: {
    tab (index) {
      this.ind = index
    },
    tabs (index) {
      this.inde = index
    },
    tabss (index) {
      this.indexs = index
    },
    own (index) {
      this.owners = index
    },
    show (item) {
      item.toggle = !item.toggle
    },
    mate (index, e) {
      this.indexss = index
      let ev = e.currentTarget

      // let _index = $(ev).index()

      $(ev).addClass('curr')
        .stop()
        .animate({
          width: '840px'
        }, 500)
        .siblings()
        .stop()
        .animate({
          width: '120px'
        }, 500)
        .removeClass('curr')

      $(ev).find('.layer').stop().animate({height: '0px'}, 500).parent().siblings().find('.layer').stop().animate({
        height: '100%'
      }, 500)

      $(ev).find('.layer .p1').stop().animate({left: '-200%'}, 500).siblings('.p2').stop().animate({
        right: '-200%'
      }, 500).parent().parent().siblings().find('.layer .p1').stop().animate({left: '10px'}, 500).siblings('.p2').stop().animate({
        right: '-200%'
      }, 500)
    }
  },
  mounted () {
    $('.material ul li.curr').animate({width: '840px'}, 500)
    $('.material ul li.curr .layer').animate({height: '0px'}, 500)
    $('.material ul li.curr .layer .p1').animate({left: '-200%'}, 500)
    $('.material ul li.curr .layer .p2').animate({right: '-200%'}, 500)
  },
  components: {
    swiper, swiperSlide, Head, Foot, sideBar
  }
}
</script>
<style scoped>
  .tasks {
    position: relative;
  }
  .swiper-slide img {
    width: 100%;
  }
  .reason {
    width: 1200px;
    height: 300px;
    background-color: #f8f8f8;
    margin: 70px auto 0;
    position: relative;
  }
  .reason ul {
    height: 206px;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
  }
  .reason li {
    width: 202px;
    height: 206px;
    border-right: 1px solid #a5a4a5;
    float: left;
    padding-right: 57px;
    margin-right: 36px;
    text-align: left;
  }
  .reason li:first-child {
    margin-left: 41px;
  }
  .reason li:last-child {
    border-right: 0;
    padding-right: 0;
    margin-right: 0;
  }
  .reasonT {
    font-size: 38px;
    color: #000000;
    margin: 19px 0 14px;
  }
  .reasonSub {
    font-size: 12px;
    color: #b9b9b9;
  }
  .reasonIntr {
    font-size: 14px;
    line-height: 21px;
    color: #000000;
    margin-top: 22px;
  }
  .office {
    width: 1200px;
    margin: 100px auto 0;
    text-align: center;
  }
  h1 {
    font-size: 40px;
    color: #333333;
  }
  .subtitle {
    font-size: 18px;
    color: #666666;
    margin: 12px 0 0;
  }
  .tab,.tabs {
    margin-top: 41px;
  }
  .tab li {
    display: inline-block;
    width: 394px;
    height: 53px;
    line-height: 53px;
    background-color: #f8f8f8;
    border: solid 1px rgba(144, 144, 144, 0.2);
    cursor: pointer;
  }
  .active {
    border-top: 2px solid #4d677b!important;
    border-bottom: 0!important;
    background-color: #fff!important;
  }
  .tab li:nth-child(2),
  .tab li:nth-child(3) {
    margin-left: -2px;
  }
  .imgList {
    width: 1193px;
    height: 589px;
    /* margin: 12px auto 0; */
    margin: 0 auto;
    position: relative;
  }
  .imgList li {
    position: absolute;
  }
  .three {
    width: 50px;
    height: 414px;
    border-top: 28px solid transparent;
    border-right: 50px solid transparent;
    border-bottom: 28px solid transparent;
    border-left: 192px solid rgba(37, 40, 43, 0.9);
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    margin: auto 0;
  }
  .negative {
    position: absolute;
    left: -168px;
    color: #fff;
    text-align: left;
    margin-top: 28px;
  }
  .profession {
    font-size: 36px;
  }
  .profession span {
    font-size: 18px;
  }
  .profession:after,
  .scheme:after {
    content: '';
    display: block;
    width: 154px;
    height: 1px;
    background-color: rgba(255, 255, 255, 0.6);
    opacity: 0.6;
    margin: 11px 0 9px;
  }
  .scheme, .con {
    line-height: 18px;
  }
  .scheme {
    width: 116px;
    font-size: 14px;
  }
  .con {
    width: 137px;
    font-size: 12px;
  }
  .tabs li {
    display: inline-block;
    width: 599px;
    height: 53px;
    line-height: 53px;
    background-color: #f8f8f8;
    border: solid 1px rgba(144, 144, 144, 0.2);
    cursor: pointer;
  }
  .tabs li:nth-child(2) {
    margin-left: -2px;
  }
  .imgLists {
    width: 1200px;
    height: 470px;
    /* margin: 12px auto 0; */
    margin: 0 auto;
    position: relative;
  }
  .imgLists > li {
    position: absolute;
  }
  .intelligentCon {
    width: 290px;
    height: 469px;
    background-color: rgba(0, 0, 0, 0.5);
    opacity: 0.5;
    position: absolute;
    top: 0;
  }
  .model {
    width: 228px;
    margin: auto;
  }
  .tit {
    font-size: 22px;
    color: #ffffff;
    border-bottom: 1px solid rgba(238, 238, 238, 0.6);
    padding-bottom: 13px;
    margin: 29px 0 12px;
  }
  .control {
    width: 227px;
    font-size: 12px;
    line-height: 18px;
    color: #ffffff;
    text-align: left;
  }
  .modelList {
    margin-top: 14px;
    overflow: hidden;
  }
  .modelList li {
    width: 30px;
    height: 30px;
    font-size: 12px;
    padding: 20px;
    line-height: 16px;
    display: inline-block;
    background-color: transparent;
    color: rgba(255, 255, 255, 0.7);
    border: solid 1px rgba(255, 255, 255, 0.5);
    margin-bottom: 6px;
    float: left;
    cursor: pointer;
  }
  .modelList li:hover {
    color: #333333;
    background-color: rgba(255, 255, 255, 0.9);
  }
  .modelList li:nth-child(2),
  .modelList li:nth-child(5),
  .modelList li:nth-child(8),
  .modelList li:nth-child(11) {
    margin: 0 6px 6px;
  }
  .prive {
    text-align: center;
    margin-top: 46px;
    border-bottom: 1px solid #d7d7d7;
  }
  .prive li {
    width: 152px;
    display: inline-block;
    font-size: 16px;
    color: #999999;
    padding-bottom: 17px;
    margin: 0 auto;
    cursor: pointer;
  }
  .prive li:nth-child(1) {
    margin-right: 196px;
  }
  .act {
    font-size: 16px!important;
    color: #333333!important;
    border-bottom: 2px solid #d42f31;
  }
  .privates {
    margin-top: 34px;
    overflow: hidden;
  }
  .privates li {
    transition-duration: .5s;
    transform:translateY(1px);
  }
  .privates ul li {
    width: 580px;
    height: 327px;
    cursor: pointer;
    float: left;
  }
  .privates ul li:nth-child(1),
  .privates ul li:nth-child(3) {
    margin-right: 38px;
  }
  .privates ul li:nth-child(1),
  .privates ul li:nth-child(2) {
    margin-bottom: 38px;
  }
  .privates img {
    width: 100%;
    height: 100%;
  }
  .price {
    border-left: 1px solid #595757;
    margin-left: 5px;
    padding-left: 5px;
    text-align: left;
  }
  .privates li {
    position: relative;
  }
  .tasking {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    font-size: 0.72vw;
    background: #000;
    opacity: 0.6;
    display: inline-block;
    transform: translate(-50%);
  }
  .tasking p {
    width: 80%;
    position: absolute;
    top: 26%;
    left: 50%;
    font-size: 30px;
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
    width: 150px;
    height: 42px;
    line-height: 42px;
    font-size: 16px;
    color: #ffffff;
    border: 1px solid #fff;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    margin: 40px auto 0;
  }
  .all {
    width: 400px;
    height: 48px;
    text-align: center;
    line-height: 48px;
    margin: 40px auto 0;
    background-color: #ffffff;
    border: solid 1px #666666;
    cursor: pointer;
  }
  .team {
    margin: 100px auto 0;
  }
  .team h1 {
    width: 1200px;
    margin: 0 auto;
  }
  .team .subtitle {
    width: 429px;
    line-height: 28px;
    margin: 12px auto 0;
  }
  .team img {
    width: 100%;
    margin-top: 49px;
  }
  .standard {
    width: 1200px;
    margin: 0 auto;
  }
  .stan {
    margin-top: 50px;
  }
  .stan li {
    width: 190px;
    height: 133px;
    display: inline-block;
    position: relative;
  }
  .stan li:nth-child(1),
  .stan li:nth-child(2),
  .stan li:nth-child(3),
  .stan li:nth-child(5),
  .stan li:nth-child(6),
  .stan li:nth-child(7) {
    margin-right: 146px;
  }
  .stan li:nth-child(1),
  .stan li:nth-child(2),
  .stan li:nth-child(3),
  .stan li:nth-child(4) {
    margin-bottom: 90px;
  }
  .stan p {
    width: 160px;
    height: 70px;
    text-align: center;
    line-height: 70px;
    background-color: #ffffff;
    position: absolute;
    left: 0;
    top: 0;
    z-index: 5;
    box-shadow: 3px 5px 11px 0 rgba(102, 102, 102, 0.16);
  }
  .stan img {
    width: 158px;
    height: 88px;
    background-color: #746868;
    position: absolute;
    right: 0;
    bottom: 0;
    box-shadow: 6px 0 11px 0 rgba(102, 102, 102, 0.1);
    border: solid 1px rgba(255, 255, 255, 0.02);
  }

  .fade-enter-active, .fade-leave-active {
    transition: all 0.5s ease;
  }

  .fade-enter, .fade-leave-active{
    opacity: 0;
  }
  .material {
    margin: 100px auto 0;
  }
  .material h1 {
    width: 1200px;
    margin: 0 auto;
  }
  .material .subtitle {
    width: 429px;
    line-height: 28px;
    margin: 12px auto 0;
  }
  .material ul {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 500px;
    margin: 60px auto 0;
  }
  .material ul li {
    float: left;
    width: 120px;
    overflow: hidden;
    height: 100%;
    position: relative;
    border-right: 1px solid rgba(255, 255, 255, 0.5);
    cursor: pointer;
  }
  .material ul li a {
    display: block;
    width: 100%;
    height: 100%;
    overflow: hidden;
  }
  .material ul li .layer {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background:rgba(27,29,36,0.4);
    height: 100%;
  }
  .shadow {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
    background:rgba(27,29,36,0.4);
  }
  .material ul li .layer .p1 {
    width: 26px;
    height: 78px;
    font-size: 28px;
    line-height: 22px;
    letter-spacing: 25px;
    color: #ffffff;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    margin: auto;
  }
  .material ul li .layer .p2 {
    position: absolute;
    bottom: 5px;
    right: -200%;
  }
  .material ul li .layer .p2 b,
  .material ul li .layer .p2 span {
    display: block;
    font-weight: bold;
    font-size: 20px;
  }
  .material ul li .layer .p1 b,
  .material ul li .layer .p1 span {
    display: block;
    font-weight: bold;
    font-size: 14px;
  }
  .col2{
    color: #fff;
  }
  .partner {
    width: 1200px;
    margin: 56px auto 0;
  }
  .title {
    width: 1200px;
    display: block;
    font-size: 18px;
    color: #333333;
    margin: 0 auto 29px;
    position: relative;
  }
  .title:before, .title:after {
    content: '';
    position: absolute;
    top: 52%;
    background: #cccccc;
    width: 506px;
    height: 1px;
  }
  .title:before {
    left: 0;
  }
  .title:after {
    right: 0;
  }
  .brand li {
    width: 92px;
    height: 50px;
    display: inline-block;
  }
  .brand li img {
    width: 100%;
  }
  .brand li:nth-child(1),
  .brand li:nth-child(2),
  .brand li:nth-child(3),
  .brand li:nth-child(4),
  .brand li:nth-child(5),
  .brand li:nth-child(7),
  .brand li:nth-child(8),
  .brand li:nth-child(9),
  .brand li:nth-child(10),
  .brand li:nth-child(11),
  .brand li:nth-child(13),
  .brand li:nth-child(14),
  .brand li:nth-child(15),
  .brand li:nth-child(16),
  .brand li:nth-child(17) {
    margin-right: 100px;
  }
  .brand li:nth-child(7),
  .brand li:nth-child(8),
  .brand li:nth-child(9),
  .brand li:nth-child(10),
  .brand li:nth-child(11),
  .brand li:nth-child(12) {
    margin-top: 15px;
    margin-bottom: 15px;
  }
  .case {
    width: 1200px;
    margin: 100px auto 0;
  }
  .caseList {
    margin-top: 33px;
  }
  .caseList li {
    display: inline-block;
    border: solid 1px rgba(255, 255, 255, 0.16);
    position: relative;
  }
  .caseList li:nth-child(1),
  .caseList li:nth-child(2),
  .caseList li:nth-child(3) {
    margin-bottom: 46px;
  }
  .caseList li:nth-child(2),
  .caseList li:nth-child(5) {
    margin: 0 37px;
  }
  .caseList p {
    margin-top: 25px;
  }
  .caseList p span:nth-child(1) {
    font-size: 18px;
    color: #333333;
  }
  .caseList p span:nth-child(2) {
    font-size: 12px;
    color: #333333;
    margin-left: 13px;
    padding-left: 13px;
    border-left: 1px solid lightgray;
    display: inline-block;
  }
  .owner {
    margin-top: 100px;
  }
  .ownerList {
    width: 100%;
    margin-top: 36px;
  }
  .ownerList li img {
    width: 100%;
  }
  .owners {
    margin-top: -49px;
  }
  .owners li {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 30px;
    position: relative;
  }
  .owners li img {
    width: 96px;
    position: absolute;
    left: 0;
  }
  .owners li div {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    position: absolute;
    left: 0;
    background-color: rgba(171, 171, 171, 0.3);
  }
  .heart {
    background-color: rgba(171, 171, 171, 0) !important;
  }
  .process {
    margin-top: 100px;
  }
  .processImg {
    width: 1200px;
    margin: 57px auto 0;
    overflow: hidden;
  }
  .processImg li {
    float: left;
  }
  .processImg li:nth-child(1) {
    margin-left: 41px;
  }
  .processImg li:nth-child(2) {
    margin-left: 77px;
  }
  .processImg li:nth-child(3) {
    margin-left: 78px;
  }
  .processImg li:nth-child(4) {
    margin-left: 79px;
  }
  .processImg li:nth-child(5) {
    margin-left: 78px;
  }
  .processImg li:nth-child(6) {
    margin-left: 78px;
  }
  .processImg li:nth-child(7) {
    margin-left: 78px;
  }
  .processImg li:nth-child(8) {
    margin-left: 78px;
  }
  .processImg li img {
    height: 35px;
  }
  .processImg li p {
    font-size: 18px;
    color: #333333;
    margin-top: 21px;
  }
  .processImg li span {
    display: inline-block;
    font-size: 15px;
    color: #999999;
    margin: 20px 0 39px;
  }
  .line {
    margin-top: 41px;
  }
  .flow {
    width: 1200px;
    margin: 30px auto 0;
    overflow: hidden;
  }
  .flow li {
    display: inline-block;
    font-size: 12px;
    color: #999999;
    float: left;
  }
  .flow li:nth-child(1) {
    margin-left: 57px;
  }
  .flow li:nth-child(2) {
    margin-left: 114px;
  }
  .flow li:nth-child(3) {
    margin-left: 114px;
  }
  .flow li:nth-child(4) {
    margin-left: 114px;
  }
  .flow li:nth-child(5) {
    margin-left: 114px;
  }
  .flow li:nth-child(6) {
    margin-left: 114px;
  }
  .flow li:nth-child(7) {
    margin-left: 114px;
  }
  .flow li:nth-child(8) {
    margin-left: 114px;
  }
  .guarantee {
    height: 580px;
    background: url("../assets/home/guarantee/guaranteeBanner.png") no-repeat;
    margin-top: 100px;
    padding-top: 90px;
  }
  .guarantee h1 {
    font-size: 48px;
    color: #e7e7e7;
  }
  .guarantee img {
    width: 1001px;
    margin: 87px 0 0;
  }
  .order {
    height: 330px;
    padding-top: 108px;
    box-sizing: border-box;
    background-color: #eeeeee;
  }
  .order p {
    font-size: 22px;
    color: #333333;
  }
  .order p span {
    color: #ff7800;
  }
  .tele {
    width: 700px;
    margin: 42px auto 0;
  }
  .tele > span {
    height: 48px;
    float: left;
  }
  .number {
    width: 218px;
  }
  .program {
    width: 154px;
  }
  .tele span input {
    width: 196px;
    height: 46px;
    border: 0;
    display: inline-block;
    padding-left: 20px;
    border-top-left-radius: 23px;
    border-bottom-left-radius: 23px;
  }
  .tele span input:focus{
    outline: none;
    /*border: 1px solid #58b195;*/
  }
  .program {
    font-size: 16px;
    color: #fff;
    line-height: 48px;
    border-top-right-radius: 23px;
    border-bottom-right-radius: 23px;
    background-color: #d42f31;
    box-shadow: 0 3px 17px 0 rgba(221, 106, 106, 0.4);
  }
  .phone {
    width: 63px;
    margin: 0 15px 0 28px;
    border-left: 1px solid #ccc;
    background: url("../assets/home/guarantee/phone.png") no-repeat;
    background-size: 48px;
    background-position-x: 19px;
  }
  .right {
    width: 137px;
    float: left;
  }
  .nu {
    height: 17px;
    font-size: 20px;
    color: #666666;
  }
  .time {
    font-size: 13px;
    color: rgba(51, 51, 51, 0.6);
    margin-top: 7px;
    display: inline-block;
  }
  .task {
    width: 355px;
    height: 200px;
  }
  .task div {
    width: 160px;
    height: 40px;
    border: solid 1px rgba(235, 235, 235, 0.7);
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    font-size: 16px;
    line-height: 40px;
    color: #ffffff;
  }
</style>
