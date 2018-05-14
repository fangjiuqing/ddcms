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
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="title col-md-12">
            <h5 class="block-h5">小区管理</h5>
          </div>
          <div class="customer-row" v-for="(v) in rows" :key="v.pco_id">
            <div class="row">
              <div class="col-md-12">
                <div class="media-body">
                  <h5 class="text-left">
                    <btn class="btn btn-xs btn-rose pull-right" @click="del(v.pco_id)"><i class="fa fa-trash-o"></i></btn>
                    <a title="编辑小区" @click="modify(v.pco_id)">{{v.pco_name}}</a>
                  </h5>
                  <p class="text-left">
                    <span>
                      <small>省 : </small>
                      <span class="text-rose">{{v.pco_region0_label || 'unknown'}}</span>
                    </span>
                    <span class="separator"></span>
                    <span>
                      <small>市 : </small>
                      <span class="text-rose">{{v.pco_region1_label || 'unknown'}}</span>
                    </span>
                    <span class="separator"></span>
                    <span>
                      <small>县/区 : </small>
                      <span class="text-rose">{{v.pco_region2_label || 'unknown'}}</span>
                    </span>
                  </p>
                  <p class="text-left">
                    <span>
                      <small>详细地址 : </small>
                      <code>{{v.pco_addr || '暂无'}}</code>
                    </span>
                    <span class="separator"></span>
                  </p>
                  <p class="text-left">户型图 : </p>
                  <p class="text-left">
                    <img class="community-small-image" v-for="(img, img_key) in v.pco_cover_label" :src="img" :key="img_key" alt="">
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <pagination v-model="pn" :total-page="total" @change="refresh" size="sm"/>
        </div>
      </form>
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
        {text: '小区管理', to: '/community'},
        {text: '小区', href: '#'}
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
        path: '/community/type',
        query: {id}
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('community', this.modal_data).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_open = false
          this.refresh()
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'success',
            dismissible: false
          })
        } else {
          this.$notify({
            content: d.msg,
            duration: 2000,
            type: 'danger',
            dismissible: false
          })
        }
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('community', {pn: this.pn}).then(d => {
        console.log(d.data)
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.pn = d.data.paging.pn
          this.total = d.data.paging.max
        } else {
          this.rows = []
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
            this.$notify({
              content: d.msg,
              duration: 2000,
              type: 'danger',
              dismissible: false
            })
          }
        })
      }).catch(() => {
        this.$notify('取消删除.')
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
  padding-left: 50px;
}
.btn-rose {
  margin-right: 20px;
}
.distpicker-address-wrapper select {
  max-width: 115px!important;
}
.community {
  background: #fff;
}
.community-small-image {
  width: 20%;
}
.customer-row {
  margin-bottom: 20px;
  border: 1px solid #eee;
  border-radius: 3px;
  border-left: none;
}
</style>
