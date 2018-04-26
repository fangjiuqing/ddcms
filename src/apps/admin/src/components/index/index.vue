<template>
    <div class="profile">
        <breadcrumbs :items="items">
          <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
            {{v.text}}
          </breadcrumb-item>
          <breadcrumb-item active class="pull-right">
            <router-link :to="{path:'/material/add'}" class="btn btn-xs btn-info pull-right">
              <i class="fa fa-plus-square"></i> 新增
            </router-link>
          </breadcrumb-item>
        </breadcrumbs>
        <div class="app_page">
          <div class="app_content">
            <div class="content">
              <div class="row">
                <div class="ibox float-e-margins">
                  <div class="ibox-title">
                    <h5>
                      顾客统计
                      <span class="label label-info">月度统计</span>
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

                    <div class="col-sm-12">
                      <template>
                        <chart :options="customer"></chart>
                      </template>
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
import Vue from 'vue'
import ECharts from 'vue-echarts/components/ECharts'
// import ECharts modules manually to reduce bundle size
import 'echarts/lib/chart/bar'
import 'echarts/lib/chart/line'
import 'echarts/lib/chart/pie'
import 'echarts/lib/chart/map'
import 'echarts/lib/chart/radar'
import 'echarts/lib/chart/scatter'
import 'echarts/lib/chart/effectScatter'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/polar'
import 'echarts/lib/component/geo'
import 'echarts/lib/component/legend'
import 'echarts/lib/component/title'
import 'echarts/lib/component/visualMap'
import 'echarts/lib/component/dataset'

// register component to use
Vue.component('chart', ECharts)

export default {
  name: 'Index',
  metaInfo: {
    title: '首页 - 道达智装'
  },
  data () {
    let customerStatistic = []
    customerStatistic['title'] = '月度统计'
    customerStatistic['date'] = ['一月' ,'二月' ,'三月' ,'四月' ,'五月' ,'六月' ,'七月' ,'八月' ,'九月' ,'十月' ,'十一月' ,'十二月']
    customerStatistic['data'] = []
    for (let i = 0; i <= 12; i++) {
      let t = Math.random() * 10000
      customerStatistic['data'].push(t)
    }

    return {
      items: [
        {text: '首页', to: '/'},
        {text: '数据统计', href: '#'}
      ],
      customer: {
        title: {
          text: customerStatistic['title']
        },
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'cross',
            label: {
              backgroundColor: '#6a7985'
            }
          }
        },
        xAxis: {
          type: 'category',
          data: customerStatistic['date']
        },
        yAxis: {
          type: 'value'
        },
        series: [{
          data: customerStatistic['data'],
          type: 'line',
          smooth: true
        }]
      }
    }
  },
  methods: {
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.echarts {
  height: 400px;
  width: 100%
}
</style>
