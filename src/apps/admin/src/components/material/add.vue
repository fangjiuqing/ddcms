<template>
  <div class="app_panel">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="" method="post" accept-charset="utf-8">
        <div class="row" style="margin:0 15px;">
          <h5 style="font-size: 13px;text-align:left;font-weight: 350">
            基本信息
            <div class="clearfix"></div>
          </h5>
          <div class="col-md-9">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <label class="col-sm-2 field-label">名称</label>
                    <div class="col-sm-10 input-label">
                      <input class="form-control" name="mat_name" v-model="form.mat_name"  v-focus="form.mat_name"  type="text" placeholder="材料名称">
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 field-label">品牌</label>
                    <div class="col-sm-10 input-label">
                      <select v-model="form.mat_brand_id"  name="mat_brand_id" class="form-control">
                        <option disabled value="">请选择</option>
                        <option v-for="(v) in brands" v-bind:key="v.pb_id" :value="v.pb_id">
                          {{v.pb_name}}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 field-label">类型</label>
                    <div class="col-sm-10 input-label">
                      <select v-model="form.mat_type" class="form-control">
                        <option disabled value="">请选择</option>
                        <option v-for="(v, k) in mat_type" v-bind:key="k" :value="k">
                          {{v}}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <label class="col-sm-2 field-label">分类</label>
                    <div class="col-sm-10 input-label">
                      <select v-model="form.mat_cat_id"  name="mat_cat_id" class="form-control">
                        <option disabled value="">请选择</option>
                        <option v-for="(v) in categories" v-bind:key="v.cat_id" :value="v.cat_id" v-html="v.space">
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 field-label">售价</label>
                    <div class="col-sm-10 input-label">
                      <input class="form-control" name="mat_price" v-model="form.mat_price"  v-focus="form.mat_price"  type="text" placeholder="材料售价">
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-sm-3">
              <img class="preview_article_cover" style="width: 200px;" :src="mat_cover" @click="upload_cover">
              <input type="hidden" name="mat_cover" v-model="form.mat_cover">
              <div class="clearfix"></div>
          </div>
        </div>

        <div style="margin:15px auto;border-radius:3px;padding:15px;">
          <h5 style="font-size: 13px;text-align:left;font-weight: 350">
            材料规格
            <btn class="btn btn-xs btn-warning pull-right" @click="add_filed" style="margin-left: 10px;">加属性</btn>
            <btn class="btn btn-xs btn-danger pull-right" @click="rm_filed" style="margin-left: 10px;">删属性</btn>
            <btn class="btn btn-xs btn-success pull-right" @click="add_row">加记录</btn>
            <div class="clearfix"></div>
          </h5>
          <table class="table table-striped">
            <thead>
              <tr style="background-color:#f0f0f0">
                <th v-for="(v, k) in fields" :key="k" width="14%" v-if="k !== 'id'">
                  <input class="material_field_input" @focus="set_active(k)" v-model="fields[k]" :placeholder="v"/>
                </th>
                <th width="8%" class="text-center"><span class="material_field_text">价格</span></th>
                <th width="7%" class="text-center"><span class="material_field_text">库存</span></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, row_key) in rows" :key="row_key">
                <td v-for="(v, k) in fields" :key="k">
                  <input class="material_field_input" v-model="rows[row_key][k]" :placeholder='"请输入" + v'/>
                </td>
                <td >
                  <input class="material_field_input" v-model="rows[row_key]['price']" value="" placeholder="价格" />
                </td>
                <td>
                  <input class="material_field_input" v-model="rows[row_key]['stocks']" value="" placeholder="库存数" />
                </td>
                <td></td>
              </tr>
            </tbody>
          </table>
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
        mat_type: '',
        mat_cat_id: '',
        mat_brand_id: ''

      },
      mat_cover: '',
      extra: {},
      categories: [],
      mat_type: [],
      brands: [],
      selected: '',
      field_key: '',
      rows: [
        {
          id: 0
        }
      ],
      fields: {}
    }
  },
  methods: {
    set_active (key) {
      this.field_key = key
    },
    rm_filed () {
      if (this.field_key !== '') {
        this.$delete(this.$data.fields, this.field_key)
        for (var i = 0; i < this.rows.length; i++) {
          delete this.rows[i][this.field_key]
        }
        this.field_index = ''
      } else {
        this.$notify({
          content: '请选择字段输入框',
          duration: 1000,
          type: 'warning',
          dismissible: false
        })
      }
    },
    add_row () {
      let row = {
        id: 0,
        'price': 0,
        'stocks': 0
      }
      for (var key in this.fields) {
        if (this.fields.hasOwnProperty(key)) {
          row[key] = ''
        }
      }
      this.rows.push(row)
    },
    add_filed () {
      if (Object.keys(this.fields).length >= 6) {
        this.$notify({
          content: '最多只能添加6个自定义属性',
          duration: 2000,
          type: 'danger',
          dismissible: false
        })
      } else {
        this.$set(this.$data.fields, this.$util.rand_str(16), '新属性')
      }
    },
    on_cover_error (msg) {
      this.$loading.hide()
      this.$notify({
        content: msg,
        duration: 2000,
        type: 'danger',
        dismissible: false
      })
    },
    on_cover_start (e) {
      this.$loading.show({
        msg: '文件上传中, 已发送 0 % ...'
      })
    },
    on_cover_finish (d) {
      this.$loading.hide()
      this.$notify({
        content: '上传成功',
        duration: 1000,
        type: 'success',
        dismissible: false
      })
      this.form.article_cover = d.image
      this.article_cover = d.thumb
    },
    on_cover_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },
    upload_cover () {
      this.$uploader.select({
        uri: 'upload/image',
        el: this,
        pre: 'cover'
      })
    },
    modify: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('material', {id: this.id, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = Object.keys(d.data.row).length > 0 ? d.data.row : this.form
          this.article_cover = this.form['article_cover_thumb'] || ''
          this.categories = d.data.category
          this.mat_type = d.data.type
          this.brands = d.data.brands
          this.fields = d.data.fields || {}
          this.rows = d.data.goods || []
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
    this.$store.state.left_active_key = '/material'
    this.modify()
  },
  destroyed: function () {
    this.$loading.hide()
  },
  activated: function () {
    this.$store.state.left_active_key = '/material'
  }
}
</script>

<style>
  #editor {
  }
  .quillWrapper {
    position: relative;
  }
  .quillWrapper .ql-snow.ql-toolbar {
    width: 100%;
  }
  .ql-editor {
    min-height: 360px;
  }
  .ql-toolbar {
    text-align: left;
  }
</style>
