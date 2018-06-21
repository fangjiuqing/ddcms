<template>
<div class="foot">
  <ul class="list">
    <li>关于我们</li>
    <li>联系我们</li>
    <li>
      <a>
        加入我们
      </a>
    </li>
    <li>意见反馈</li>
  </ul>
  <p class="line"></p>
  <p class="copy">Copyright ®2018 小管家智能芯片科技（上海）有限公司 版权所有沪ICP备15007819号-1</p>
</div>
</template>
<script>
export default {
  name: 'foot'
}
</script>
<style scoped>
  .foot {
    width: 100%;
    height: 159px;
    background-color: #333333;
    padding-top: 50px;
    box-sizing: border-box;
  }
  .list li {
    display: inline-block;
    font-size: 14px;
    color: #ffffff;
    margin-right: 26px;
  }
  .list li:last-child {
    margin-right: 0;
  }
  .line {
    width: 1193px;
    height: 1px;
    background-color: rgba(153, 153, 153, 0.2);
    opacity: 0.2;
    margin: 16px auto;
  }
  .copy {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.5);
  }
</style>
