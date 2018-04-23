<template>
  <div class="container">
    <h1>计划铺设展厅点</h1>
    <p>全面覆盖，全新体验，展厅全天浏览</p>
    <div class="middle">
      <div class="left">
        <div class="map">
          <div class="expect">
            敬请期待...
            <span></span>
            <span></span>
            <span></span>
            <span></span>
          </div>
          <ul class="address">
            <li v-for="(item, index) in city" :key="index">{{item.title}}</li>
          </ul>
        </div>
      </div>
      <div class="right">
        <div id="map" @click="show">
          <img src="../assets/images/map.png" alt="">
        </div>
      </div>
      <div class="build" v-show="isShow">
        <div class="content">
          <h3>建设中，敬请期待...</h3>
          <p>留下您的联系方式，我们会第一时间通知到您</p>
        </div>
        <form action="" class="sub">
          <p class="mobile">
            <input type="text" placeholder="请输入您的手机号">
            <input type="submit" class="btn" value="提交">
          </p>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Chinamap',
  data () {
    return {
      china: [],
      isShow: false,
      city: [
        {
          title: '青岛站'
        },
        {
          title: '|'
        },
        {
          title: '北京站'
        },
        {
          title: '|'
        },
        {
          title: '上海站'
        },
        {
          title: '深圳站'
        },
        {
          title: '|'
        },
        {
          title: '广州站'
        },
        {
          title: '|'
        },
        {
          title: '杭州站'
        },
        {
          title: '成都站'
        },
        {
          title: '|'
        },
        {
          title: '南京站'
        },
        {
          title: '|'
        },
        {
          title: '苏州站'
        },
        {
          title: '武汉站'
        },
        {
          title: '|'
        },
        {
          title: '长沙站'
        },
        {
          title: '|'
        },
        {
          title: '福州站'
        },
        {
          title: '厦门站'
        },
        {
          title: '|'
        },
        {
          title: '银川站'
        },
        {
          title: '|'
        },
        {
          title: '西安站'
        },
        {
          title: '济南站'
        },
        {
          title: '|'
        },
        {
          title: '重庆站'
        },
        {
          title: '|'
        },
        {
          title: '东莞站'
        },
        {
          title: '郑州站'
        },
        {
          title: '|'
        },
        {
          title: '湛江站'
        },
        {
          title: '|'
        }
      ]
    }
  },
  methods: {
    show () {
      this.isShow = !this.isShow
    }
  }
}
</script>
<style scoped>
.container {
  position: relative;
  width: 100%;
  margin-bottom: 124px;
}
.container h1 {
  font-size: 40px;
  color: #595757;
  margin-bottom: 12px;
}
.container p {
  color: #595757;
  font-size: 20px;
  margin-bottom: 53px;
}
.middle {
  display: flex;
  width: 1200px;
  justify-content: space-around;
  margin: 0 auto;
}
.left {
  width: 177px;
  margin-left: 165px;
  margin-top: 150px;
}
.expect {
  position: relative;
  width: 177px;
  height: 40px;
  border: 1px solid #464646;
  line-height: 40px;
  margin-bottom: 16px;
}
.expect span:nth-child(1) {
  position: absolute;
  left: -2px;
  top: -2px;
  padding: 0.52vw;
  border-style: solid;
  border-color: #464646;
  border-width: 4px 0 0 4px;
}
.expect span:nth-child(3) {
  position: absolute;
  right: -2px;
  bottom: -2px;
  padding: 10px;
  border-style: solid;
  border-color: #464646;
  border-width: 0 4px 4px 0;
}
.address {
  display: flex;
  flex-wrap: wrap;
  width: 160px;
  line-height: 25px;
  justify-content: flex-start;
  font-size: 14px;
  margin-left: 13px;
}
.address li {
  margin: 0 2px;
}
.right {
  display: flex;
  justify-content: flex-end;
  position: relative;
}
.build {
  width: 337px;
  height: 171px;
  position: absolute;
  top: 25%;
  right: 25%;
  background-color: #ffffff;
  box-shadow: 0px 6px 28px 0px rgba(0, 0, 0, 0.15);
}
.content h3 {
  padding-top: 27px;
  font-size: 18px;
  line-height: 24px;
  color: #111111;
  margin-bottom: 7px;
}
.content p {
  font-size: 10px;
  color: #111111;
  margin-bottom: 23px;
}
.mobile {
  display: flex;
  justify-content: center;
}
.sub {
  font-size: 0;
  vertical-align: middle;
}
.sub input {
  width: 200px;
  height: 26px;
  background-color: #ffffff;
  border: solid 1px #bfbfbf;
  box-sizing: border-box;
  padding-left: 10px;
}
.sub .btn {
  width: 46px;
  height: 26px;
  color: #fff;
  cursor: pointer;
  outline: none;
  border: none;
  background-color: #d42f31;
}
.content:after{
  content: "";
  width: 0;
  height: 0;
  position: absolute;
  left: 50%;
  top: 100%;
  margin-left: -19px;
  border-right: solid 21px transparent;
  border-top: solid 21px white;
  border-left: solid 21px transparent;
}
</style>
