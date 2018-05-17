<template>
  <div class="app_leftbar">
    <nav class="navbar navbar-default">
        <ul class="nav navbar-nav">
          <li v-for="(item) in navigates[$store.state.admin_level]" :key="item.url" :class="{'active':$store.state.left_active_key === item.url}">
              <router-link :to="item.url" v-if="item.children == undefined" @click="set_active(item)">
                <span class="icon-wrapper"><i :class="item.icon"></i></span>
                {{item.name}}
                <i v-if="item.children" class="pull-right app_leftbar_rightico fa fa-angle-double-right"></i>
              </router-link>
              <a href="javascript:;" v-if="item.children" @click="set_active(item)">
                <span class="icon-wrapper"><i :class="item.icon"></i></span>
                {{item.name}}
                <i v-if="item.children" class="pull-right app_leftbar_rightico fa fa-angle-double-right"></i>
              </a>
              <ul v-if="item.children" class="nav app_leftbar_sub_nav">
                <li v-for="(sitem) in item.children" :key="sitem.url">
                    <router-link :to="sitem.url">
                      <span class="icon-wrapper"><i :class="sitem.icon"></i></span>
                      {{sitem.name}}
                    </router-link>
                 </li>
              </ul>
           </li>
        </ul>
    </nav>
  </div>
</template>

<script>
import store from '@/store'
import navigate from '@/common/navigate'

export default {
  name: 'leftbar',
  store,
  data () {
    return {
      navigates: navigate
    }
  },
  methods: {
    set_active (obj) {
      if (this.$store.state.left_active_key === obj.url) {
        this.$store.state.left_active_key = ''
      } else {
        this.$store.state.left_active_key = obj.url
      }
    }
  }
}
</script>
