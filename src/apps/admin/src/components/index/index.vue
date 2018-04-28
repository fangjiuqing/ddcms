<template>
    <div class="profile">
        <breadcrumbs :items="items">
          <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
            {{v.text}}
          </breadcrumb-item>
        </breadcrumbs>
        <div class="app_page">
          <div class="app_content">
            <div class="content">
              <div class="row">
                <div class="col-sm-6">
                  <div class="ibox float-e-margins">
                    <div class="ibox-title">
                      <h5>
                        <i class="fa fa-user-o"></i>
                        顾客统计
                        <!-- <span class="pull-right">
                          <span class="label label-info" @click="dataChange('customer','month')">月度统计</span>
                          <span class="label label-default" @click="dataChange('customer','whole')">总体统计</span>
                        </span> -->
                      </h5>
                    </div>
                    <div class="ibox-content">
                      <div class="col-sm-4">
                        总数  <b class="text-info">{{customerStatistic['total']}}</b>
                      </div>
                      <div class="col-sm-4">
                        今日新增  <b class="text-success">{{customerStatistic['today']}}</b>
                      </div>
                      <div class="col-sm-4">
                        三日内新增  <b class="text-danger">{{customerStatistic['3days']}}</b>
                      </div>
                      <div style="margin-bottom:20px;"></div>
                      <div class="col-sm-12">
                        <div id="customerChart" :style="{height: '300px'}"></div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="ibox float-e-margins">
                    <div class="ibox-title">
                      <h5>
                        <i class="fa fa-list"></i>
                        资讯统计
                      </h5>
                    </div>
                    <div class="ibox-content">
                      <div class="col-sm-4">
                        总数  <b class="text-info">{{newsStatistic['total']}}</b>
                      </div>
                      <div class="col-sm-4">
                        今日新增  <b class="text-success">{{newsStatistic['today']}}</b>
                      </div>
                      <div class="col-sm-4">
                        三日内新增  <b class="text-danger">{{newsStatistic['3days']}}</b>
                      </div>
                      <div style="margin-bottom:20px;"></div>
                      <div class="col-sm-12">
                        <div id="newsChart" :style="{height: '300px'}"></div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="ibox float-e-margins">
                    <div class="ibox-title">
                      <h5>
                        <i class="fa fa-plus"></i>
                        案例统计
                      </h5>
                    </div>
                    <div class="ibox-content">
                      <div class="col-sm-4">
                        总数  <b class="text-info">{{caseStatistic['total']}}</b>
                      </div>
                      <div class="col-sm-4">
                        今日新增  <b class="text-success">{{caseStatistic['today']}}</b>
                      </div>
                      <div class="col-sm-4">
                        三日内新增  <b class="text-danger">{{caseStatistic['3days']}}</b>
                      </div>
                      <div style="margin-bottom:20px;"></div>
                      <div class="col-sm-12">
                        <div id="caseChart" :style="{height: '300px'}"></div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="ibox float-e-margins">
                    <div class="ibox-title">
                      <h5>
                        <i class="fa fa-eye"></i>
                        浏览统计
                      </h5>
                    </div>
                    <div class="ibox-content">
                      <div class="col-sm-4">
                        总数  <b class="text-info">{{viewStatistic['total']}}</b>
                      </div>
                      <div class="col-sm-4">
                        今日新增  <b class="text-success">{{viewStatistic['today']}}</b>
                      </div>
                      <div class="col-sm-4">
                        三日内新增  <b class="text-danger">{{viewStatistic['3days']}}</b>
                      </div>
                      <div style="margin-bottom:20px;"></div>
                      <div class="col-sm-12">
                        <div id="viewChart" :style="{height: '300px'}"></div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>
    </div>
</template>

<script>
// 引入基本模板
let echarts = require('echarts/lib/echarts')
// 引入柱状图组件
require('echarts/lib/chart/bar')
require('echarts/lib/chart/line')
// 引入提示框和title组件
require('echarts/lib/component/tooltip')
require('echarts/lib/component/title')

export default {
  name: 'Index',
  metaInfo: {
    title: '首页 - 道达智装'
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '数据统计', href: '#'}
      ],
      customerStatistic: {},
      newsStatistic: {},
      caseStatistic: {},
      viewStatistic: {}
    }
  },
  methods: {
    getStatisticDate () {
      // 基于准备好的dom，初始化echarts实例
      let customerChart = echarts.init(document.getElementById('customerChart'))
      let newsChart = echarts.init(document.getElementById('newsChart'))
      let caseChart = echarts.init(document.getElementById('caseChart'))
      let viewChart = echarts.init(document.getElementById('viewChart'))

      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('statistic').then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.customerStatistic = d.data.customerStatistic || []
          this.newsStatistic = d.data.newsStatistic || []
          this.caseStatistic = d.data.caseStatistic || []
          this.viewStatistic = d.data.viewStatistic || []

          // 绘制图表
          customerChart.setOption({
            title: { text: '' },
            tooltip: {},
            xAxis: {
              type: 'category',
              data: (function (data) {
                var ret = []
                for (var k in data) {
                  if (data.hasOwnProperty(k)) {
                    ret.push(data[k])
                  }
                }
                return ret
              })(d.data.customerStatistic.xAxis)
            },
            yAxis: {
              type: 'value'
            },
            series: [{
              name: '当月数',
              type: 'line',
              data: (function (data) {
                var ret = []
                for (var k in data) {
                  if (data.hasOwnProperty(k)) {
                    ret.push(data[k])
                  }
                }
                return ret
              })(d.data.customerStatistic.data),
              smooth: true
            }]
          })

          // 资讯图表
          newsChart.setOption({
            title: { text: '' },
            tooltip: {},
            xAxis: {
              type: 'category',
              data: (function (data) {
                var ret = []
                for (var k in data) {
                  if (data.hasOwnProperty(k)) {
                    ret.push(data[k])
                  }
                }
                return ret
              })(d.data.newsStatistic.xAxis)
            },
            yAxis: {
              type: 'value'
            },
            series: [{
              name: '当月数',
              type: 'bar',
              data: (function (data) {
                var ret = []
                for (var k in data) {
                  if (data.hasOwnProperty(k)) {
                    ret.push(data[k])
                  }
                }
                return ret
              })(d.data.newsStatistic.data),
              smooth: true
            }]
          })

          // 案例图表
          caseChart.setOption({
            title: { text: '' },
            tooltip: {},
            xAxis: {
              type: 'category',
              data: (function (data) {
                var ret = []
                for (var k in data) {
                  if (data.hasOwnProperty(k)) {
                    ret.push(data[k])
                  }
                }
                return ret
              })(d.data.caseStatistic.xAxis)
            },
            yAxis: {
              type: 'value'
            },
            series: [{
              name: '当月数',
              type: 'line',
              data: (function (data) {
                var ret = []
                for (var k in data) {
                  if (data.hasOwnProperty(k)) {
                    ret.push(data[k])
                  }
                }
                return ret
              })(d.data.caseStatistic.data),
              smooth: true
            }]
          })

          // 浏览图表
          viewChart.setOption({
            title: { text: '' },
            tooltip: {},
            xAxis: {
              type: 'category',
              data: (function (data) {
                var ret = []
                for (var k in data) {
                  if (data.hasOwnProperty(k)) {
                    ret.push(data[k])
                  }
                }
                return ret
              })(d.data.viewStatistic.xAxis)
            },
            yAxis: {
              type: 'value'
            },
            series: [{
              name: '当月数',
              type: 'line',
              data: (function (data) {
                var ret = []
                for (var k in data) {
                  if (data.hasOwnProperty(k)) {
                    ret.push(data[k])
                  }
                }
                return ret
              })(d.data.viewStatistic.data),
              smooth: true
            }]
          })
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        }
      })
    }
  },
  mounted: function () {
    this.getStatisticDate()
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.echarts {
  height: 300px;
}
</style>
