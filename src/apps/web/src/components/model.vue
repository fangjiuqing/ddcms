<template>
  <div class="decoration">
    <div class="middle">
      <div class="content">
        <ul class="list">
          <li class="personality" v-for="(item, index) in glitzy" :key="index" :class="{active:index == num}" @click="tab(index)">
            <div class="title-bg">
              <h2>{{item.title}}</h2>
              <span>{{item.price}}</span>
            </div>
            <p class="shallow">{{item.content}}</p>
            <p class="deep">{{item.floor}}</p>
            <p class="shallow">{{item.kitchen}}</p>
            <p class="deep">{{item.stone}}</p>
            <p class="shallow">{{item.water}}</p>
            <p class="deep">{{item.bag}}</p>
            <p class="shallow">{{item.sky}}</p>
            <p class="deep">{{item.light}}</p>
            <p class="shallow">{{item.door}}</p>
          </li>
        </ul>
      </div>
      <div class="old">
        <p>旧房装修再加<span>269元</span>/ 平拆改服务费</p>
      </div>
      <div class="obtain">
        <button @click="showPanel">我要这样装 立即获取报价</button>
      </div>
      <div class="more">
        <a href="javscript:;">查看更多资料介绍</a>
        <a href="javscript:;"><img src="../assets/scheme/go.png" alt=""></a>
      </div>
    </div>
    <Price :panelShow.sync="panelShow"></Price>
    <Sidebar></Sidebar>
  </div>
</template>
<script>
import Price from './price'
import Sidebar from './sidebar'
export default {
  name: 'model',
  components: {
    Price, Sidebar
  },
  data () {
    return {
      panelShow: false,
      isShow: false,
      num: 1,
      glitzy: [
        {
          title: '个性化整装',
          price: '799元/平',
          content: '厨房地面防水',
          floor: '厨房地面水泥沙子',
          kitchen: '厨房地面300*300瓷砖',
          stone: '门槛石',
          water: '厨房墙面防水（反墙300mm）',
          bag: '砌体包管',
          sky: '厨房天花铝扣板吊顶'
        },
        {
          title: '拎包入住',
          price: '999元/平',
          content: '厨房地面防水',
          floor: '厨房地面水泥沙子',
          kitchen: '厨房地面300*300瓷砖',
          stone: '门槛石',
          water: '厨房墙面防水（反墙300mm）',
          bag: '砌体包管',
          sky: '厨房天花铝扣板吊顶',
          light: '厨房照明',
          door: '厨房单开门'
        },
        {
          title: '奢华整装',
          price: '1999元/平',
          content: '厨房地面防水',
          floor: '厨房地面水泥沙子',
          kitchen: '厨房地面300*300瓷砖',
          stone: '门槛石',
          water: '厨房墙面防水（反墙300mm）',
          bag: '砌体包管',
          sky: '厨房天花铝扣板吊顶',
          light: '厨房照明',
          door: '厨房单开门'
        }
      ]
    }
  },
  methods: {
    showPanel () {
      this.panelShow = true
    },
    tab (index) {
      this.num = index
    }
  }
}
</script>
<style scoped>
.decoration {
  position: relative;
  margin-bottom: 45px;
}
.middle {
  width: 1200px;
  margin: 0 auto;
}
.list {
  display: flex;
  justify-content: space-between;
}
.active h2 {
  color: #fff;
}
.personality {
  width: 310px;
  height: 730px;
	background-color: #ffffff;
  border-left: 10px solid #ffffff;
  border-right: 10px solid #ffffff;
  border-bottom: 10px solid #ffffff;
  cursor: pointer;
}
.personality h2 {
  font-size: 30px;
  line-height: 30px;
  padding-top: 49px;
  margin-bottom: 18px;
}
.personality span {
  color: #f2bd69;
}
.personality.active {
  border-left: 10px solid #593830;
  border-right: 10px solid #593830;
  border-bottom: 10px solid #593830;
  background-color: #593830;
}
.active .title-bg {
  border: 0;
  height: 146px;
}
.title-bg {
  border: solid 1px #ececec;
	height: 144px;
}
.list li p {
  width: 310px;
  height: 65px;
  line-height: 65px;
}
.shallow {
  background-color: #f7f7f7;
}
.deep {
  background-color: #efefef;
}
.old {
  display: flex;
  justify-content: flex-end;
  padding: 23px 0 55px 0;
  color: #333333;
  font-size: 14px;
}
.old span {
  color: #ee7700;
}
.obtain button {
  border: none;
  outline: none;
  font-size: 20px;
  color: #fff;
  padding: 14px 45px;
  background-color: #d42f31;
  margin-bottom: 27px;
  cursor: pointer;
}
.more {
  font-size: 0;
}
.more a{
  font-size: 16px;
  display: inline-block;
  text-decoration: none;
  vertical-align: middle;
  color: #513f36;
  margin-right: 13px;;
}
.more img {
  display: inline-block;
  vertical-align: middle;
}
</style>
