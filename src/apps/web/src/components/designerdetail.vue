<template>
  <div class="designer">
    <Head></Head>
    <div class="banner">
      <div class="tasking">
        <div class="middle">
          <div class="designer-img">
            <div class="recommend">
              <img :src="row.des_cover_sm" alt="">
            </div>
            <div class="honor">
              <h2>{{row.des_name}}</h2>
              <!--<img src="../assets/designer/ename.png" alt="">-->
              <div class="lin"></div>
              <p>{{row.des_concept_tags}}</p>
              <!--<p class="room">计范畴以及东西文化的交融中，感受和谐的魅力。</p>-->
              <p>擅长风格：<span>{{stages}}</span></p>
              <p class="idea">服务范围：<span>{{row.des_slogan}}</span></p>
              <div v-for="(item, index) in awards" :key="index" class="ownhonor">
                <span>{{item}}</span>
              </div>
              <p class="quick">立即预约</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="chief">
      <div class="middle">
        <ul class="list">
          <li>
            <h4>{{row.des_title}}</h4>
            <span>职位</span>
          </li>
          <div class="line"></div>
          <li>
            <h4>{{row.province}}</h4>
            <span>所在地</span>
          </li>
          <div class="line"></div>
          <li>
            <h4>{{len}}</h4>
            <span>奖项</span>
          </li>
          <div class="line"></div>
          <li>
            <h4>{{row.des_workyears}}</h4>
            <span>工作年限</span>
          </li>
        </ul>
      </div>
    </div>
    <div class="deputy">
      <div class="middle">
        <div class="symbol">
          <span>代表作品</span>
          <i>REPRESENTATIVE</i>
          <b> work</b>
          <div class="across"></div>
          <p v-html="row.case_content"></p>
          <!--<ul class="project">-->
            <!--<li>-->
              <!--<p>项目名称：<span>W•House</span></p>-->
            <!--</li>-->
            <!--<li>-->
              <!--<p>项目性质：<span>别墅</span></p>-->
            <!--</li>-->
            <!--<li>-->
              <!--<p>项目地点：<span>扬州</span></p>-->
            <!--</li>-->
            <!--<li>-->
              <!--<p>设计面积：<span>420㎡</span></p>-->
            <!--</li>-->
            <!--<li>-->
              <!--<p>创意总监：<span>韩松言</span></p>-->
            <!--</li>-->
            <!--<li>-->
              <!--<p>主设计师：<span>刘子聿</span></p>-->
            <!--</li>-->
          <!--</ul>-->
          <!--<p class="detail-own">空间设计要有气场、要有气势、并且要有温度！这样的情怀才能有内在魅力！ &#45;&#45;&#45;&#45;韩松言</p>-->
          <!--<p class="detail">在这套作品中可以感受到时尚与艺术的交相呼应！韩松言对色彩和材料有着天生的敏感，其设计哲学亦强调用特殊的质感表现永恒的空间价值，并将其称之为‘惊喜’客厅使用定制的天蓝色织物沙发与皮纹高背椅以及皮毛懒人沙发相围合，餐厅铸铝餐椅、和蜂窝状吊灯相搭配，成功演绎出时尚华丽的空间氛围。地面树脂艺术漆与缤纷多彩的地毯与墙面的蜂窝状瓷砖相辅相成，表现了独有的‘奢华心绪’</p>-->
          <ul class="img-list">
            <li v-for="(item, index) in imgs" :key="index">
              <img :src="item.lg" alt="">
            </li>
          </ul>
        </div>
      </div>
    </div>
    <Foot></Foot>
    <sideBar></sideBar>
  </div>
</template>
<script>
import Head from './head'
import Foot from './foot'
import sideBar from './sidebar'
import $ from 'jquery'
export default {
  name: 'designerDetail',
  metaInfo () {
    const title = '设计师详情 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      row: {},
      stages: '',
      awards: [],
      len: '',
      id: this.$route.query.designerId || 0,
      imgs: []
    }
  },
  methods: {
    getImg: function () {
      this.$http.post('public/designer/get', {
        id: this.id
      }).then(d => {
        console.log('designerDetail=========', d)
        if (d.code === 0) {
          $.extend(this.row, d.data.row)
          this.stages = d.data.stags.join('、')
          this.awards = this.awards.concat(d.data.awards)
          if (d.data.case_images) {
            this.imgs = this.imgs.concat(d.data.case_images)
          }
          if (d.data.awards) {
            this.len = d.data.awards.length
          } else {
            this.len = 0
          }
        } else {
        }
      })
    }
  },
  created () {
    this.getImg()
  },
  mounted () {
    // console.log('this.$route.query.caseId=====', this.$route.query.caseId)
  },
  components: {
    Head, Foot, sideBar
  }
}
</script>
<style scoped>
.banner {
  height: 640px;
  margin: 71px auto 0;
  background: url(../assets/designer/whiteb.png) center/cover no-repeat;
}
.tasking {
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
}
.middle {
  width: 1200px;
  height: 100%;
  display: flex;
  margin: 0 auto;
}
.designer-img {
  width: 1000px;
  margin: 0 auto;
  display: flex;
}
.recommend {
  display: flex;
  align-items: center;
  margin-right: 80px;
}
.recommend img {
  width: 305px;
}
.honor {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  color: #fff;
}
.honor h2 {
  font-size: 24px;
  margin-bottom: 6px;
  padding-top: 5px;
}
.lin {
  width: 100%;
  height: 1px;
  background-color: #fff;
  margin: 15px 0;
}
.honor img {
  margin-bottom: 14px;
}
.honor p {
  line-height: 16px;
  font-size: 12px;
}
p.quick {
  width: 150px;
  height: 40px;
  font-size: 18px;
  color: #d42f31;
  border-radius: 20px;
  border: solid 1px #d42f31;
  line-height: 40px;
  text-align: center;
  margin-top: 30px;
  cursor: pointer;
}
.room {
  margin-bottom: 21px;
}
.honor span {
  color: #cccccc;
}
.idea {
  margin-bottom: 29px;
}
.ownhonor {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}
.ownhonor span {
  font-size: 14px;
  line-height: 24px;
}
.chief {
  width: 100%;
  height: 100px;
  background-color: #fafafa;
}
.list {
  padding: 0 100px;
  display: flex;
  align-items: center;
}
.list li {
  display: flex;
  width: 249px;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.list li h4 {
  font-size: 24px;
  margin-bottom: 15px;
}
.list li span {
  color: #727171;
  font-size: 18px;
}
.line {
  width: 1px;
  height: 30px;
  background-color: rgba(142, 140, 140, 0.5);
}
.deputy {
  padding-top: 49px;
}
.symbol {
  text-align: left;
}
.symbol i {
  color: #000000;
  font-weight: 600;
}
.symbol span {
  font-size: 24px;
  line-height: 24px;
  letter-spacing: 1px;
  color: #000000;
}
.symbol b {
  color: #666;
}
.across {
  margin: 21px 0 24px 0;
  width: 1000px;
  height: 1px;
  background-color: #cdcdcd;
}
.project p {
  line-height: 30px;
  color: #000000;
}
.project span {
  color: #595757;
  font-size: 16px;
}
.detail-own {
  padding-top: 10px;
}
.detail {
  margin-bottom: 24px;
}
.detail,
.detail-own {
  line-height: 30px;
  font-size: 14px;
  text-align: justify;
  color: #727171;
}
.img-list, .project-img {
  font-size: 0;
}
.img-list li {
  margin-bottom: 24px;
}
.project-img {
  font-size: 0;
}
.project-img li:nth-child(2) {
  margin-bottom: 32px;
}
.project-img li:nth-child(1) {
  margin-bottom: 24px;
}
.project-line {
  width: 1000px;
  height: 1px;
  background-color: #cdcdcd;
  margin: 3px 0 24px 0;
}
</style>
<style>
  .symbol p p {
    line-height: 30px;
  }
  .symbol p p:last-child {
    margin-bottom: 24px;
  }
  .symbol p p:nth-child(9),
  .symbol p p:nth-child(10),
  .symbol p p:nth-child(11) {
    font-size: 14px;
    color: #727171;
  }
  .symbol p p:nth-child(1),
  .symbol p p:nth-child(2),
  .symbol p p:nth-child(3),
  .symbol p p:nth-child(4),
  .symbol p p:nth-child(5),
  .symbol p p:nth-child(6) {
    font-size: 16px;
    color: #000000;
  }
</style>
