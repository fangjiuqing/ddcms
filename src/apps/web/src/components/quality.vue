<template>
  <div class="cover">
    <h3>智慧整装，打造品质生活</h3>
    <p class="subhead">科技使生活更简单，智慧家庭解决方案使我们的核心竞争力</p>
    <ul class="list">
      <li v-for="(item, index) in banners" :key="index" class="villa">
        <img :src="item.imgUrl" alt="">
        <div class="custom">
          <div class="title">
            <h4>{{item.title}}</h4>
            <p>{{item.content}}</p>
            <div class="look">
              <router-link :to="{name:item.en}" class="detail">
                {{item.detail}}
                <i></i>
              </router-link>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
import img from '../assets/home/timg.png'
import timea from '../assets/home/timea.png'
import arrow from '../assets/home/arrow2.png'
export default {
  name: 'quality',
  data () {
    return {
      banners: [
        {
          imgUrl: img,
          title: '别墅豪宅定制',
          content: '道达智装拥有国际知名设计师团队，国内一流的施工工艺，领先的全屋智能集成技术，为您打造奢华的互联网家，并根据您的需求实现多场景联动',
          detail: '查看详情',
          en: 'case',
          arrow: arrow
        },
        {
          imgUrl: timea,
          title: '公寓套餐系列',
          content: '打造最具性价比的套餐系列，装修别墅的施工工艺来装点您的家，领先的全屋智能集成技术，为您打造奢华的互联网家,拥有国内领先的全屋智能集成技术，根据您的需求实现多场景联动',
          detail: '查看详情',
          en: 'scheme',
          arrow: arrow
        }
      ]
    }
  }
}
</script>
<style scoped>
.cover {
  width: 1200px;
  margin: 0 auto;
}
h3 {
  font-size: 40px;
  color: #333333;
  text-align: center;
  margin-bottom: 16px;
}
.subhead {
  font-size: 20px;
  color: #595757;
  text-align: center;
  margin-bottom: 77px;
}
.list {
  display: flex;
  font-size: 0;
  justify-content: space-between;
}
.villa {
  position: relative;
}
.custom {
  width: 462px;
  height: 226px;
  position: absolute;
  left: 68px;
  bottom: 54px;
  background-color: #ffffff;
  box-shadow: 0px 15px 30px 0px rgba(0, 0, 0, 0.1);
}
.title {
  height: 100%;
  box-sizing: border-box;
  padding: 29px 44px 35px 50px;
}
.title h4 {
  color: #333333;
  font-size: 24px;
  text-align: left;
  margin-bottom: 31px;
}
.title p {
  letter-spacing: 1px;
  color: #333333;
  line-height: 24px;
  font-size: 14px;
  text-align: justify;
  margin-bottom: 19px;
}
.detail {
  text-decoration: none;
  font-size: 12px;
  color: #000000;
}
.list li:nth-child(2) h4 {
  margin-bottom: 20px;
}
.list li:nth-child(2) p{
  margin-bottom: 6px;
}
.look {
  text-align: right;
}
.detail i {
  display: inline-block;
  width: 24px;
  height: 24px;
  margin-left: 6px;
  background: #d43031 url(../assets/home/arrow2.png) center/cover no-repeat;
  background-size: 21px 13px;
  vertical-align: middle;
}
</style>
