<template>
  <div class="classDetail">
    <Head></Head>
    <div class="cont">
      <h1>{{form.article_title}}</h1>
      <div class="cover">
        <p class="little">{{form.article_admin_name}}</p><span class="line"></span><span class="time">{{form.article_udate|time('yyyy-mm-dd HH:MM')}}</span>
        <span class="line"></span>
        <p class="readNum">阅读量：{{form.article_stat_view}}</p>
        <div class="right">
          <span class="collect">收藏</span>
          <span class="share">分享</span>
        </div>
      </div>
      <p class="intr in" v-html="form.article_content"></p>
      <!--<p class="intr">碳歌发泡陶瓷保温板生产原料中工业固废比例达到80%。一期工程每年消耗废陶瓷、陶瓷废渣、矿山尾矿2万吨以上，真正实现了建筑陶瓷生产上的循环利用，顺应了国家产业政策。对工业污染综合治理做出卓越贡献。</p>-->
      <!--<img :src="article_cover" alt="" class="img1">-->
      <!--<p class="intr">碳歌轻质陶党隔场板质量轻其容重仅400-430kg/m",80mm厚墙板的重量为32 35kg/m2,仅为120mm器体加两面抹灰墙体重量的1/5-1/7.如果一建筑物从基础结构设计上就开始考虑使用轻质墙板，可大大减少结构和基础造价而且优化梁柱结构室内整体布局更趋合理更提高使用功能。再加上增大使用面积施工快等优点其经济收益优越。</p>-->
      <!--<p class="intr">按国家建筑隔墙条板的规范用碳歌装饰一体墙板80mm和100mm的板分别可代替传统的120mm和180mm厚的砖墙。80mm厚的碳歌装饰一体复合墙板与120mm的砖墙加抹灰后的厚度160mm相比足足少了80mm，显而易见，使用碳取装饰一体增板系统，建造12M场体可增加1平方使用面积，使用率增加3-5%，所增加实用面积价值高于墙板造价所以破歌装饰一体墙板非常适合于商铺及住宅办公的隔墙。</p>-->
      <!--<img src="../assets/classDetail/img2.png" alt="" class="img2">-->
      <!--<p class="intr">碳歌轻质陶党隔场板质量轻其容重仅400-430kg/m",80mm厚墙板的重量为32 35kg/m2,仅为120mm器体加两面抹灰墙体重量的1/5-1/7.如果一建筑物从基础结构设计上就开始考虑使用轻质墙板，可大大减少结构和基础造价而且优化梁柱结构室内整体布局更趋合理更提高使用功能。再加上增大使用面积施工快等优点其经济收益优越。</p>-->
      <!--<p class="intr">按国家建筑隔墙条板的规范用碳歌装饰一体墙板80mm和100mm的板分别可代替传统的120mm和180mm厚的砖墙。80mm厚的碳歌装饰一体复合墙板与120mm的砖墙加抹灰后的厚度160mm相比足足少了80mm，显而易见，使用碳取装饰一体增板系统，建造12M场体可增加1平方使用面积，使用率增加3-5%，所增加实用面积价值高于墙板造价所以破歌装饰一体墙板非常适合于商铺及住宅办公的隔墙。</p>-->
      <!--<img src="../assets/classDetail/img3.png" alt="" class="img3">-->
      <!--<p class="intr">碳歌发泡陶瓷保温板生产原料中工业固废比例达到80%。一期工程每年消耗废陶瓷、陶瓷废渣、矿山尾矿2万吨以上，真正实现了建筑陶瓷生产上的循环利用，顺应了国家产业政策。对工业污染综合治理做出卓越贡献。</p>-->
      <div class="bottom">
        <p class="left lr">上一篇：发泡陶瓷保温板应用</p>
        <p class="rig lr">下一篇：未来城市如何建？</p>
      </div>
    </div>
    <foot></foot>
    <sideBar></sideBar>
  </div>
</template>

<script>
import Head from './head'
import Foot from './foot.vue'
import sideBar from './sidebar'
export default {
  name: 'class-detail',
  metaInfo () {
    const title = '资讯详情 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      id: this.$route.query.classId || 0,
      form: {},
      article_cover: ''
    }
  },
  created () {
    this.gets()
  },
  mounted () {
    // console.log('params===========', this.$route.params)
  },
  methods: {
    gets () {
      this.$http.post('public/article/get', {
        id: this.id
      }).then(d => {
        // console.log('classDetail==========', d.data.row)
        if (d.code === 0) {
          this.form = this.id ? d.data.row : {}
          this.article_cover = d.data.row.article_cover_thumb
        } else {
          this.form = {}
        }
      })
    }
  },
  components: {
    Head, Foot, sideBar
  }
}
</script>

<style scoped>
.cont {
  width: 900px;
  margin: 102px auto 0;
}
  h1 {
    font-size: 30px;
    letter-spacing: 1px;
    color: #3e3a39;
    text-align: left;
  }
.cover {
  height: 32px;
  line-height: 32px;
  margin-top: 28px;
  overflow: hidden;
}
.little {
  float: left;
  font-size: 12px;
  color: #595757;
}
.little:before {
  width: 32px;
  height: 32px;
  content: '';
  display: inline-block;
  background: url("../assets/class/little2.png") no-repeat;
  background-size: 32px;
  margin-right: 8px;
  vertical-align: middle;
}
.line {
  width: 1px;
  height: 8px;
  background-color: #716f6e;
  margin: 11px 6px 0;
  float: left;
}
.time {
  font-size: 12px;
  color: #595757;
  float: left;
}
.readNum {
  font-size: 12px;
  color: #595757;
  float: left;
}
  .right {
    float: right;
    font-size: 12px;
    color: #595757;
  }
.collect {
  border-right: 1px solid #8e8c8c;
  padding-right: 8px;
}
  .collect:before,
  .share:before {
    width: 12px;
    height: 11px;
    margin: 0 5px;
    content: '';
    display: inline-block;
    vertical-align: middle;
  }
.collect:before {
  background: url("../assets/classDetail/collect.png") no-repeat;
  background-size: 12px 11px;
}
.share:before {
  background: url("../assets/classDetail/share.png") no-repeat;
  background-size: 12px 11px;
}
  .intr {
    font-size: 14px;
    line-height: 36px;
    color: #3e3a39;
    text-align: left;
  }
.in {
  margin-top: 56px;
}
  .img1 {
    width: 900px;
    height: 667px;
    margin: 30px 0;
  }
  .img2 {
    width: 719px;
    height: 319px;
    margin: 30px 0;
  }
  .img3 {
    width: 900px;
    height: 535px;
    margin: 30px 0;
  }
  .bottom {
    margin: 42px 0 62px;
    overflow: hidden;
  }
  .lr {
    font-size: 14px;
    line-height: 36px;
    color: #3e3a39;
    cursor: pointer;
  }
  .left {
    float: left;
  }
  .rig {
    float: right;
  }
</style>
<style>
  .cont img {
    max-width: 900px;
  }
  .intr p {
    text-indent:2em;
  }
  .intr p:nth-child(2) {
    text-indent:0;
  }
</style>
