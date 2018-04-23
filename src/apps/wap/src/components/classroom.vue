<template>
  <div>
    <Head></Head>
    <img src="../assets/class/banner.png" alt="" class="banner">
    <div class="show">
      <div class="top">
        <h1>最新资讯</h1>
        <p>THE FASHION NEW</p>
      </div>
      <div class="bot">
        <img src="../assets/class/fashion.png" alt="" class="fashion">
        <div class="introduce">
          <span>THE UNTRUE TRUTH OF INTELLIGENT BLACK TECHNOLOGY</span>
          <h1>智能黑科技 不真实的真实</h1>
          <p class="process">2018年交房手续及流程大全</p>
          <p class="intr">交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。</p>
        </div>
      </div>
    </div>
    <div class="allInformation">
      <h1>全部资讯</h1>
      <ul class="experience">
        <li v-for="(item, index) in detail" :key="index" class="ex">
          <router-link :to="{ name: 'class-detail', params: { id: item.article_id }}">
            <div class="design-ex">
              <img :src="item.article_cover_thumb" alt="">
              <div class="trait">
                <div class="tra">
                  <div class="ename">
                    <span class="dname">{{item.article_title}}</span>
                    <div class="cover">
                      <p class="little">{{item.article_admin_nick}}</p>
                      <span class="line"></span>
                      <span class="time">{{item.article_udate}}</span>
                    </div>
                    <p class="procedure" v-html="item.article_content"></p>
                  </div>
                </div>
              </div>
            </div>
          </router-link>
        </li>
      </ul>
    </div>
    <Foot></Foot>
  </div>
</template>
<script>
import Head from './head-nav'
import Foot from './footNav'
// import all1 from '../assets/class/all1.png'
// import all2 from '../assets/class/all2.png'
// import all3 from '../assets/class/all3.png'
// import all4 from '../assets/class/all4.png'
export default {
  name: 'classroom',
  data () {
    return {
      detail: [
        // {
        //   url: all1,
        //   name: 'class-detail',
        //   dname: '智能黑科技 不真实的真实',
        //   nick: '小管家',
        //   time: '2018-04-02 09:26 ',
        //   procedure: '交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。'
        // },
        // {
        //   url: all2,
        //   name: 'class-detail',
        //   dname: '碳歌发泡陶瓷保温墙板',
        //   nick: '小管家',
        //   time: '2018-04-02 09:26 ',
        //   procedure: '交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。'
        // },
        // {
        //   url: all3,
        //   name: 'class-detail',
        //   dname: '智能黑科技 不真实的真实',
        //   nick: '小管家',
        //   time: '2018-04-02 09:26 ',
        //   procedure: '交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。'
        // },
        // {
        //   url: all4,
        //   name: 'class-detail',
        //   dname: '智能黑科技 不真实的真实',
        //   nick: '小管家',
        //   time: '2018-04-02 09:26 ',
        //   procedure: '交房手续及流程有哪些?在现在房价如此之高的情况下，能买起房子真的算赢家。其实买房子不仅是一件大事，也是一件复杂的事情。不光挑选房子比较难，挑选之后的各项流程也是很复杂的，所以还是要了解好才行。'
        // }
      ]
    }
  },
  created () {
    this.getImg()
  },
  methods: {
    date (time) {
      let date = new Date(time)
      let str = date.getFullYear() + '-' +
        (date.getMonth() + 1) + '-' +
        date.getDate() + ' ' +
        date.getHours() + ':' +
        date.getMinutes() + ':' +
        date.getSeconds()
      return str
    },
    getImg: function () {
      this.$http.post('public/article/index', {}).then(d => {
        // console.log('ddd=========', d)
        if (d.code === 0) {
          for (let i = 0; i < d.data.list.length; i++) {
            let time = new Date(Number(d.data.list[i].article_udate))
            let a = this.date(time)
            this.detail.push(d.data.list[i])
            this.detail[i].article_udate = a
          }
        } else {
        }
      })
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
  margin-top: 88px;
}
.show {
  width: 93.6%;
  background-color: #ffffff;
  box-shadow: 0 15px 60px 0 rgba(0, 0, 0, 0.1);
  margin: 56px auto 0;
  position: relative;
  padding : 83px 0 42px;
}
.top {
  position: absolute;
  left: 17px;
  top: -18px;
}
.top h1 {
  font-size: 36px;
  letter-spacing: 1px;
  color: #5b5b5b;
}
.top p {
  font-size: 20px;
  color: #5b5b5b;
  margin: 8px 0 0 63px;
}
.bot {
  width: 92.6%;
  margin: 0 3.7%;
}
.fashion {
  width: 100%;
}
.introduce {
  margin-top: 29px;
}
.introduce span {
  font-size: 14px;
  color: #5b5b5b;
}
.introduce h1 {
  font-size: 30px;
  color: #5b5b5b;
  margin-top: 8px;
}
.process {
  font-size: 24px;
  color: #5b5b5b;
  margin: 21px 0 28px;
}
.intr {
  font-size: 24px;
  line-height: 36px;
  color: rgba(91, 91, 91, 0.7);
}
.allInformation {
  position: relative;
  margin-top: 70px;
}
.allInformation h1 {
  font-family: MicrosoftYaHei Bold;
  font-size: 30px;
  color: #5b5b5b;
  text-align: center;
}
.allInformation h1:after {
  content: '';
  display: inline-block;
  width: 180px;
  height: 27px;
  margin-left: 8px;
  background: url("../assets/class/new.png") no-repeat center;
  vertical-align: middle;
}
.experience {
  width: 93.6%;
  margin: 52px auto 0;
}
.experience .ex {
  position: relative;
  margin-bottom: 30px;
  box-shadow: 0 10px 30px 0 rgba(0, 0, 0, 0.2);
}
.design-ex {
  display: flex;
  justify-content: flex-start;
  padding: 20px 0 19px;
  overflow: hidden;
}
.design-ex img {
  width: 234px;
  margin-left: 27px;
  float: left;
}
.trait {
  width: 100%;
  margin: 0 20px;
  float: left;
}
.tra {
  position: relative;
  top: 50%;
  transform: translateY(-50%);
}
.ename {
  text-align: left;
  overflow: hidden;
}
.trait .dname {
  font-size: 36px;
  color: #333333;
}
.cover {
  height: 32px;
  line-height: 32px;
  margin-top: 9px;
  overflow: hidden;
}
.little {
  float: left;
  font-size: 18px;
  color: #595757;
}
.line {
  width: 1px;
  height: 8px;
  background-color: #716f6e;
  margin: 11px 6px 0;
  float: left;
}
.time {
  font-size: 18px;
  color: #595757;
  float: left;
}
.procedure {
  font-size: 20px;
  float: left;
  line-height: 34px;
  margin-top: 12px;
  color: rgba(91, 91, 91, 0.7);
}
</style>
<style>
  .procedure p {
    display: none;
  }
  .procedure p:first-child {
    display: block;
    overflow:hidden;
    text-overflow:ellipsis;
    display:-webkit-box;
    -webkit-box-orient:vertical;
    -webkit-line-clamp:3;
  }
</style>
