<template>
  <div class="type">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <router-link :to="{path:'/community/type/add'}" class="btn btn-xs btn-info pull-right">
          <i class="fa fa-plus-square"></i> 新增
        </router-link>
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <div class="history">
        <h5 class="block-h5">
          户型详情
        </h5>
      </div>
      <div class="app_content">
        <div>
          <form action="" method="post" accept-charset="utf-8">
            <div class="col-md-12" v-for="(v) in form" :key="v.id">
              <div class="col-md-6 type-row">
                <div class="row unit">
                  <label class="col-md-3 label-on-left">户型名称</label>
                  <div class="col-md-9">
                    <div class="input-group col-md-12">
                      <input class="form-control" name="pu_name" v-model="v.pu_name" type="text" placeholder="户型名称">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group col-sm-12">
                        <input class="form-control" name="pu_area0" v-model="v.pu_area0" type="number" placeholder="户型总面积">
                        <span class="input-group-addon">总面积M²</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group col-sm-12">
                        <input class="form-control" name="pu_area1" v-model="v.pu_area1" type="text" placeholder="户型可用面积">
                        <span class="input-group-addon">可用面积M²</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-3">
                    <div class="input-group col-sm-12">
                      <input class="form-control" name="pu_room0" v-model="v.pu_room0" type="text" placeholder="室">
                      <span class="input-group-addon">室</span>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="input-group col-sm-12">
                      <input class="form-control" name="pu_room1" v-model="v.pu_room1" type="text" placeholder="厅">
                      <span class="input-group-addon">厅</span>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="input-group col-sm-12">
                      <input class="form-control" name="pu_room2" v-model="v.pu_room2" type="text" placeholder="厨">
                      <span class="input-group-addon">厨</span>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="input-group col-sm-12">
                      <input class="form-control" name="pu_room3" v-model="v.pu_room3" type="text" placeholder="卫">
                      <span class="input-group-addon">卫</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-1">
                <btn class="btn btn-xs btn-success" @click="modifi(v.pu_id)"><i class="fa fa-pencil"></i></btn>
              </div>
              <div class="col-md-5">
                <img :src="v.pu_cover" alt="">
              </div>
            </div>
            <div class="clearfix"></div>
            <pagination v-model="pn" :total-page="total" size="sm"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Type',
  metaInfo () {
    return {
      title: '小区详情 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '小区管理', to: '/community'},
        {text: '小区详情', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      form: {},
      pn: 1,
      total: 1,
      attrs: {},
      modal_open: false,
      modal_title: '',
      modal_data: {}
    }
  },
  methods: {
    modifi (id) {
      this.$router.push({
        path: '/community/type/add',
        query: {id}
      })
    },
    modify: function (id) {
      this.modal_open = true
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('unit', {id: id, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_data = d.data
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        } else {
          this.modal_data = this.modal_data || {}
        }
        this.modal_open = true
      })
    },
    refresh: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('unit', {id: this.id || 0, attrs: 1, pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = this.id ? d.data.list : {}
          this.pn = d.data.paging.pn
          this.total = d.data.paging.max
        } else {
          this.form = []
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('unit', this.modal_data).then(d => {
        console.log(this.modal_data)
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
.unit {
  margin-bottom: 15px;
}
.app_page .type-row {
  margin-bottom: 40px;
}
.distpicker-address-wrapper {
  text-align: left;
}
.distpicker-address-wrapper select {
  max-width: 105px!important;
}
</style>
