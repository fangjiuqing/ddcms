<template>
  <div class="pack">
    <ul class="list">
      <li class="personality" v-for="(item, index) in packa" :key="index">
        <div class="title-bg">
          <h2>{{item.title}}</h2>
          <span>{{item.price}}</span>
        </div>
        <p class="shallow">{{item.content}}</p>
        <p class="deep">{{item.floor}}</p>
        <p class="shallow">{{item.kitchen}}</p>
        <p class="deep">{{item.stone}}</p>
        <p class="shallow">{{item.water}}</p>
        <p class="deep">{{item.bag}}</p>
        <p class="shallow">{{item.sky}}</p>
        <p class="deep">{{item.light}}</p>
        <p class="shallow">{{item.door}}</p>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  name: 'pack',
  data () {
    return {
      packa: [
        {
          title: '个性化整装',
          price: '799元/平',
          content: '厨房地面防水',
          floor: '厨房地面水泥沙子',
          kitchen: '厨房地面300*300瓷砖',
          stone: '门槛石',
          water: '厨房墙面防水（反墙300mm）',
          bag: '砌体包管',
          sky: '厨房天花铝扣板吊顶'
        },
        {
          title: '拎包入住',
          price: '999元/平',
          content: '厨房地面防水',
          floor: '厨房地面水泥沙子',
          kitchen: '厨房地面300*300瓷砖',
          stone: '门槛石',
          water: '厨房墙面防水（反墙300mm）',
          bag: '砌体包管',
          sky: '厨房天花铝扣板吊顶',
          light: '厨房照明',
          door: '厨房单开门'
        },
        {
          title: '奢华整装',
          price: '1999元/平',
          content: '厨房地面防水',
          floor: '厨房地面水泥沙子',
          kitchen: '厨房地面300*300瓷砖',
          stone: '门槛石',
          water: '厨房墙面防水（反墙300mm）',
          bag: '砌体包管',
          sky: '厨房天花铝扣板吊顶',
          light: '厨房照明',
          door: '厨房单开门'
        }
      ]
    }
  }
}
</script>
<style scoped>
.pack {
  width: 750px;
  margin: 0 auto;
}
.list {
  display: flex;
  margin: 0 24px;
  overflow-x: auto;
}
.personality {
  display: felx;
  margin-right: 24px;
}
.title-bg {
  width: 310px;
  height: 154px;
  background-color: #ffffff;
  border: solid 1px #ececec;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.title-bg h2 {
  font-size: 30px;
  letter-spacing: 1px;
  color: #3e3a39;
  margin-bottom: 17px;
}
.title-bg {
  font-size: 16px;
  color: #f2bd69;
}
.shallow, .deep {
  width: 310px;
  height: 65px;
  display: flex;
  font-size: 18px;
  justify-content: center;
  align-items: center;
  background-color: #f7f7f7;
}
.deep {
  background-color: #efefef;
}
</style>
