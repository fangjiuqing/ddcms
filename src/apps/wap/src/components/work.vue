<template>
  <div>
    <Head></Head>
    <div class="banner">
      <h3>精湛工艺  承诺5年质保</h3>
      <p>道达智装服务团队具备行业内数十年的施工实践经验，</p>
      <p>根据中国建筑特性对施工工艺不断沉淀、创新，先后引入德系、日</p>
      <p>系等工艺体系，同时企业不断研发新型施工解决方案，为消费</p>
      <p class="word">者提供行业尖端装饰施工方案</p>
    </div>
    <ul class="list">
      <li v-for="(item, index) in books" :key="index">
        <span>{{item.title}}</span>
        <img :src="item.book" alt="">
      </li>
    </ul>
    <ul class="detail">
      <li v-for="(item, index) in details" :key="index">
        <div class="img">
          <img :src="item.imgUrl" alt="">
          <div class="detail-word">
            <h4>{{item.title}}</h4>
            <p>{{item.contento}}</p>
            <p>{{item.contentt}}</p>
            <p>{{item.contentc}}</p>
            <p>{{item.contentf}}</p>
            <p>{{item.contente}}</p>
            <p>{{item.contents}}</p>
          </div>
        </div>
      </li>
    </ul>
    <ul class="craft">
      <li v-for="(item, index) in craft" :key="index">
        <div class="left">
          <img :src="item.img" alt="">
        </div>
        <div class="right">
          <h4>{{item.title}}</h4>
          <p>{{item.content}}</p>
        </div>
      </li>
    </ul>
    <Foot></Foot>
  </div>
</template>
<script>
import Head from './head-nav'
import Foot from './footNav'
import Book from '../assets/work/book.png'
import Wall from '../assets/work/wall.png'
import Line from '../assets/work/line.png'
import Crown from '../assets/work/crown.png'
import Pipe from '../assets/work/pipe.png'
import Heal from '../assets/work/heal.png'
import Tile from '../assets/work/tile.png'
import Shower from '../assets/work/shower.png'
import Eagle from '../assets/work/eagle.png'
import Connect from '../assets/work/connect.png'
export default {
  name: 'work',
  metaInfo () {
    const title = '施工品质 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      books: [
        {
          title: '防潮防结霜',
          book: Book
        },
        {
          title: '吊顶防开裂',
          book: Book
        },
        {
          title: '地面防下沉',
          book: Book
        }
      ],
      details: [
        {
          imgUrl: Wall,
          title: '墙地面防水防霉处理',
          contento: `1、卫生间水管电线走顶面。`,
          contentt: `2、基层和墙壁的空鼓部分全部敲掉，清理四个墙面基层和地面并用水冲洗干净，然后待其干燥。`,
          contentc: `3、防水第一关，下水管四周和墙角四条边、地面四周也要用堵漏王分三次填孔隙，并且有间隔时间。这样，就给地面穿了一层刚性的防水盔甲。`,
          contentf: `4、弹性防水涂料做好第二关，先做墙面防潮，做到一米八以上。因为人洗澡会把水喷溅到墙面瓷砖上，瓷砖分子间隙大，水分子很轻松进入墙体，渗透到对面居室面，从而导致卫生间背面油漆脱落，墙纸发霉变色。墙面防潮做好再贴墙面砖，然后做地面装修防水。`
        },
        {
          imgUrl: Line,
          title: '强弱电布线工艺',
          contento: `1、强、弱电间距30公分，电线与网线、有线电视、电话线、音频线、视频线等弱电分管、分槽，至少保持30公分的间距，以免强电对弱电信号造成干扰。`,
          contentt: `2、布局要合理,尽量减少交叉走线，交叉处需用屏蔽管，线管内部的弱电线路具有良好的屏蔽效果，保障弱电信号不让干扰，电视图像稳定，电话无杂音，网速更快。`,
          contentc: `3、暗埋线管，线管的弯曲半径是线管直径的6-10倍，过弯圆滑，不得有破损。`
        },
        {
          imgUrl: Crown,
          title: '吊顶、隔墙工艺',
          contento: `1、轻钢龙骨双60结构、德系工艺、高镀锌量耐火性能优于同类轻钢龙骨材料。提高吊顶强度耐火极限，安全系数高。`,
          contentt: `2、取代传统的木质龙骨涂刷防腐材料的做法，使用寿命更长，不会出现木质材料受环境影响开裂、腐化造成安全隐患损失。`,
          contentc: `3、充分保障设计效果及性能的呈现，成就高性价比的品牌施工质量。`,
          contentf: `4、尺寸精度高、稳定性好。`,
          contente: `5、镀锌量大于120/m²，远高于GB/T11981-2008要求，提高防腐防锈能力。`,
          contents: `6、有效防止木龙骨在防火安全上的隐患，重量小，减少宅基面积沉重压力。`
        },
        {
          imgUrl: Pipe,
          title: '水管施工工艺',
          contento: `1、水路走顶，可以更加放心，如果出现渗漏，很容易发现及维修。热水管需包保温棉，防止冷凝水滴到吊顶上。冷热水管分槽排管，因为冷热水管的膨胀和收缩不同，同槽长期会松动，造成空鼓。`,
          contentt: `2、PPR水管热熔整体工艺，从颜色上把冷水管和热水管分开，有效避免热水温度过高对管道造成软化，且管道连接处采用热熔工艺使其成为一体，避免水管因水压过高造成漏水、漏气形成完全封闭环境，有效保障水质。`,
          contentc: `3、水路完工12小时后试压，试压压力是工作压力的1.5倍，过大可能损伤管道。`
        },
        {
          imgUrl: Heal,
          title: '收口工艺',
          contento: `1、一个工程的装修施工是否细致，很大程度也是取决于如何处理收边收口的问题，砖在阴角阳角收口时，通常采取45°角对拼的方式。这样不仅容易崩边、开裂，还存在一定的安全隐患。我们采用圆润的金属收边条不仅增强了装饰效果，也一并消除了这些问题。`,
          contentt: `2、墙面收边条的颜色丰富，装饰性与功能性兼备，`,
          contentc: `3、卫生间墙地砖的铺贴上，我们通常采取“墙压地”的做法，因为缝隙小，美观的同时防水效果也好。而收边条不仅兼备这些优点，也让空间品质感瞬间得以提升。`
        }
      ],
      craft: [
        {
          img: Tile,
          title: '瓷砖薄贴工艺',
          content: '选用新型瓷砖接剂批刮；镘刀齿形直线梳理，上下左右双向揉压；砖缝采用控制卡合理留置。'
        },
        {
          img: Shower,
          title: '淋浴房排水结构',
          content: '淋浴房的地面不出现积水的情况，水轻松的从凹槽结构中向四周排走，给予用户更为舒适的淋浴环境。'
        },
        {
          img: Eagle,
          title: '墙体保护鹰嘴安装',
          content: '避免使用或安装过程中损坏电线绝缘层，造成漏电隐患，同时便于导线的更换维修。'
        },
        {
          img: Connect,
          title: '接线端子的保护结构',
          content: '该保护结构使得电线接头结合紧密，安全稳定且不易松动，现场安装较为便捷，使用成本较低。'
        }
      ]
    }
  },
  components: {
    Head, Foot
  }
}
</script>
<style scoped>
.banner {
  width: 100%;
  height: 548px;
  padding-top: 88px;
  display: flex;
  position: relative;
  flex-direction: column;
  align-items: center;
  background: url('../assets/work/banner.png') center/cover no-repeat;
}
.banner h3 {
  font-size: 36px;
  color: #ffffff;
  padding-top: 50px;
  margin-bottom: 39px;
}
.banner p {
  font-size: 24px;
  line-height: 42px;
  color: rgba(255, 255, 255, 0.7);
}
.word {
  margin-bottom: 51px;
}
.list {
  width: 100%;
  display: flex;
  position: absolute;
  top: 412px;
  justify-content: space-around;
}
.list li{
  display: flex;
  flex-direction: column;
  align-items: center;
}
.list span {
  margin-bottom: 21px;
  color: #fff;
}
.list img {
  width: 219px;
  height: 307px;
}
.detail {
  width: 93.6%;
  max-height: 100%;
  padding-top: 160px;
  margin: 0 auto;
}
.detail li {
  box-shadow: 0 15px 60px 0 rgba(0, 0, 0, 0.1);
}
.img {
  margin: 0 24px 22px 24px;
}
.detail-word {
  padding: 0 24px;
}
.detail-word:last-child {
  padding-bottom: 33px;
}
.detail img{
  width: 100%;
}
.detail h4 {
  font-size: 30px;
  color: #333333;
  margin-bottom: 21px;
}
.detail p {
  font-size: 24px;
  line-height: 36px;
  text-align: justify;
  letter-spacing: 1px;
  color: #777777;
}
.craft {
  display: flex;
  flex-direction: column;
  max-height: 100%;
}
.craft li {
  margin: 0 24px;
  display: flex;
  margin-bottom: 22px;
  box-shadow: 0px 3px 18px 0px rgba(0, 0, 0, 0.15);
}
.left, .right {
  display: flex;
}
.left {
  width: 355px;
  height: 278px;
}
.left img {
  width: 355px;
  height: 262px;
  padding: 8px 0 8px 8px;
}
.right {
  width: 100%;
  margin: 0 26px;
  background-color: #ffffff;
  flex-direction: column;
}
.right h4 {
  font-size: 30px;
  padding: 37px 0 20px;
  color: #333333;
}
.right p {
  font-size: 24px;
  text-align: justify;
  line-height: 36px;
  letter-spacing: 1px;
  color: #666666;
  padding-bottom: 62px;
}
</style>
