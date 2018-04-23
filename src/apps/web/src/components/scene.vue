<template>
  <div class="scene">
    <div class="mid">
      <div class="title">
        <h2>智能系统，支持自定义场景</h2>
        <p>综合生活规律、活动路线、特殊需求、打造个性化生活场景</p>
      </div>
      <div class="scene-img">
        <ul>
          <li v-for="(image, index) in modelImg" :key="index" v-show=" index == num">
            <img :src="image.img" alt="">
          </li>
        </ul>
      </div>
      <div class="line">
      </div>
      <div class="scene-model">
        <ul class="scene-list">
          <li class="room">全屋智能布置</li>
          <li class="usual">常用场景模式</li>
          <li v-for="(item, index) in modelImg" :key="index" class="several" :class="{active:index == num}"  @click="tab(index)">
            <h4>{{item.model}}</h4>
            <span>{{item.leave}}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
import sceneImg from '../assets/scheme/per.png'
import Img from '../assets/scheme/pexels.png'
export default {
  name: 'scene',
  data () {
    return {
      num: 1,
      modelImg: [
        {
          img: sceneImg,
          model: '起夜模式',
          leave: '有人经过，灯光自动打开，再也不用摸黑开灯'
        },
        {
          img: Img,
          model: '离家模式',
          leave: '有人经过，灯光自动打开，再也不用摸黑开灯'
        },
        {
          img: sceneImg,
          model: '离家模式',
          leave: '有人经过，灯光自动打开，再也不用摸黑开灯'
        },
        {
          img: Img,
          model: '离家模式',
          leave: '有人经过，灯光自动打开，再也不用摸黑开灯'
        },
        {
          img: sceneImg,
          model: '离家模式',
          leave: '有人经过，灯光自动打开，再也不用摸黑开灯'
        },
        {
          img: Img,
          model: '起夜模式',
          leave: '有人经过，灯光自动打开，再也不用摸黑开灯'
        },
        {
          img: sceneImg,
          model: '起夜模式',
          leave: '有人经过，灯光自动打开，再也不用摸黑开灯'
        },
        {
          img: Img,
          model: '起夜模式',
          leave: '有人经过，灯光自动打开，再也不用摸黑开灯'
        },
        {
          img: sceneImg,
          model: '起夜模式',
          leave: '有人经过，灯光自动打开，再也不用摸黑开灯'
        }
      ]
    }
  },
  methods: {
    tab (index) {
      this.num = index
    }
  }
}
</script>
<style scoped>
.scene {
  color: #fff;
  background-color: #383838;
}
.mid {
  width: 1200px;
  height: 940px;
  margin: 0 auto;
}
.title {
  padding-top: 92px;
  margin-bottom: 95px;
}
.title h2 {
  font-size: 36px;
  margin-bottom: 18px;
}
.title p {
  color: #cccccc;
  font-size: 18px;
}
.scene-img {
  float: left;
}
.scene-img img {
  width: 785px;
	height: 492px;
}
.scene-model {
  float: right;
}
.scene-list {
  text-align: left;
}
.room, .usual {
  width: 339px;
	height: 49px;
  box-sizing: border-box;
  padding-left: 25px;
  line-height: 49px;
  background-color: #1d1e20;
}
.room {
  margin-bottom: 2px;
}
.usual {
	background-color: #333333;
}
.several {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding-left: 25px;
  height: 56px;
  box-sizing: border-box;
  width: 339px;
  cursor: pointer;
}
.several.active:before {
  content: ' ';
  position: absolute;
  width: 0;
  height: 0;
  left: -78px;
  top: 15px;
  border: 14px solid;
  transition: .5s;
  border-color: transparent #9a9795 transparent transparent;
}
.several.active {
  background: #1d1e20;
  box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.2);
}
.several h4 {
  padding-top: 10px;
}
.several span {
  color: #999999;
  font-size: 14px;
  margin-bottom: 10px;
}
.line {
  width: 1px;
	height: 621px;
  float: left;
  margin-left: 26px;
	background-color: #9a9795;
}
</style>
