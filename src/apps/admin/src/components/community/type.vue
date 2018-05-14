<template>
  <div class="type">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
    </breadcrumbs>
    <div class="community-concent col-md-12">
      <h5 class="block-h5">小区详情</h5>
      <div class="col-sm-12">
        <div class="row">
          <div class="col-md-8">
            <label for="" class="label-on-left col-sm-2">小区名称</label>
            <div class="form-group col-sm-8">
              <input class="form-control" name="pco_name" v-model="community.pco_name" type="text" placeholder="小区名称">
            </div>
          </div>
          <div class="col-md-8">
            <label for="" class="label-on-left col-sm-2">详细地址</label>
            <div class="form-group col-sm-8">
              <input class="form-control" name="pco_addr" v-model="community.pco_addr" type="text" placeholder="详细地址">
            </div>
          </div>
          <div class="address">
            <div class="col-sm-8">
              <div class="form-group text-left">
                <v-distpicker :province="community.province" :city="community.city" :area="community.area" @selected="onSelected"></v-distpicker>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <h5 class="block-h5">新增户型
            <btn class="btn btn-xs btn-success pull-right" @click="add_row">新增户型</btn>
            <div class="clearfix"></div>
          </h5>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-striped">
            <thead>
              <tr style="background-color:#f7f7f7">
                <th v-for="(v, k) in fields" :key="k" width="13%" v-if="k !== 'id'">
                  <input class="material_field_input" @focus="set_active(k)" v-model="fields[k]" :placeholder="v"/>
                </th>
                <th width="7%" class="text-center"><span class="material_field_text">户型图</span></th>
                <th width="7%" class="text-center"><span class="material_field_text">户型名</span></th>
                <th width="7%" class="text-center"><span class="material_field_text">总面积</span></th>
                <th width="7%" class="text-center"><span class="material_field_text">可用面积</span></th>
                <th width="7%" class="text-center"><span class="material_field_text">卧室</span></th>
                <th width="7%" class="text-center"><span class="material_field_text">客厅</span></th>
                <th width="7%" class="text-center"><span class="material_field_text">厨房</span></th>
                <th width="7%" class="text-center"><span class="material_field_text">卫生间</span></th>
                <!-- <th width="7%" class="text-center"><span class="material_field_text"></span></th> -->
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, row_key) in rows" :key="row_key">
                <td>
                  <img class="preview_cover" style="width: 150px;" :src="row.cover" @click="upload_cover(row_key)">
                  <input class="material_field_input" type="hidden" name="pu_cover" v-model="rows[row_key]['pu_cover']">
                </td>
                <td>
                  <input class="material_field_input" v-model="rows[row_key]['pu_name']" value="" placeholder="户型名" />
                </td>
                <td>
                  <input class="material_field_input" v-model="rows[row_key]['pu_area0']" value="" placeholder="总面积" />
                </td>
                <td>
                  <input class="material_field_input" v-model="rows[row_key]['pu_area1']" value="" placeholder="可用面积" />
                </td>
                <td>
                  <input class="material_field_input" v-model="rows[row_key]['pu_room0']" value="" placeholder="卧室" />
                </td>
                <td>
                  <input class="material_field_input" v-model="rows[row_key]['pu_room1']" value="" placeholder="客厅" />
                </td>
                <td>
                  <input class="material_field_input" v-model="rows[row_key]['pu_room2']" value="" placeholder="厨房" />
                </td>
                <td>
                  <input class="material_field_input" v-model="rows[row_key]['pu_room3']" value="" placeholder="卫生间" />
                </td>
                <!-- <td>
                  <btn class="btn btn-xs btn-danger pull-right" @click="del_row" style="margin-left: 10px;"><i class="fa fa-trash-o"></i></btn>
                </td> -->
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <div class="col-md-12">
    <div class="content">
      <h5 class="block-h5" v-if="id !== '0'">户型详情
      </h5>
      <form action="" method="post" accept-charset="utf-8">
        <div class="col-md-12 type-row" v-for="(v) in form" :key="v.id">
          <div class="col-md-4">
            <img :src="v.cover" alt="" style="width: 100%;">
          </div>
          <div class="col-md-5 detail">
            <div class="row unit">
              <label class="col-md-3 label-on-left">户型名称</label>
              <div class="col-md-9">
                <div class="input-group col-md-8">
                  <input class="form-control" name="pu_name" v-model="v.pu_name" type="text" placeholder="户型名称">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-6">
                <div class="input-group">
                  <input class="form-control" name="pu_area0" v-model="v.pu_area0" type="number" placeholder="户型总面积">
                    <span class="input-group-addon">总面积M²</span>
                </div>
              </div>
              <div class="form-group col-sm-6">
                <div class="input-group">
                  <input class="form-control" name="pu_area1" v-model="v.pu_area1" type="text" placeholder="户型可用面积">
                  <span class="input-group-addon">可用面积M²</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-6">
                <div class="input-group">
                  <input class="form-control" name="pu_room0" v-model="v.pu_room0" type="text" placeholder="室">
                  <span class="input-group-addon">室</span>
                </div>
              </div>
              <div class="form-group col-sm-6">
                <div class="input-group">
                  <input class="form-control" name="pu_room1" v-model="v.pu_room1" type="text" placeholder="厅">
                  <span class="input-group-addon">厅</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-6">
                <div class="input-group">
                  <input class="form-control" name="pu_room2" v-model="v.pu_room2" type="text" placeholder="厨">
                  <span class="input-group-addon">厨</span>
                </div>
              </div>
              <div class="form-group col-sm-6">
                <div class="input-group">
                  <input class="form-control" name="pu_room3" v-model="v.pu_room3" type="text" placeholder="卫">
                  <span class="input-group-addon">卫</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <btn class="btn btn-xs btn-rose" @click="del(v.pu_id)"><i class="fa fa-trash-o"></i></btn>
          </div>
          <div class="line"></div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-11" style="margin:0 auto; float: none">
            <btn type="success" v-on:click="save" class="btn btn-success pull-right">保存</btn>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</template>
<script>
import VDistpicker from 'v-distpicker'
export default {
  name: 'Type',
  components: { VDistpicker },
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
        {text: '小区编辑', href: '#'}
      ],
      id: this.$route.query['id'] || 0,
      form: {},
      community: {},
      extra: {},
      cover: '',
      attrs: {},
      rows: [
        {
          id: 0,
          pu_cover: '',
          cover: require('@/assets/images/default_1x1.jpg')
        }
      ],
      fields: {},
      field_key: '',
      rowID: 0
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
        pu_cover: '',
        cover: require('@/assets/images/default_1x1.jpg')
      }
      for (var key in this.fields) {
        if (this.fields.hasOwnProperty(key)) {
          row[key] = ''
        }
      }
      this.rows.push(row)
    },
    // del_row (k) {
    //   let row = {
    //     id: 0
    //   }
    //   for (var key in this.fields) {
    //     if (this.fields.hasOwnProperty(key)) {
    //       row[key] = ''
    //     }
    //   }
    //   this.rows.pop(row)
    // },
    upload_cover (rowID) {
      this.rowID = rowID
      this.$uploader.select({
        uri: 'upload/image',
        el: this,
        pre: 'cover'
      })
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
      this.rows[this.rowID]['pu_cover'] = d.image
      this.rows[this.rowID]['cover'] = d.thumb
      this.rowID = 0
    },
    on_cover_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },
    on_editor_error (msg) {
      this.$loading.hide()
      this.$notify({
        content: msg,
        duration: 2000,
        type: 'danger',
        dismissible: false
      })
    },
    on_editor_start (e) {
      this.$loading.show({
        msg: '文件上传中, 已发送 0 % ...'
      })
    },
    on_editor_finish (d) {
      this.$loading.hide()
      this.$notify({
        content: '上传成功',
        duration: 1000,
        type: 'success',
        dismissible: false
      })
      let url = d.url
      this.extra.Editor.insertEmbed(this.extra.cursorLocation, 'image', url)
      this.extra.resetUploader()
    },
    on_editor_progress (e) {
      if (e) {
        this.$loading.show({
          msg: '文件上传中, 已发送 ' + e + ' % ...'
        })
      }
    },
    upload_image (file, Editor, cursorLocation, resetUploader) {
      let formData = new FormData()
      formData.append('raw', JSON.stringify({
        'uri': 'upload/image',
        'access_token': this.$sess.access_token
      }))
      formData.append('file', file)
      this.extra = {Editor, cursorLocation, resetUploader}
      this.$uploader.exec({
        uri: 'upload/image',
        el: this,
        pre: 'editor',
        data: formData
      })
    },
    onSelected (d) {
      this.community.pco_region0 = d.province.code
      this.community.pco_region1 = d.city.code
      this.community.pco_region1 = d.city.code
    },
    refresh: function (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.get('community', {id: this.id || 0, attrs: 1}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.form = this.id ? d.data.list : {}
          this.community = this.id ? d.data.detail : {}
        } else {
          this.form = {}
        }
      })
    },
    save: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.save('community', {
        // attr_key: this.fields,
        add: this.rows,
        base: this.community
      }).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.$router.push({
            path: '/community'
          })
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
        this.$http.del('unit', {id: id}).then(d => {
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
.address {
  margin-left: 12%;
}
.type, .col-md-12 {
  background: #fff;
}
.detail {
  padding-top: 50px;
}
.btn-rose {
  margin-top: 20px;
}
.unit {
  margin-bottom: 15px;
}
.line {
  position: absolute;
  width: 100%;
  height: 1px;
  background: #ccc;
  bottom: 0;
}
.app_page .type-row {
  margin-bottom: 50px;
}
.distpicker-address-wrapper {
  text-align: left;
}
.distpicker-address-wrapper select {
  max-width: 105px!important;
}
</style>
