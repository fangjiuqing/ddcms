<template>
  <div class="entity">
    <Head></Head>
    <div class="top">
      <img class="banner" src="../assets/superior/photo.png" alt="">
    </div>
    <div class="guarantee">
      <h3>智装工艺标准化</h3>
      <p class="subhead">专业装修，全面审核，明星工长任意挑选</p>
      <ul class="list">
        <li v-for="(item, index) in banners" :key="index">
          <!--<div class="show">-->
            <img :src="item.img" alt="" class="exhibition box1">
            <div class="into box1">
              <p class="title">{{item.title}}</p>
              <p class="intr">{{item.intr}}</p>
            </div>
          <!--</div>-->
        </li>
      </ul>
    </div>
    <div class="brand">
      <span class="choice">精选国内外一线品牌</span>
      <p class="choice env">20+合作商&nbsp;选材耐用环保</p>
      <p class="ddzz">道达智装拥有强大的供应链体系和严格的选材标准机制，所选用材以健康环保为基础标准，精选国内外一线品牌，给业主更好的品质保证</p>
      <img :src="brand" alt="" class="img">
      <img :src="parlour" alt="" class="img">
    </div>
    <foot></foot>
    <sideBar></sideBar>
  </div>
</template>
<script>
import Head from './head.vue'
import foot from './foot.vue'
import sideBar from './sidebar'
import tile from '../assets/superior/tile.png'
import floor from '../assets/superior/floor.png'
import bashroom from '../assets/superior/bashroom.png'
import kitchen from '../assets/superior/kitchen.png'
import brand from '../assets/superior/brand.png'
import parlour from '../assets/superior/parlour.png'
export default {
  name: 'superior',
  metaInfo () {
    const title = '国际优材 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      brand: brand,
      parlour: parlour,
      banners: [
        {
          title: '瓷砖质量标准',
          intr: 'ICOLOR选用的瓷砖(室内墙地面砖为釉面砖和通体砖)均高于国家、地方及行业标准，室内地砖表面必须具有优秀的防滑功能，室内墙面釉面每块瓷砖的平均相对工作尺寸的允许偏差' +
          '不得大于0.5%，厚度偏差控制在10%',
          img: tile
        },
        {
          title: '地板质量标准',
          intr: 'ICOLOR选用的瓷砖(室内墙地面砖为釉面砖和通体砖)均高于国家、地方及行业标准，室内地砖表面必须具有优秀的防滑功能，室内墙面釉面每块瓷砖的平均相对工作尺寸的允许偏差' +
          '不得大于0.5%，厚度偏差控制在10%',
          img: floor
        },
        {
          title: '卫浴质量标准',
          intr: 'ICOLOR选用的瓷砖(室内墙地面砖为釉面砖和通体砖)均高于国家、地方及行业标准，室内地砖表面必须具有优秀的防滑功能，室内墙面釉面每块瓷砖的平均相对工作尺寸的允许偏差' +
          '不得大于0.5%，厚度偏差控制在10%',
          img: bashroom
        },
        {
          title: '厨房电器质量标准',
          intr: 'ICOLOR选用的瓷砖(室内墙地面砖为釉面砖和通体砖)均高于国家、地方及行业标准，室内地砖表面必须具有优秀的防滑功能，室内墙面釉面每块瓷砖的平均相对工作尺寸的允许偏差' +
          '不得大于0.5%，厚度偏差控制在10%',
          img: kitchen
        }
      ]
    }
  },
  components: {
    Head, foot, sideBar
  }
}
</script>
<style scoped>
.top {
  text-align: center;
  position: relative;
}
.banner {
  width: 100%;
}
.top > p {
  position: absolute;
  font-size: 20px;
  color: #fff;
  line-height: 40px;
}

.guarantee {
  width: 100%;
  position: relative;
  margin-top: 76px;
}
h3 {
  font-size: 40px;
  color: #111;
  text-align: center;
  margin: 76px 0 15px 0;
}
.subhead {
  width: 100%;
  font-size: 16px;
  color: #595757;
  text-align: center;
}
.list {
  width: 1000px;
  margin: 78px auto 0;
  overflow: hidden;
}
.exhibition:hover {
  box-shadow:    0 15px 30px 0  rgba(0,0,0,0.1);
  /*-15px -30px 0 0  rgba(0,0,0,0.1),*/
  /*10px 30px 0 0  rgba(0,0,0,0.1),*/
  /*0 15px 30px 0  rgba(0,0,0,0.1);*/
  transition-duration: 1s;
}
.box1 {
  width: 487px;
  height: 331px;
  /*float: left;*/
  text-align: left;
}
.into {
  /*float: right;*/
}
.list li:nth-child(odd) img {
  float: left;
}
.list li:nth-child(odd) > div {
  float: right;
}
.list li:nth-child(even) img {
  float: right;
}
.list li:nth-child(even) > div {
  float: left;
  text-align: right;
}
.title {
  color: #111;
  font-size: 24px;
  margin-top: 57px;
}
.title:after {
  content: '';
  display: block;
  margin-top: 20px;
  width: 20%;
  height: 1px;
  background-color: #a6a6a6;
}
.list li:nth-child(even) .title:after {
  margin-left: 80%;
}
.list li:nth-child(odd) .title:after {
  height: 2px;
}
.intr {
  font-size: 16px;
  color: rgba(17,17,17,.8);
  line-height: 30px;
  margin-top: 50px;
}

.brand {
  position: relative;
  margin: 137px 0 104px;
}
.choice {
  width: 100%;
  font-size: 40px;
  font-weight: bold;
  color: #111;
}
.env {
  margin-top: 15px;
}
.ddzz {
  width: 50%;
  font-size: 20px;
  color: #111;
  font-weight: bold;
  line-height: 33px;
  margin: 49px auto 0;
}
.img {
  width: 1200px;
  margin-top: 111px;
}
/*@media screen and (min-width: 1280px) {*/
  /*.img {*/
    /*width: 67vw;*/
    /*margin-top: 111px;*/
  /*}*/
/*}*/
</style>
