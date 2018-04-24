<template>
  <div class="nav">
    <div class="logo">
      <img src="../assets/home/navLogo.png" alt="">
    </div>
    <div class="menu" @click="slideDown()">
      <span></span>
      <span class="mid"></span>
      <span></span>
    </div>
    <div class="wrapdown">
      <ul class="wrap" v-show="isShow">
        <li v-for="(item, index) in headerNav" :key="index">
          <router-link :to="{name:item.en}" exact>
            <span>{{item.title}}</span>
          </router-link>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  name: 'headNav',
  data () {
    return {
      isShow: false,
      headerNav: [
        {
          title: '首    页',
          en: 'home'
        },
        {
          title: '智装套餐',
          en: 'meal'
        },
        {
          title: '别墅定制',
          en: 'custom'
        },
        {
          title: '案例集锦',
          en: 'example'
        },
        {
          title: '设计名家',
          en: 'designer'
        },
        {
          title: '施工品质',
          en: 'work'
        },
        {
          title: '国际优材',
          en: 'material'
        },
        {
          title: '智装课堂',
          en: 'classroom'
        },
        {
          title: '金牌服务',
          en: 'serve'
        },
        {
          title: '实体网点',
          en: 'point'
        }
      ]
    }
  },
  methods: {
    slideDown () {
      this.isShow = !this.isShow
    }
  }
}
</script>
<style scoped>
.nav {
  width: 100%;
  height: 88px;
  position: fixed;
  background-color: #fff;
  top: 0;
  left: 0;
  z-index: 11;
  box-shadow: 0 3px 20px 0 rgba(0, 0, 0, 0.1);
}
.logo img {
  width: 120px;
  height: 120px;
  position: absolute;
  bottom: -22px;
  left: 72px;
}
.menu {
  display: flex;
  width: 35%;
  flex-direction: column;
  align-items: flex-end;
  position: absolute;
  right: 30px;
  top: 50%;
  transform: translateY(-50%);
}
.menu span {
  width: 37px;
  height: 5px;
  background-color: #333;
}
.menu .mid {
  height: 6px;
  margin: 6px 0;
}
.wrapdown {
  position: absolute;
  width: 100%;
  top: 88px;
  z-index: 666;
  display: flex;
  justify-content: center;
}
.wrap {
  width: 702px;
  height: 677px;
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: rgba(255, 255, 255, 0.95);
  box-shadow: 0px 9px 27px 0px rgba(0, 0, 0, 0.14);
  opacity: 0.95;
}
.wrap li {
  display: flex;
  align-items: center;
  letter-spacing: 1px;
  font-size: 30px;
  height: 78px;
  width: 100%;
}
.wrap a {
  font-size: 30px;
  text-decoration: none;
  color: #000;
  width: 100%;
}
.wrap a span {
  width: 100%;
  display: block;
  text-align: center;
}
a.router-link-active {
  /* padding-bottom: 7px; */
  color:  #d42f31;
}
</style>
