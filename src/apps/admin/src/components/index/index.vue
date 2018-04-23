<template>
    <div class="profile">
        <div class="app_page">
          <div class="app_content">
            <div class="content">
              <div class="row">
                <div class="ibox float-e-margins">
                  <div class="ibox-title">
                    <h5>
                      顾客统计
                      <span class="label label-danger">月度统计</span>
                      <span class="label label-default">总体统计</span>
                    </h5>
                  </div>
                  <div class="ibox-content">
                    <div class="col-sm-3">
                      总数  <b class="text-info">23233</b>
                    </div>
                    <div class="col-sm-3">
                      今日新增  <b class="text-success">63</b>
                    </div>
                    <div class="col-sm-3">
                      3日内新增  <b class="text-danger">421</b>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'Index',
  metaInfo: {
    title: '首页 - 道达智装'
  },
  data () {
    return {}
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
