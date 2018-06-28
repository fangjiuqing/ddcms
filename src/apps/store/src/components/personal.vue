<template>
  <div class="personal">
    <topHead></topHead>
    <div class="background">
      <div class="contents">
        <p class="li">
          <span>首页</span>
          <span>个人中心</span>
        </p>
      </div>
    </div>
    <div class="yself">
      <div class="self-left">
        <div class="self">
          <i class="actor">
            <img src="../assets/personal/yonghu.png" alt="">
          </i>
          <p>18234401221</p>
        </div>
        <div class="menu">
          <ul class="order-menu">
            <li v-for="(v, index) in menus" :key="index" :class="{checked:index === nowIndex}" v-on:click="relationClick(index)">
              <a href="###">{{v}}</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="con">
        <ul class="right-list">
          <li v-for="(v, g) in refund" :key="g" :class="{active:g === vIndex}" @click="relation(g)">
            <a href="###">{{v}}</a>
          </li>
        </ul>
        <div v-for="(item, index) in detail" :key="index" v-show="index == vIndex" v-if="detail !== {}">
          <div class="info-content">
            <table class="order-info">
              <thead>
                <tr class="status">
                  <th v-for="(v, gsk) in title" :key="gsk">
                    <p>{{v}}</p>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr class="order">
                  <td v-for="(v, gs) in status" :key="gs" class="order-time">
                    <span class="time">{{v.time}}</span>
                    <span>{{v.order}}</span>
                  </td>
                  <td colspan="5"></td>
                </tr>
                <tr class="d-content" v-for="(v, index) in item.dInfo" :key="index">
                  <td class="d-info">
                    <div>
                      <img :src="v.img" alt="">
                    </div>
                    <div class="d-name">
                      <p class="fname">{{v.fname}}</p>
                      <p class="tname">{{v.tname}}</p>
                    </div>
                  </td>
                  <td class="price">
                    <p>{{v.price}}</p>
                  </td>
                  <td class="num">
                    <p>{{v.num}}</p>
                  </td>
                  <td class="d-status">
                    <p>{{v.status}}</p>
                  </td>
                  <td class="total">
                    <p>{{v.total}}</p>
                  </td>
                  <td class="info">
                    <p v-tooltip.bottom-center="msg">{{v.info}}</p>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="true" v-for="(v, index) in sure" :key="index" v-show="index == vIndex">
              <button class="btn">{{v}}</button>
            </div>
          </div>
          <div class="info-content">
            <table class="order-info">
              <thead>
                <tr class="status">
                  <th v-for="(v, gsk) in title" :key="gsk">
                    <p>{{v}}</p>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr class="order">
                  <td v-for="(v, gs) in status" :key="gs" class="order-time">
                    <span class="time">{{v.time}}</span>
                    <span>{{v.order}}</span>
                  </td>
                  <td colspan="5"></td>
                </tr>
                <tr class="d-content" v-for="(v, index) in item.dInfo" :key="index">
                  <td class="d-info">
                    <div>
                      <img :src="v.img" alt="">
                    </div>
                    <div class="d-name">
                      <p class="fname">{{v.fname}}</p>
                      <p class="tname">{{v.tname}}</p>
                    </div>
                  </td>
                  <td class="price">
                    <p>{{v.price}}</p>
                  </td>
                  <td class="num">
                    <p>{{v.num}}</p>
                  </td>
                  <td class="d-status">
                    <p>{{v.status}}</p>
                  </td>
                  <td class="total">
                    <p>{{v.total}}</p>
                  </td>
                  <td class="info">
                    <p v-tooltip.top-center="msg">{{v.info}}</p>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="true" v-for="(v, index) in sure" :key="index" v-show="index == vIndex">
              <button class="btn">{{v}}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import topHead from './topHead'
import car from '../assets/personal/car.png'
import colok from '../assets/personal/colok.png'
import letter from '../assets/personal/letter.png'
import info from '../assets/personal/info.png'
import bottle from '../assets/personal/bottle.png'
import floor from '../assets/personal/floor.png'
export default {
  name: 'personal',
  components: {topHead},
  data () {
    return {
      msg: '快递已发出',
      nowIndex: 0,
      vIndex: 0,
      menus: ['我的订单', '我的收藏', '消息通知', '账号信息', '售后记录', '价格保护'],
      refund: ['待收货(0)', '待付款(0)', '已收货', '退款订单', '全部订单'],
      title: ['商品信息', '价格', '数量', '状态', '交易金额', '查看'],
      content: [
        {
          img: car,
          name: '购物车是空滴'
        },
        {
          img: bottle,
          name: '暂无收藏宝贝'
        },
        {
          img: info,
          name: '暂无消息通知'
        },
        {
          img: colok,
          name: '暂无收货信息'
        },
        {
          img: letter,
          name: '暂无订单信息'
        }
      ],
      status: [
        {
          time: '2018-06-06',
          order: '订单号码：123781851752785'
        }
      ],
      sure: ['确认收货', '立即付款', '立即查看'],
      detail: [
        {
          dInfo: [
            {
              img: floor,
              fname: '西班牙进口瓷砖ST肯帕卡特深灰色釉面地砖',
              tname: '安纳普尔那象牙釉面地砖',
              price: 5999.00,
              num: 2,
              status: '已发货'
            },
            {
              img: floor,
              fname: '西班牙进口瓷砖ST肯帕卡特深灰色釉面地砖',
              tname: '安纳普尔那象牙釉面地砖',
              price: 5999.00,
              num: 2,
              status: '已发货',
              total: 16888.00,
              info: '物流信息'
            },
            {
              img: floor,
              fname: '西班牙进口瓷砖ST肯帕卡特深灰色釉面地砖',
              tname: '安纳普尔那象牙釉面地砖',
              price: 5999.00,
              num: 2,
              status: '已发货'
            }
          ]
        },
        {
          dInfo: [
            {
              img: floor,
              fname: '西班牙进口瓷砖ST肯帕卡特深灰色釉面地砖',
              tname: '安纳普尔那象牙釉面地砖',
              price: 5999.00,
              num: 2,
              status: '待付款'
            },
            {
              img: floor,
              fname: '西班牙进口瓷砖ST肯帕卡特深灰色釉面地砖',
              tname: '安纳普尔那象牙釉面地砖',
              price: 5999.00,
              num: 2,
              status: '待付款',
              total: 16888.00,
              info: '等待买家付款'
            },
            {
              img: floor,
              fname: '西班牙进口瓷砖ST肯帕卡特深灰色釉面地砖',
              tname: '安纳普尔那象牙釉面地砖',
              price: 5999.00,
              num: 2,
              status: '待付款'
            }
          ]
        },
        {
          dInfo: [
            {
              img: floor,
              fname: '西班牙进口瓷砖ST肯帕卡特深灰色釉面地砖',
              tname: '安纳普尔那象牙釉面地砖',
              price: 5999.00,
              num: 3,
              status: '完成交易'
            },
            {
              img: floor,
              fname: '西班牙进口瓷砖ST肯帕卡特深灰色釉面地砖',
              tname: '安纳普尔那象牙釉面地砖',
              price: 5999.00,
              num: 3,
              status: '完成交易',
              total: 16888.00,
              info: '物流信息'
            },
            {
              img: floor,
              fname: '西班牙进口瓷砖ST肯帕卡特深灰色釉面地砖',
              tname: '安纳普尔那象牙釉面地砖',
              price: 5999.00,
              num: 3,
              status: '完成交易'
            }
          ]
        }
        // {
        //   img: letter,
        //   name: '暂无订单信息'
        // }
      ]
    }
  },
  methods: {
    relationClick: function (index) {
      this.nowIndex = index
    },
    relation (i) {
      this.vIndex = i
    },
    getInfo () {}
  }
}
</script>
<style scoped>
@import '../css/tooltip.css';
  .background {
    background-color: #fff;
    margin: 33px 0 22px;
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
  .yself {
    width: 1200px;
    height: 700px;
    margin: 0 auto;
  }
  .self-left {
    float: left;
  }
  .self {
    width: 196px;
    height: 167px;
    box-sizing: border-box;
    margin-bottom: 10px;
    border: solid 1px #e4e4e4;
  }
  .yself .actor {
    display: inline-block;
    text-align: center;
    width: 58px;
    height: 58px;
    line-height: 58px;
    background-color: #f3f3f3;
    border-radius: 50%;
    margin: 32px 0 15px;
  }
  .actor img {
    display: inline-block;
    vertical-align: middle;
  }
  .self p {
    color: #595757;
    font-size: 14px;
  }
  .menu {
    width: 196px;
    height: 493px;
    box-sizing: border-box;
    border: solid 1px #e4e4e4;
  }
  .order-menu a{
    color: #595757;
    font-size: 14px;
  }
  .order-menu li {
    margin-bottom: 36px;
  }
  .order-menu li:nth-child(1) {
    padding-top: 39px;
  }
  .checked a {
    color: #d42f31;
  }
  .checked a:before {
    content: "";
    width: 6px;
    height: 6px;
    display: inline-block;
    text-align: center;
    text-decoration: none;
    vertical-align: middle;
    border-radius: 50%;
    background-color: #d42f31;
  }
  .con {
    width: 981px;
    float: right;
  }
  .right-list {
    height: 18px;
    margin-bottom: 44px;
  }
  .right-list li {
    float: left;
    margin-right: 86px;
  }
  .right-list li a {
    color: #000000;
  }
  .right-list .active a {
    padding: 0 0 15px 0;
    border-bottom: 1px solid#d42f31;
  }
  .right-list li:nth-child(1) {
    margin-left: 42px;
  }
  .status {
    width: 981px;
    height: 48px;
    line-height: 48px;
    background-color: #f3f3f3;
  }
  .status p {
    text-align: center;
    width: 100%;
  }
  .status th:nth-child(1) {
    padding: 0 138px 0 156px;
  }
  .status th:nth-child(2) {
    padding: 0 32px 0 28px;
  }
  .status th:nth-child(3) {
    padding: 0 40px 0 36px;
    text-align: center;
  }
  .status th:nth-child(4) {
    padding: 0 48px 0 38px;
    text-align: center;
  }
  .status th:nth-child(5) {
    padding: 0 45px;
    text-align: center;
  }
  .status th:nth-child(6) {
    padding: 0 59px 0 53px;
    text-align: center;
  }
  .order {
    border: solid 1px #e4e4e4;
  }
  .order-time {
    text-align: let;
    font-size: 14px;
    padding: 24px 0;
  }
  .d-content {
    border: solid 1px #e4e4e4;
    box-sizing: border-box;
  }
  .info, .total {
    border-left: solid 1px #e4e4e4;
  }
  .time {
    padding: 0 44px 0 36px;
  }
  .detail {
    display: flex;
    flex-direction: column;
  }
  .d-info {
    display: flex;
  }
  .d-name {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
  }
  .d-info img {
    padding: 14px 20px 16px 26px;
  }
  .fname {
    width: 189px;
    font-size: 14px;
    line-height: 24px;
    text-align: left;
    padding: 49px 0 10px;
    color: rgba(0, 0, 0, 0.78);
  }
  .tname {
    font-size: 14px;
    line-height: 23px;
    color: rgba(139, 139, 139, 0.7);
    align-self: flex-start;
  }
  .price, .num, .d-status, .total, .info {
    vertical-align: middle;
  }
  .total p, .info p, .price p, .num p {
    text-align: center;
  }
  .d-status p {
    margin-left: -8px;
  }
  .order-info {
    border-collapse: collapse;
    margin-bottom: 17px;;
  }
  .btn {
    width: 120px;
    height: 36px;
    color: #fff;
    background-color: #d42f31;
    outline: none;
    border: none;
    float: right;
    cursor: pointer;
    margin-bottom: 36px;
  }
</style>
