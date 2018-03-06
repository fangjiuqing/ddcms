<template>
  <div class="app_leftbar">
    <nav class="navbar navbar-default">
        <ul class="nav navbar-nav">
          <li v-for="(item, $index) in navigates[$store.state.admin_level]" :key="item.url" @click="set_active(item, $index)" :class="{'active':active_id == $index}">
              <router-link :to="item.url">
                <span class="icon-wrapper"><i :class="item.icon"></i></span>
                {{item.name}}
                <i v-if="item.children" class="pull-right app_leftbar_rightico fa fa-angle-double-right"></i>
              </router-link>
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
      navigates: navigate,
      active_id: -1
    }
  },
  methods: {
    set_active (obj, i) {
      if (this.active_id === i) {
        this.active_id = -1
      } else {
        this.active_id = i
      }
    }
  }
}
</script>
