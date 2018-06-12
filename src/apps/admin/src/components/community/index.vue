<template>
  <div class="community">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}">
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <a @click="modify('0')" class="btn btn-xs btn-info pull-right">
          <i class="fa fa-plus-square"></i> 新增
        </a>
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <div class="app_content">
        <div class="customer-row col-offset-2" v-for="(v) in rows" :key="v.pco_id">
          <div class="row">
            <div class="col-md-3" style="border-right: 1px dashed #ddd">
              <h4 class="text-left" style="font-weight: 300;font-size: 16px;">
                <a title="编辑小区" @click="modify(v.pco_id)">{{v.pco_name}}</a>
              </h4>
              <p class="text-left">
                <i class="fa fa-location-arrow text-info"></i> &nbsp;
                <small class="text-default">{{v.region0 || '未知'}}</small>
                <small class="text-default" v-if="v.region1"> - {{v.region1}}</small>
                <small class="text-default" v-if="v.region2"> - {{v.region2}}</small>
              </p>
              <p class="text-left">
                <small v-if="v.pco_addr">{{v.pco_addr}}</small>
              </p>
              <p class="text-left">
                <small>共有 <code>{{v.nums}}</code> 个户型</small>
              </p>
              <p class="text-left">
                <btn class="btn btn-xs btn-rose" @click="del(v.pco_id)"><i class="fa fa-trash-o"></i></btn>
              </p>
            </div>
            <div class="col-md-6">
              <div class="unit" v-for="(v, k) in v.units" :key="k">
                <img :src="v.cover" alt="">
                <h6>{{v.name}}</h6>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <pagination v-model="pn" v-if="total > 1" :total-page="total" @change="refresh" size="sm"/>
      </div>
    </div>
  </div>
</template>
<script>
import VDistpicker from 'v-distpicker'
export default {
  name: 'Community',
  metaInfo () {
    return {
      title: '小区管理 - 道达智装'
    }
  },
  components: { VDistpicker },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '小区', to: '/community'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      pn: 1,
      total: 1,
      attrs: {}
    }
  },
  methods: {
    modify (id) {
      this.$router.push({
        path: '/community/add',
        query: {id}
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('community', {pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.pn = d.data.paging.pn
          this.total = d.data.paging.max
        } else {
          this.$alert({
            title: '操作提示',
            content: d.msg
          }, (msg) => {
            if (d.code === 9999) {
              this.$router.go(-1)
            }
          })
        }
      })
    },
    del: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$loading.hide()
      this.$confirm({
        title: '操作提示',
        content: '此项将被永久删除。继续?',
        okText: '确认',
        cancelText: '取消'
      }).then(() => {
        this.$http.del('community', {id: id}).then(d => {
          if (d.code === 0) {
            this.$notify({
              type: 'success',
              content: '删除成功.'
            })
            this.refresh()
          } else {
            this.$alert({
              title: '操作提示',
              content: d.msg
            }, (msg) => {
              if (d.code === 9999) {
                this.$router.go(-1)
              }
            })
          }
        })
      })
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/operate'
    this.refresh()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/operate'
    this.refresh()
  }
}
</script>
<style scoped>
.text-left {
  padding-left: 15px;
}
.btn-rose {
  margin-right: 20px;
}
.distpicker-address-wrapper select {
  max-width: 115px!important;
}
.col-md-3 {
  margin-left: 2%;
}
.col-md-6 {
  margin-right: 5%;
}
.community {
  background: #fff;
}
.unit {
  width: 33%;
  float: right;
}
.unit img {
  max-width: 100%;
  max-height: 120px;
}
.customer-row {
  padding-bottom: 15px;
  margin-bottom: 15px;
  border-bottom: 1px dashed #ccc;
}
</style>
