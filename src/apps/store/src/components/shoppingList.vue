<template>
    <div class="shopList">
      <div class="black">
        <div class="nav">
          <div class="rl">
            <span>登录</span>
            <span>注册</span>
          </div>
        </div>
      </div>
      <div class="topSearch">
        <div class="logo"></div>
        <div class="left">优材商城</div>
        <div class="mar">
          <input type="text" class="search" placeholder="瓷砖类"/>
          <p>搜索</p>
          <div class="shop">
            <span>购物车</span>
          </div>
        </div>
      </div>
      <div class="commodity">
        <div class="all">
          <p @mouseleave="hidePanel" @mouseenter="showPanel">全部商品分类</p>
          <ul>
            <li>
              <a href="javascript:;">限时抢购</a>
            </li>
            <li>
              <a href="javascript:;">品牌特卖</a>
            </li>
            <li>
              <a href="javascript:;">爆款拼团</a>
            </li>
            <li>
              <a href="javascript:;">智能家居馆</a>
            </li>
          </ul>
        </div>
      </div>
      <Common :Show.sync="Show" v-show="Show"/>
      <div class="background">
        <div class="contents">
          <p class="li">
            <span>首页</span>
            <span>建材</span>
            <span>瓷砖</span>
          </p>
        </div>
        <div class="con">
          <ul class="list">
            <li v-for="items in list" :key="items.index">
              <span class="classify">{{items.classify}}:</span>
              <span class="detail" v-for="item in items.detail" :key="item.index">{{item}}</span>
            </li>
            <li>
              <span class="classify">排序:</span>
              <span class="detail">默认</span>
              <span class="detail">上架时间</span>
              <span class="detail">销量排序</span>
              <span class="detail">价格</span>
              <input type="number" class="in" placeholder="￥请输入" /> -
              <input type="number" class="in" placeholder="￥请输入" />
              <div class="right">
                <span class="three"></span>
                <span class="line"></span>
                <span class="four"></span>
              </div>
            </li>
          </ul>
          <ul class="details">
            <li v-for="item in lists" :key="item.index">
              <img :src="item.img" alt="">
              <h3>{{item.subtitle}}</h3>
              <p>{{item.intr}}</p>
              <span>{{item.price}}元</span>
            </li>
          </ul>
        </div>
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
import Common from './common'
import Foot from './foot'
import build1 from '../assets/home/build/build1.png'
import build2 from '../assets/home/build/build2.png'
import build3 from '../assets/home/build/build3.png'
import build4 from '../assets/home/build/build4.png'
export default {
  name: 'shopping-list',
  data () {
    return {
      Show: false,
      list: [
        {
          classify: '瓷砖',
          detail: [
            '瓷抛砖', '木纹砖', '抛光砖', '仿古砖', '釉面砖', '瓷片', '马赛克瓷砖', '外墙砖', '抛晶砖', '微晶石',
            '背景墙', '广场砖', '泳池砖', '防潮砖', '瓷砖配件'
          ]
        },
        {
          classify: '品牌',
          detail: [
            '唐煌贵族', '华麟陶瓷', '鑫源', '艾一陶瓷线条', '翠陶', '惠尚', '澳威斯陶瓷', '大满贯', '伏牛', '新渔舟陶瓷',
            '龙爵陶瓷', '三莎陶瓷', '雅居嘉利奥'
          ]
        },
        {
          classify: '风格',
          detail: [
            '韩式', '现代', '中式', '地中海', '简约现代', '田园', '美式乡村', '北欧/宜家', '明清古典', '新古典', '东南亚', '欧式'
          ]
        },
        {
          classify: '尺寸',
          detail: [
            '600*600mm', '60*240mm', '150*800mm', '160*900mm', '800*800mm', '500*330mm', '300*300mm', '200*1000mm', '200*230mm'
          ]
        },
        {
          classify: '适用范围',
          detail: [
            '餐厅', '厨房墙面', '阳台', '厨房地面', '泳池', '客厅墙面', '大堂', '客厅地面', '外墙面', '卧室墙面', '背景墙',
            '卧室地面', '浴室/卫生间', '墙面'
          ]
        }
      ],
      lists: [
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
          img: build1,
          subtitle: '大理石石材',
          intr: '钢琴烤漆简约百搭经典双层抽屉大容',
          price: '1999'
        },
        {
          img: build2,
          subtitle: '欧米硅藻泥',
          intr: '钢琴烤漆简约百搭经典双层抽屉大容',
          price: '1999'
        },
        {
          img: build3,
          subtitle: '人体探测器',
          intr: '钢琴烤漆简约百搭经典双层抽屉大容',
          price: '1999'
        },
        {
          img: build4,
          subtitle: '创意瓷砖',
          intr: '钢琴烤漆简约百搭经典双层抽屉大容',
          price: '1999'
        },
        {
          img: build1,
          subtitle: '大理石石材',
          intr: '钢琴烤漆简约百搭经典双层抽屉大容',
          price: '1999'
        },
        {
          img: build2,
          subtitle: '欧米硅藻泥',
          intr: '钢琴烤漆简约百搭经典双层抽屉大容',
          price: '1999'
        },
        {
          img: build3,
          subtitle: '人体探测器',
          intr: '钢琴烤漆简约百搭经典双层抽屉大容',
          price: '1999'
        },
        {
          img: build4,
          subtitle: '创意瓷砖',
          intr: '钢琴烤漆简约百搭经典双层抽屉大容',
          price: '1999'
        }
      ]
    }
  },
  methods: {
    showPanel () {
      this.Show = true
    },
    hidePanel () {
      this.Show = false
    }
  },
  components: {
    Common, Foot
  }
}
</script>

<style scoped>
  .black {
    width: 100%;
    height: 48px;
    background: #171717;
  }
  .nav {
    width: 1200px;
    height: 48px;
    margin: 0 auto;
    position: relative;
  }
  .rl {
    font-size: 14px;
    color: #ffffff;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
  }
  .rl span:nth-child(1):before {
    display: inline-block;
    content: '';
    width: 16px;
    height: 16px;
    margin-right: 16px;
    background: url("../assets/home/nav/lr.png");
  }
  .rl span:nth-child(1):after {
    width: 1px;
    height: 11px;
    background-color: #ffffff;
    display: inline-block;
    content: '';
    margin: 0 8px;
  }
  .topSearch {
    width: 1200px;
    height: 68px;
    margin: 24px auto 0;
    text-align: left;
    overflow: hidden;
  }
  .logo {
    width: 68px;
    height: 68px;
    display: inline-block;
    background: url("../assets/home/logo.png") no-repeat;
    float: left;
  }
  .left {
    width: 156px;
    font-size: 28px;
    letter-spacing: 1px;
    color: #3e3a39;
    font-weight: bold;
    margin: 8px 0 0 22px;
    float: left;
  }
  .left:after {
    width: 156px;
    height: 25px;
    content: '';
    display: block;
    margin-top: 8px;
    background: url("../assets/home/mall.png");
  }
  .mar {
    margin-top: 17px;
  }
  .search {
    width: 436px;
    height: 38px;
    margin-left: 101px;
    padding-left: 15px;
    border: solid 1px #d8d8d8;
    float: left;
  }
  .topSearch p {
    width: 88px;
    height: 42px;
    background-color: #d42f31;
    text-align: center;
    line-height: 42px;
    font-size: 16px;
    color: #ffffff;
    float: left;
  }
  .shop {
    width: 100px;
    height: 38px;
    border: solid 1px #d8d8d8;
    margin-left: 102px;
    line-height: 38px;
    text-align: center;
    float: left;
  }
  .shop span {
    font-size: 14px;
    color: #3a3a3a;
  }
  .shop span:before {
    width: 17px;
    height: 17px;
    display: inline-block;
    content: '';
    background: url("../assets/home/shopCar.png");
    margin-right: 9px;
    vertical-align: middle;
  }
  .commodity {
    width: 1200px;
    margin: 16px auto 0;
    text-align: left;
  }
  .all {
    /*position: relative;*/
  }
  .all p {
    width: 280px;
    height: 51px;
    background-color: #f3f3f3;
    /*box-shadow: 0 15px 29px 0 rgba(0, 0, 0, 0.1);*/
    font-size: 18px;
    color: #3e3a39;
    text-align: center;
    line-height: 51px;
    display: inline-block;
    cursor: pointer;
  }
  .all ul {
    margin-left: 32px;
    display: inline-block;
  }
  .all > ul li {
    display: inline-block;
    font-size: 16px;
    color: #3e3a39;
    margin-right: 49px;
  }
  .all ul li a {
    color: #3e3a39;
  }
  .background {
    padding: 32px 0 84px;
    background-color: #f5f5f5;
    margin-bottom: 53px;
  }
  .contents {
    width: 1200px;
    margin: 0 auto;
    text-align: left;
  }
  .li {
    font-size: 14px;
    color: #5b5b5b;
    border-left: 2px solid #d42f31;
    padding-left: 4px;
  }
  .li span:after {
    width: 5px;
    height: 12px;
    background: url("../assets/home/arrow.png") no-repeat;
    display: inline-block;
    content: '';
    margin: 0 8px;
    vertical-align: middle;
  }
  .li span:last-child {
    color: #d42f31;
  }
  .li span:last-child:after {
    width: 0;
    display: inline-block;
    content: '';
  }
  .con {
    width: 1130px;
    margin: 23px auto 0;
    padding: 41px 35px 56px;
    background-color: #ffffff;
  }
  .list li {
    width: 100%;
    display: inline-block;
    padding: 25px 0;
    border-bottom: 1px dashed #dcdddd;
    text-align: left;
    overflow: hidden;
  }
  .list li:last-child {
    border-bottom: 1px solid #dcdddd;
  }
  .list li span {
    font-size: 14px;
    display: inline-block;
  }
  .classify {
    color: #9fa0a0;
    margin-right: 19px;
  }
  .detail {
    color: #000000;
    margin-right: 27px;
  }
  .in {
    width: 65px;
    height: 24px;
    border: solid 1px #c9caca;
    display: inline-block;
  }
  .in::-webkit-input-placeholder{
    font-size: 10px;
    color: #c9caca;
  }
  .right {
    line-height: 24px;
    margin-right: 12px;
    float: right;
  }
  .three {
    width: 14px;
    height: 14px;
    vertical-align: middle;
    background: url("../assets/shoppingList/threeLine.png");
  }
  .line {
    width: 1px;
    height: 15px;
    background: #dcdddd;
    display: inline-block;
    margin: 0 7px;
    vertical-align: middle;
  }
  .four {
    width: 14px;
    height: 14px;
    vertical-align: middle;
    background: url("../assets/shoppingList/fourPoint.png");
  }
  .details {
    width: 100%;
    margin-top: 35px;
  }
  .details li {
    width: 331px;
    height: 422px;
    background-color: #f9f9f9;
    display: inline-block;
    margin-bottom: 26px;
    transition-duration: .5s;
    transform:translateY(1px);
  }
  .details li:hover {
    background-color: #fff;
    transition-duration: 0.5s;
    transform: translateY(-1px);
    box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.1);
  }
  .details li:nth-child(1),
  .details li:nth-child(2),
  .details li:nth-child(4),
  .details li:nth-child(5),
  .details li:nth-child(7),
  .details li:nth-child(8),
  .details li:nth-child(10),
  .details li:nth-child(11) {
    margin-right: 39px;
  }
  .details li img {
    height: 197px;
    margin: 52px auto 33px;
  }
  .details h3 {
    font-size: 18px;
    color: #3e3a39;
  }
  .details p {
    font-size: 14px;
    color: #595757;
    margin: 13px 0 22px;
  }
  .details span {
    font-size: 16px;
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
