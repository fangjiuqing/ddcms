<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="" method="post" accept-charset="utf-8">
        <div class="form-block">
          <div class="row">
            <div class="col-md-12">
              <h5 class="block-h5">基本信息</h5>
            </div>
            <div class="col-md-9">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <label class="col-sm-2 field-label">名称</label>
                    <div class="col-sm-10 input-label">
                      <input class="form-control" name="mat_name" v-model="form.mat_name" type="text" placeholder="材料名称">
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 field-label">类型</label>
                    <div class="col-sm-10 input-label">
                      <select v-model="form.gt_type" class="form-control">
                        <option disabled value="">请选择</option>
                        <option v-for="(v, k) in mtype" v-bind:key="k" :value="k">
                          {{v}}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12" style="margin:0 auto; float: none">
            <btn type="success" v-on:click="save" class="btn btn-success pull-right">保存</btn>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  name: 'MaterialAdd',
  metaInfo () {
    return {
      title: '材料管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '材料', to: '/material'},
        {text: '编辑', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      form: {
        gt_type: ''
      },
      mtype: {}
    }
  },
  methods: {
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('store/goods/type', {id: this.id, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = d.data.row || this.form
          this.mtype = d.data.mtype
        } else if (d.code === 9999) {
          this.$alert({
            title: '系统提示',
            content: d.msg
          }, (msg) => {
            this.$router.go(-1)
          })
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('material', {
        row: this.form,
        attr_key: this.fields,
        attr_val: this.rows
      }).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/material'
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
            duration: 1500,
            type: 'danger',
            dismissible: false
          })
        }
      })
    }
  },
  mounted: function () {
    this.$store.state.left_active_key = '/store'
    this.modify()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/store'
  }
}
</script>
