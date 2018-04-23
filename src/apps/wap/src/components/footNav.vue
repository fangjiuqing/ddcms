<template>
  <div class="foot">
    <div class="content">
      <ul class="list">
        <li>关于我们</li>
        <li>联系我们</li>
        <li>
          <router-link :to="{name: 'join-us'}" exact>
              加入我们
            </router-link>
        </li>
        <li>意见反馈</li>
      </ul>
      <p class="copy">
        Copyright ®2018 小管家智能芯片科技（上海）有限公司 版权所有沪ICP备15007819号-1
      </p>
    </div>
  </div>
</template>
<script>
export default {
  name: 'foot'
}
</script>
<style scoped>
.content {
  height: 75px;
  background-color: #181818;
  padding-top: 23px;
}
.foot {
  height: 98px;
}
.list {
  color: #fff;
  font-size: 24px;
  margin-bottom: 14px;
  text-align: center
}
.list li {
  display: inline-block;
}
.list li:nth-child(1),
.list li:nth-child(2),
.list li:nth-child(3) {
  margin-right: 34px;
}
.copy {
  font-size: 14px;
  color: rgba(181, 181, 182, 0.5);
  text-align: center;
}
</style>
