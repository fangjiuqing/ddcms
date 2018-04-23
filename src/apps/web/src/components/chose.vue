<template>
<div class="content">
  <div class="middle">
    <ul>
      <li>
        <img src="../assets/home/fs.png" height="53" width="53">
        <p class="detail">名师设计</p>
        <p class="det">知名大咖 倾力打造</p>
      </li>
      <li>
        <img src="../assets/home/house.png" height="53" width="53">
        <p class="detail">智能集成</p>
        <p class="det">多种场景 智能控制</p>
      </li>
      <li>
        <img src="../assets/home/hb.png" height="53" width="53">
        <p class="detail">生态建设</p>
        <p class="det">用材环保 价格优惠</p>
      </li>
      <li>
        <img src="../assets/home/pp.png" height="53" width="53">
        <p class="detail">精湛工艺</p>
        <p class="det">用匠心造匠品</p>
      </li>
      <li>
        <img src="../assets/home/time.png" height="53" width="53">
        <p class="detail">精准报价</p>
        <p class="det">系统报价 快速准确</p>
      </li>
    </ul>
  </div>
</div>
</template>
<script type="text/javascript">
export default {
  name: 'chose'
}
</script>
<style scoped>
  .content {
    background-color: #fff;
    margin-top: 21px;
    height: 110px;
    margin-bottom: 90px;
  }
  .middle {
    /*width: 1055px;*/
    margin: 0 auto;
  }
  .middle ul {
    width: 100%;
    /*height: 110px;*/
  }
  .middle ul li {
    display: inline-block;
    width: 14%;
    /*float: left;*/
  }
  .middle img {
    margin-bottom: 15px;
  }
  .detail {
    font-size: 18px;
    color: #000000;
    margin-bottom: 10px;
  }
  .det {
    height: 14px;
    font-size: 14px;
    color: #696969;
    text-align: center;
  }
</style>
