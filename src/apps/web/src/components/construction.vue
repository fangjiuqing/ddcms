<template>
  <div class="construction">
    <Head></Head>
    <div class="promise">
      <div class="banner"></div>
      <!--<img class="banner" src="../assets/construction/banner.png" alt="">-->
      <span class="health">精湛工艺，承诺5年质保</span>
      <p class="experience">道达智装服务团队具备行业内数十年的施工实践经验，根据
        中国建筑特性对施工工艺不断沉淀、创新，先后引入德系、日系等工艺
        体系，同时企业不断研发新型施工解决方案，为消费者提供行业尖端装饰施工方案</p>
      <div class="certificate">
        <ul class="list">
          <li>
            <p>防潮防结霜</p>
            <img src="../assets/construction/banner2.png" alt="" class="patent">
          </li>
          <li>
            <p>吊顶防开裂</p>
            <img src="../assets/construction/banner2.png" alt="" class="patent">
          </li>
          <li>
            <p>地面防下沉</p>
            <img src="../assets/construction/banner2.png" alt="" class="patent">
          </li>
        </ul>
        <ul class="rule">
          <li>47条安全施工条例</li>
          <li>19条文明施工纪律</li>
          <li>28项现场保护规范</li>
          <li>50位雇佣项目经理</li>
          <li>376位整遍施工工匠</li>
        </ul>
      </div>
    </div>
    <ul class="show">
      <li class="floorWater" v-for="(items, index) in photo" :key="index">
        <div class="cover">
          <img :src="items.img" alt="" class="floor">
          <div class="water">
            <h1>{{items.title}}</h1>
            <ol class="order">
              <li v-for="(order, index) in items.order" :key="index">{{order}}</li>
            </ol>
            <img :src="imgL" alt="" class="fw" v-for="(imgL, index) in items.imgLitter" :key="index">
          </div>
        </div>
      </li>
    </ul>
    <div class="struct">
      <ul class="str">
        <li v-for="(item, index) in struct" :key="index">
          <img :src="item.img" alt="" class="img">
          <div class="con">
            <h3>{{item.title}}</h3>
            <p>{{item.content}}</p>
          </div>
        </li>
      </ul>
    </div>
    <foot></foot>
    <sideBar></sideBar>
  </div>
</template>
<script>
import Head from './head.vue'
import Foot from './foot.vue'
import sideBar from './sidebar'
import floorWater from '../assets/construction/floorWater.png'
import floor1 from '../assets/construction/floorWater1.png'
import electric from '../assets/construction/electric.png'
import electric1 from '../assets/construction/electric1.png'
import ceil from '../assets/construction/ceil.png'
import ceil1 from '../assets/construction/ceil1.png'
import waterPipe from '../assets/construction/waterPipe.png'
import waterPipe1 from '../assets/construction/waterPipe1.png'
import close from '../assets/construction/close.png'
import close1 from '../assets/construction/close1.png'
import gap from '../assets/construction/gap.png'
import awayWater from '../assets/construction/awayWater.png'
import olecranon from '../assets/construction/olecranon.png'
import wire from '../assets/construction/wire.png'
export default {
  name: 'construction',
  metaInfo () {
    const title = '施工品质 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      photo: [
        {
          img: floorWater,
          title: '墙面地面防水防霉处理',
          order: [
            '1、卫生间水管电线走顶面',
            '2、基层和墙壁的空鼓部分全部敲掉，清理四个墙面基层和地面，并用水冲洗干净，然后待其干燥',
            '3、防水第一关，下水管四周和墙角四条边、地面四周也要用堵漏王分三次填孔隙，并且有间隔时间。',
            '4、弹性防水涂料做好第二关，先做墙面防潮，做到一米八以上。'
          ],
          imgLitter: [
            floor1, floor1, floor1
          ]
        },
        {
          img: electric,
          title: '强弱电布线工艺',
          order: [
            '1、卫生间水管电线走顶面',
            '2、基层和墙壁的空鼓部分全部敲掉，清理四个墙面基层和地面，并用水冲洗干净，然后待其干燥',
            '3、防水第一关，下水管四周和墙角四条边、地面四周也要用堵漏王分三次填孔隙，并且有间隔时间。',
            '4、弹性防水涂料做好第二关，先做墙面防潮，做到一米八以上。'
          ],
          imgLitter: [
            electric1, electric1, electric1
          ]
        },
        {
          img: ceil,
          title: '吊顶、隔墙工艺',
          order: [
            '1、卫生间水管电线走顶面',
            '2、基层和墙壁的空鼓部分全部敲掉，清理四个墙面基层和地面，并用水冲洗干净，然后待其干燥',
            '3、防水第一关，下水管四周和墙角四条边、地面四周也要用堵漏王分三次填孔隙，并且有间隔时间。',
            '4、弹性防水涂料做好第二关，先做墙面防潮，做到一米八以上。'
          ],
          imgLitter: [
            ceil1, ceil1
          ]
        },
        {
          img: waterPipe,
          title: '水管施工工艺',
          order: [
            '1、卫生间水管电线走顶面',
            '2、基层和墙壁的空鼓部分全部敲掉，清理四个墙面基层和地面，并用水冲洗干净，然后待其干燥',
            '3、防水第一关，下水管四周和墙角四条边、地面四周也要用堵漏王分三次填孔隙，并且有间隔时间。',
            '4、弹性防水涂料做好第二关，先做墙面防潮，做到一米八以上。'
          ],
          imgLitter: [
            waterPipe1, waterPipe1
          ]
        },
        {
          img: close,
          title: '收口工艺',
          order: [
            '1、卫生间水管电线走顶面',
            '2、基层和墙壁的空鼓部分全部敲掉，清理四个墙面基层和地面，并用水冲洗干净，然后待其干燥',
            '3、防水第一关，下水管四周和墙角四条边、地面四周也要用堵漏王分三次填孔隙，并且有间隔时间。',
            '4、弹性防水涂料做好第二关，先做墙面防潮，做到一米八以上。'
          ],
          imgLitter: [
            close1, close1, close1, close1
          ]
        }
      ],
      struct: [
        {
          title: '瓷砖薄贴工艺',
          img: gap,
          content: '选用新型瓷砖接剂批刮；镘刀齿形直线梳理，上下左右双向揉压；'
        },
        {
          title: '淋浴房排水结构',
          img: awayWater,
          content: '选用新型瓷砖接剂批刮；镘刀齿形直线梳理，上下左右双向揉压；'
        },
        {
          title: '墙体保护鹰嘴安装',
          img: olecranon,
          content: '选用新型瓷砖接剂批刮；镘刀齿形直线梳理，上下左右双向揉压；'
        },
        {
          title: '接线端子的保护结构',
          img: wire,
          content: '选用新型瓷砖接剂批刮；镘刀齿形直线梳理，上下左右双向揉压；'
        }
      ]
    }
  },
  components: {
    Head, Foot, sideBar
  }
}
</script>
<style scoped>
  .promise {
    text-align: center;
    position: relative;
    margin-top: 71px;
  }
  .banner {
    height: 800px;
    background: url("../assets/construction/banner.png")  no-repeat center 0;
  }
  .health {
    font-size: 40px;
    color: #fff;
    font-weight: bold;
    position: absolute;
    top: 8%;
    left: 50%;
    transform: translateX(-50%);
  }
  .promise > p {
    position: absolute;
    font-size: 20px;
    color: #fff;
  }
  .experience {
    width: 862px;
    font-size: 16px;
    color: rgba(255, 255, 255, 0.7);
    top: 18%;
    left: 50%;
    transform: translateX(-50%);
    line-height: 29px;
  }
  .list {
    width: 862px;
    position: absolute;
    top: 33%;
    left: 50%;
    transform: translateX(-50%);
  }
  .list li {
    width: 240px;
    margin-left: 15px;
    display: inline-block;
  }
  .list p {
    color: #fff;
    font-size: 24px;
    margin-bottom: 21px;
  }
  .list li img {
    width: 240px;
    height: 335px;
  }
  .rule {
    position: absolute;
    bottom: 73px;
    left: 50%;
    transform: translateX(-50%);
    font-size: .8vw;
    color: rgba(255, 255, 255, 0.7);
  }
  .rule li {
    display: inline-block;
  }
  .rule li:before {
    content: '';
    display: inline-block;
    width: 15px;
    height: 15px;
    background: url("../assets/construction/right.png") no-repeat;
    background-size: 15px;
    vertical-align:middle;
    margin-right: 9px;
  }
  @media screen and (max-width: 1280px) {
    .patent {
      width: 240px!important;
      height: 335px!important;
    }
    .list {
      width: 862px!important;
    }
    .experience {
      width: 862px!important;
    }
    .rule {
      width: 862px!important;
    }
    .cover {
      width: 1068px!important;
    }
  }
  .show > li:nth-child(odd) {
    width: 100%;
    height: 946px;
    position: relative;
  }
  .show > li:nth-child(odd) > div {
    width: 1068px;
    height: 682px;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
  }
  .show > li:nth-child(odd) > div > img {
    width: 550px;
    height: 550px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 5;
  }
  .show > li:nth-child(odd) > div > div {
    width: 473px;
    height: 550px;
    background-color: #f6f6f6;
    padding-left: 77px;
    position: absolute;
    right: 0;
    bottom: 0;
    z-index: 4;
    overflow: hidden;
  }
  h1 {
    font-size: 24px;
    color: #333;
    font-weight: bold;
    margin-top: 30px;
    text-align: left;
  }
  .order {
    width: 74%;
    margin-top: 28px;
    font-size: 16px;
    color: #777;
    text-align: left;
  }
  .order li {
    line-height: 26px;
  }
  .fw {
    margin-right: 20px;
    float: left;
  }
  .show > li:nth-child(even) {
    width: 100%;
    height: 610px;
    position: relative;
    background-color: #f6f6f6;
  }
  .show > li:nth-child(even) > div {
    width: 1099px;
    height: 507px;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    margin: auto;
  }
  .show > li:nth-child(even) > div > img {
    width: 608px;
    height: 507px;
    position: absolute;
    top: 0;
    right: 0;
  }
  .show > li:nth-child(even) > div > div {
    width: 50%;
    height: 80%;
    position: absolute;
    left: 0;
    overflow: hidden;
  }
  .struct {
    width: 100%;
    height: 590px;
    background-color: #f6f6f6;
    position: relative;
  }
  .str {
    width: 1200px;
    height: 510px;
    position: absolute;
    left: 50%;
    top: 7.5%;
    transform: translateX(-50%);
  }
  .str li {
    width: 558px;
    margin: 12px;
    background-color: #fff;
    padding: 6px;
    display: inline-block;
  }
  .str li img {
    width: 283px;
    height: 209px;
    float: left;
  }
  .con {
    width: 225px;
    float: right;
    text-align: left;
    margin: 29px 0 0 21px;
  }
  .con h3 {
    font-size: 24px;
    color: #333;
  }
  .con p {
    font-size: 16px;
    color: #666;
    margin-top: 32px;
  }
</style>
