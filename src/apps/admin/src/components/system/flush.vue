<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="form-block">
            <div class="row">
              <div class="col-md-12">
                <h5 class="block-h5">可清理缓存</h5>
              </div>
            </div>
            <ul class="list-unstyled">
              <li v-for="(v, k) in rows" :key="k" class="text-left">
                <label style="font-weight: normal">
                  <input type="checkbox" v-model="rows[k]['checked']" value=""> {{v.label}}
                </label>
              </li>
            </ul>
            <btn type="success" v-on:click="save" class="btn btn-success pull-right">确认</btn>
            <div class="clearfix"></div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Group',
  metaInfo () {
    return {
      title: '缓存更新 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '管理', to: '/system'},
        {text: '缓存更新', href: '#'}
      ],
      rows: []
    }
  },
  methods: {
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('system/flush', {
        'items': this.rows
      }).then(d => {
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
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
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
      this.$http.get('system/flush').then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        } else {
          this.rows = []
        }
      })
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/system'
    this.refresh()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/system'
    this.refresh()
  }
}
</script>
<style scoped>
  h6 {
    font-size: 13px;
    font-weight: 300;
    color: #666;
  }
  .items {
    margin-bottom: 10px;
    background: #f5f5f5;
    padding: 5px 15px 15px 15px;
    border-radius: 3px;
  }
  .item-checbox {
    font-weight: normal;
    font-size: 13px;
    display: inline-block;
    margin-right: 15px;
    color: #555;
    cursor: pointer;
  }
</style>
