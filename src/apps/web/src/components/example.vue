<template>
	<div class="index">
      <div class="title">
        <div class="line"></div>
        <span>首页</span>
        <img src="../assets/images/arrow.png">
        <a href="javascript:;">预约体验</a>
      </div>
      <ul class="list">
        <li v-for="(item, index) in imgs" :key="index" @mouseenter="show(item)" @mouseleave="show(item)">
          <img :src="item.imgUrl">
          <transition name="fade">
            <div class="tasking" v-show="item.isShow">
              <div>
                <p>{{item.home}}</p>
                <span>热销：{{item.craze}}</span>
                <i>收藏：{{item.collect}}</i>
              </div>
            </div>
          </transition>
        </li>
      </ul>
  </div>
</template>
<script type="text/javascript">
import img1 from '../assets/images/entity1.png'
import img2 from '../assets/images/entity2.png'
import img3 from '../assets/images/entity3.png'
import img4 from '../assets/images/entity4.png'
export default {
  name: 'example',
  data () {
    return {
      imgs: [
        {
          imgUrl: img1,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img2,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img3,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img4,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img3,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img4,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img1,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        },
        {
          imgUrl: img2,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        }
      ]
    }
  },
  methods: {
    show (item) {
      item.isShow = !item.isShow
    }
  }
}
</script>
<style type="text/css" scoped>
.tasking {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  font-size: 0.72vw;
  background: #000;
  opacity: 0.8;
}
.tasking p {
  color: #fff;
  position: absolute;
  top: 50%;
  left: 50%;
  font-size: 1vw;
  border-top: 2px solid #fff;
  border-bottom: 2px solid #fff;
  padding: 9px 0;
  transform: translate(-50%, -50%);
  z-index: 10;
}
.tasking span {
  position: absolute;
  color: #fff;
  top: 60%;
  left: 40%;
  transform: translate(-50%, -50%);
}
.tasking i {
  position: absolute;
  color: #fff;
  top: 60%;
  left: 60%;
  transform: translate(-50%, -50%);
}
.index {
  width: 1191px;
  margin: 48px auto 0;
  margin-bottom: 64px;
}
.title {
  display: flex;
  font-size: 18px;
  text-align: left;
  margin: 48px 0;
}
.line {
  width: 2px;
  height: 17px;
  margin-right: 4px;
  background-color: #d42f31;
}
.title img {
  margin: 0 6px;
}
.title a {
  font-size: 18px;
  text-decoration: none;
  color: #d42f31;
}
.list {
  margin: 0 0 18px 10px;
  overflow: hidden;
}
.list li {
  float: left;
  position: relative;
}
.list li:nth-child(3),
.list li:nth-child(6),
.list li:nth-child(7),
.list li:nth-child(8){
  float: right;
}
.list li:nth-child(1),
.list li:nth-child(2),
.list li:nth-child(7),
.list li:nth-child(8) {
  width: 347px;
  height: 291px;
}
.list li:nth-child(2) {
  margin: 0 18px 18px;
}
.list li:nth-child(3),
.list li:nth-child(5){
  width: 451px;
  height: 620px;
}
.list li:nth-child(5){
  margin-right: 15px;
}
.list li:nth-child(4) {
  margin: 0 19px 18px 0;
}
.list li:nth-child(4),
.list li:nth-child(6){
  width: 710px;
  height: 310px;
}
.list li:nth-child(6){
  margin-bottom: 19px;
}
.list li:nth-child(8) {
  margin-right: 20px;
}
.list img {
  width: 100%;
}

.fade-enter-active, .fade-leave-active {
  transition: all 0.5s ease;
}

.fade-enter, .fade-leave-active{
  opacity: 0;
}
</style>
