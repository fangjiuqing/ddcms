<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <router-link :to="{path:'/designer/add'}" class="btn btn-xs btn-info pull-right">
          <i class="fa fa-plus-square"></i> 新增
        </router-link>
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="content">
            <div class="designer-list" v-for="(v) in rows" :key="v.des_id">
              <div class="col-sm-2 div-bottom-border">
                <img class="preview_cover" :src="v.des_cover" style="width:140px; height: 160px" />
              </div>

              <div class="col-sm-3 designer-info div-bottom-border">
                <p>
                  <span class="info-key">姓名：</span>
                  <span class="info-val">
                    <a @click="modify(v.des_id)">{{v.des_name}}</a>
                  </span>
                </p>
                <p>
                  <span class="info-key">职位：</span>
                  <span class="info-val">{{v.des_title}}</span>
                </p>
                <p>
                  <span class="info-key">工龄：</span>
                  <span class="info-val"><b class="text-warning">{{v.des_workyears}}</b> 年</span>
                </p>
                <p>
                  <span class="info-key">设计价格：</span>
                  <span class="info-val"><b class="text-danger">{{v.des_price}}</b> 元/M²</span>
                </p>
                <p>
                  <span class="info-key">所在地区：</span>
                  <span class="info-val">{{(attrs.region[v.des_region0]).region_name}} - {{(attrs.region[v.des_region1]).region_name}}</span>
                </p>
              </div>

              <div class="col-sm-7 sm3-style">
                <div class="mb10">
                  <p class="sm3-style-title">
                    <i class="fa fa-newspaper-o"></i>
                    设计理念
                  </p>
                  <div class="design-info-content">
                    {{v.des_concept_tags}}
                  </div>
                </div>

                <div class="mb10">
                  <p class="sm3-style-title">
                    <i class="fa fa-empire"></i>
                    设计风格
                  </p>
                  <div class="design-info-content">
                    <span v-for="(sv) in v.stags" :key="sv" class="label label-info" style="margin-right:5px;">{{sv}}</span>
                  </div>
                </div>

                <div class="" style="position: absolute; right: 14px;bottom: -14px;">
                  <btn class="btn btn-xs btn-rose" @click="del(v.des_id)"><i class="fa fa-trash-o"></i></btn>
                  <btn class="btn btn-xs btn-info" @click="caseList(v.des_id)"><i class="fa fa-link"></i></btn>
                </div>
              </div>

              <div class="clearfix"></div>
            </div>
            <pagination v-model="pn" v-if="total > 1" :total-page="total" @change="refresh" size="sm"/>
          </div>
        </div>
      </form>
    </div>

    <modal v-model="modal_open" title="{modal_title}" size="lg">
      <div slot="title" class="text-left">
        {{modal_title}} <small style="font-weight: 300"> - 代表作设置</small>
      </div>
      <div slot="default">
        <div class="row">
          <div class="col-sm-9 input-label symbol">
            <input id="input-5" class="form-control" type="text" placeholder="代表作品">
            <typeahead v-model="modal_data.des_id" target="#input-5" :async-function="querydes" item-key="case_title">
              <template slot="item" slot-scope="props">
                <li v-for="(item, index) in props.items" :class="{active:props.activeIndex===index}" :key="index">
                  <a role="button" @click="queryd(props.select, item)">
                    <img width="22px" height="22px" :src="item.case_cover + '&s=40'">
                    <span v-html="props.highlight(item)"></span>
                  </a>
                </li>
              </template>
            </typeahead>
          </div>
        </div>
        <form action="" method="post" accept-charset="utf-8">
          <ul class="list clearfix">
            <li v-for="(v, k) in cases" :key="k">
              <div class="content-case">
                <img :src="v.case_cover" alt="" width="120px" height="100px">
                <div class="tit-remove">
                  <span>{{v.case_title}}</span>
                  <btn class="btn btn-xs btn-rose remove"  @click="removeArea(v.case_id)"><i class="fa fa-trash-o"></i></btn>
                </div>
              </div>
            </li>
          </ul>
        </form>
      </div>
      <div slot="footer">
        <btn @click="caseSet" type="success" class="btn-sm">确认</btn>
      </div>
    </modal>
  </div>
</template>

<script>

export default {
  name: 'designer',
  metaInfo () {
    return {
      title: '设计师管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '设计师', to: '/designer'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      attrs: {},
      pn: 1,
      total: 1,
      modal_open: false,
      modal_title: '',
      cases: {},
      modal_data: {
        des_id: {}
      },
      choseKey: ''
    }
  },
  methods: {
    chose (key) {
      this.choseKey = key
    },
    queryd (callback, item) {
      callback(item)
      this.choseKey = item.case_id
      this.$set(this.$data.cases, this.choseKey, item)
    },
    removeArea (areaId) {
      this.$delete(this.$data.cases, areaId)
    },
    querydes (query, done) {
      this.$http.list('designer/help/case', {key: query}).then(d => {
        if (d.code === 0) {
          done(d.data.list)
        }
      })
    },
    caseSet () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.set('designer/case', {
        'rows': this.cases
      }).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_open = false
          this.cases = {}
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
    caseList (id) {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('designer/case', {id}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.modal_title = d.data.des['des_name']
          this.modal_open = true
          this.cases = d.data.list
          // this.case_d = d.data.list
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
    modify (id) {
      this.$router.push({
        path: '/designer/add',
        query: {id}
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('designer', {pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.pn = d.data.paging.pn
          this.total = d.data.paging.max
          this.attrs = d.data.attrs
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
        this.$http.del('designer', {id: id}).then(d => {
          if (d.code === 0) {
            this.$notify({
              type: 'success',
              content: '删除成功.',
              duration: 2000,
              dismissible: false
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
  .case-row {
    display: inline-block;
    width: 30%;
    margin-right: 1%;
  }
  .designer-list {
    padding: 10px 15px;background-color: #f9f9f9; position: relative;
    font-size: 85%;margin-bottom: 20px;
  }
  .designer-info p {
    line-height: 25px;
  }
  .info-key,.info-val{
    display: block;
  }
  .info-key {
    float: left;
    text-align: right;
    width: 80px;
  }
  .info-val {
    text-align: left;
    margin-left: 90px;
  }
  .design-info-content {
    padding: 10px 3px; border: 1px solid #ddd;
  }
  .sm3-style {
    text-align:left
  }
  .sm3-style-title {
    background-color: #ddd;padding: 3px 5px;margin: 0;
  }
  .mb10 {margin-bottom: 15px}
  .div-bottom-border {
    border-right: 1px dashed #ddd
  }
.symbol {
  margin-bottom: 50px;
  margin-left: 60px;
}
.list {
  list-style: none;
}
.clearfix:after{
  content: ".";
  display: block;
  height: 0;
  clear: both;
  visibility: hidden;
}
.list li {
  float: left;
  padding: 0 15px 20px 15px;
}
.content-case {
  border: 1px solid #f5f5f5;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.content-case img {
  margin: 10px 10px 0 10px;
}
.tit-remove {
  width: 100%;
  margin: 15px 0 10px 15px;
  text-align: left;
}
.tit-remove .remove {
  float: right;
  margin-top: -5px;
  margin-right: 15px;
}
</style>
