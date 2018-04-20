<template>
  <div class="case">
    <breadcrumbs :items="items">
      <breadcrumb-item v-for="(v, i) in items" v-bind:key="i" :active="i === items.length - 1" :to="{path: v.to}" >
        {{v.text}}
      </breadcrumb-item>
      <breadcrumb-item active class="pull-right">
        <router-link :to="{path:'/case/add'}" class="btn btn-xs btn-info pull-right">
          <i class="fa fa-plus-square"></i> 新增
        </router-link>
      </breadcrumb-item>
    </breadcrumbs>
    <div class="app_page">
      <form action="/" id="profile_form" class="form-horizontal ng-untouched ng-pristine ng-valid" method="post" novalidate="">
        <div class="app_content">
          <div class="case-list">
            <div class="media case-row" v-for="(v) in rows" :key="v.case_id">
                <div class="media-left">
                  <img :src="attrs.upload_url + v.case_cover" alt="" class="case-list-cover">
                </div>
                <div class="media-body">
                  <h5>
                    <btn class="btn btn-xs btn-rose pull-right" @click="del_case(v.case_id)"><i class="fa fa-trash-o"></i></btn>
                    <a title="编辑案例" @click="modify(v.case_id)">{{v.case_title}}</a>
                  </h5>
                  <p class="text-left">
                    <span>
                      <small>类别 : </small> <code>{{attrs.cat[v.case_cat_id]['cat_name']}}</code>
                    </span>
                    <span class="separator"></span>
                    <span>
                      <small>风格 : </small> <code>{{attrs.style[v.case_style_id]['cat_name']}}</code>
                    </span>
                    <span class="separator"></span>
                    <span>
                      <small>空间 : </small> <code>{{attrs.space[v.case_space_id]['cat_name']}}</code>
                    </span>
                    <span class="separator"></span>
                    <span>
                      <small>布局 : </small> <code>{{attrs.layout[v.case_layout_id]['cat_name']}}</code>
                    </span>
                    <span class="separator"></span>
                    <small>
                      共 {{v.case_image_count}} 张
                    </small>
                  </p>
                  <p class="text-left">
                    <span>
                      <small>发布于 {{v.case_adate|time('yyyy-mm-dd HH:MM:ss')}}</small>
                    </span>
                    <span class="separator"></span>
                    <span>
                      <small>更新于 {{v.case_udate|time('yyyy-mm-dd HH:MM:ss')}}</small>
                    </span>
                  </p>
                  <p class="text-left">
                    <img class="case-small-image" v-for="(img, img_key) in v.images" :src="attrs.upload_url + img" :key="img_key" alt="">
                  </p>
                </div>
            </div>
          </div>
          <pagination v-model="pn" :total-page="total" @change="refresh" size="sm"/>
        </div>
      </form>
    </div>
  </div>
</template>

<script>

export default {
  name: 'Case',
  metaInfo () {
    return {
      title: '案例管理 - 道达智装'
    }
  },
  data () {
    return {
      items: [
        {text: '首页', to: '/'},
        {text: '案例', to: '/case'},
        {text: '列表', href: '#'}
      ],
      rows: [],
      attrs: {},
      pn: 1,
      total: 1
    }
  },
  methods: {
    modify (id) {
      this.$router.push({
        path: '/case/add',
        query: {id}
      })
    },
    refresh: function () {
      this.$loading.show({
        msg: '加载中 ...'
      })
      this.$http.list('case', {pn: this.pn}).then(d => {
        this.$loading.hide()
        if (d.code === 0) {
          this.rows = d.data.list
          this.pn = d.data.paging.pn || 1
          this.total = d.data.paging.max || 1
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
    del_case: function (id) {
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
        this.$http.del('case', {id: id}).then(d => {
          if (d.code === 0) {
            this.$notify({
              type: 'success',
              content: d.msg
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
        this.$notify({
          type: 'info',
          content: '取消删除.'
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
