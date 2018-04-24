<template>
  <div>
    <Head></Head>
    <img src="../assets/example/banner.png" alt="" class="banner">
    <div class="classify">
      <select name="style" class="style" id="style">
        <option value="">风格分类</option>
        <option value="index" v-for='(item, index) in style' :key='index'>{{item}}</option>
      </select>
      <select name="room" class="style" id="room">
        <option value="">房型分类</option>
        <option value="index" v-for='(item, index) in room' :key='index'>{{item}}</option>
      </select>
    </div>
    <ul class="content">
      <li v-for="(items, index) in img" :key=index>
        <router-link :to="{ name: 'example-detail', query: { caseId: items.case_id }}">
          <img :src="items.case_cover_lg" alt="">
          <div class="con">
            <p class="title">{{items.case_title}}-{{items.type}}</p>
            <!-- <p class="intr">{{item.intr}}</p> -->
          </div>
        </router-link>
      </li>
    </ul>
    <Foot></Foot>
  </div>
</template>
<script>
import Head from './head-nav'
import Foot from './footNav'
// import example1 from '../assets/example/example1.png'
// import example2 from '../assets/example/example2.png'
// import example3 from '../assets/example/example3.png'
// import example4 from '../assets/example/example4.png'
// import example5 from '../assets/example/example5.png'
// import example6 from '../assets/example/example6.png'
export default {
  name: 'example',
  data () {
    return {
      rows: {},
      img: [
        // {
        //   imgUrl: example1,
        //   name: 'example-detail',
        //   title: '汤臣一品-简约-三居室',
        //   intr: '摈弃一切的复杂，回归到一片简介之中，设计实景白色作为整个空间的主色回归到一片简洁之中。'
        // },
        // {
        //   imgUrl: example2,
        //   name: 'example-detail',
        //   title: '汤臣一品-简约-三居室',
        //   intr: '摈弃一切的复杂，回归到一片简介之中，设计实景白色作为整个空间的主色回归到一片简洁之中。'
        // },
        // {
        //   imgUrl: example3,
        //   name: 'example-detail',
        //   title: '汤臣一品-简约-三居室',
        //   intr: '摈弃一切的复杂，回归到一片简介之中，设计实景白色作为整个空间的主色回归到一片简洁之中。'
        // },
        // {
        //   imgUrl: example4,
        //   name: 'example-detail',
        //   title: '汤臣一品-简约-三居室',
        //   intr: '摈弃一切的复杂，回归到一片简介之中，设计实景白色作为整个空间的主色回归到一片简洁之中。'
        // },
        // {
        //   imgUrl: example5,
        //   name: 'example-detail',
        //   title: '汤臣一品-简约-三居室',
        //   intr: '摈弃一切的复杂，回归到一片简介之中，设计实景白色作为整个空间的主色回归到一片简洁之中。'
        // },
        // {
        //   imgUrl: example6,
        //   name: 'example-detail',
        //   title: '汤臣一品-简约-三居室',
        //   intr: '摈弃一切的复杂，回归到一片简介之中，设计实景白色作为整个空间的主色回归到一片简洁之中。'
        // }
      ],
      style: [
        '全部',
        '现代简约',
        '新中式',
        '后现代',
        '地中海',
        '美式田园',
        '古典欧式'
      ],
      room: [
        '全部',
        '别墅',
        '标准房型'
      ]
    }
  },
  components: {
    Head, Foot
  },
  methods: {
    getImg: function () {
      this.$http.post('public/case/index', {}).then(d => {
        // console.log('gather=========', d.data)
        if (d.code === 0) {
          for (let i = 0; i < d.data.length; i++) {
            this.img = this.img.concat(d.data[i].list)
          }
        } else {
        }
      })
    }
  },
  created () {
    this.getImg()
  }
}
</script>
<style scoped>
.banner {
  width: 100%;
  margin: 88px auto 0;
}
.content {
  width: 93.6%;
  margin: 30px auto 0;
}
.content li {
  width: 100%;
  /* height: 584px; */
  background-color: #ffffff;
  box-shadow: 0 15px 60px 0 rgba(0, 0, 0, 0.1);
  margin-bottom: 50px;
  padding-bottom: 46px;
}
.content li img {
  width: 100%;
}
.con {
  width: 92.4%;
  text-align: left;
  margin: 25px auto 0;
}
.title {
  font-size: 36px;
  color: #000000;
  margin: 25px 0 22px;
}
.intr {
  font-size: 24px;
  line-height: 36px;
  letter-spacing: 1px;
  color: #727171;
}
classify {
  text-align: center;
}
.style {
  width: 49.8%;
  height: 100px;
  font-size: 30px;
  color: #595757;
  border-bottom: solid 1px #d8d8d8;
  border-left: 0;
  display: inline-block;
}
option {
  font-size: 15px;
}
#room {
  border-right: 0;
  margin-left: -6px;
}
</style>
<style>
* {
  max-height: 100%;
}
</style>
