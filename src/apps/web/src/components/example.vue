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
      <div class="content">
      <ul class="left">
        <li v-for="(item, index) in img" :key="index" @mouseenter="show(item)" @mouseleave="show(item)">
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
      <ul class="menu">
        <li v-for="(item, index) in images" :key="index" @mouseenter="show(item)" @mouseleave="show(item)">
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
        }
      ],
      img: [
        {
          imgUrl: img3,
          isShow: false,
          home: '回归田园惬意美家',
          craze: 523,
          collect: 752
        }
      ],
      images: [
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
  width: 1200px;
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
  display: flex;
  flex-wrap: wrap;
  margin: 0 0 18px 10px;
}
.list li, .menu li, .left li {
  position: relative;
  cursor: pointer;
}
.list img {
  width: 100%;
  height: 100%;
}
.list li:nth-child(1) {
  height: 291px;
}
.list li:nth-child(2) {
  height: 291px;
  margin: 0 15px 0 16px;
}
.list li:nth-child(4) {
  margin-top: -312px;
}
.content {
  width: 100%;
  display: flex;
  margin-left: 10px;
}
.menu {
  display: flex;
  flex-wrap: wrap;
}
.menu li:nth-child(1) {
  margin: 0 0 17px 15px;
}
.left .tasking {
  height: 100%;
  position: absolute;
  top: 0;
}
.menu li:nth-child(2) {
  margin: 0 16px 0 15px;
}

.fade-enter-active, .fade-leave-active {
  transition: all 0.5s ease;
}

.fade-enter, .fade-leave-active{
  opacity: 0;
}
</style>
