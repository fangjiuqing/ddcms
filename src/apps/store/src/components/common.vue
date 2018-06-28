<template>
  <div class="typ">
    <div class="type" @mouseenter="showPanel" @mouseleave="hidePanel">
      <ul>
        <li v-for="items in content" :key="items.index">
          <h1>{{items.cat_name}}</h1>
          <div class="con">
            <router-link :to="{name: 'shopping-list'}">
              <span v-for="item in items.nodes" :key="item.index">{{item.cat_name}}</span>
            </router-link>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'common',
  props: {
    panelShow: {
      type: Boolean
    }
  },
  data () {
    return {
      content: []
      // type: [
      //   {
      //     title: '建材',
      //     content: [
      //       '瓷砖', '地板', '卫浴', '厨房', '门窗', '灯饰',
      //       '涂料', '吊顶', '五金', '工具', '电料', '管材'
      //     ]
      //   },
      //   {
      //     title: '全屋定制',
      //     content: [
      //       '瓷砖', '地板', '卫浴', '厨房', '门窗', '灯饰',
      //       '涂料', '吊顶', '五金', '工具', '电料', '管材'
      //     ]
      //   },
      //   {
      //     title: '家具',
      //     content: [
      //       '瓷砖', '地板', '卫浴', '厨房', '门窗', '灯饰',
      //       '涂料', '吊顶', '五金', '工具', '电料', '管材'
      //     ]
      //   },
      //   {
      //     title: '家电',
      //     content: [
      //       '瓷砖', '地板', '卫浴', '厨房', '门窗', '灯饰',
      //       '涂料', '吊顶', '五金', '工具', '电料', '管材'
      //     ]
      //   },
      //   {
      //     title: '家饰',
      //     content: [
      //       '瓷砖', '地板', '卫浴', '厨房', '门窗', '灯饰',
      //       '涂料', '吊顶', '五金', '工具', '电料', '管材'
      //     ]
      //   }
      // ]
    }
  },
  methods: {
    showPanel () {
      this.$emit('update:Show', true)
    },
    hidePanel () {
      this.$emit('update:Show', false)
    },
    getInfo () {
      var data = this.$cache.get('index')
      if (!data) {
        this.$http.post('public/store/home/list', {}).then(d => {
          if (d.code === 0) {
            this.content = d.data
          }
          this.$cache.set('index', d.data, 86400000)
        })
      } else {
        this.content = data
      }
    }
  },
  mounted () {
    this.getInfo()
  }
}
</script>

<style scoped>
  .typ {
    width: 1200px;
    margin: 0 auto;
  }
  .type {
    width: 280px;
    height: 420px;
    background-color: #f6f6f6;
    position: absolute;
    /*left: 0;*/
    z-index: 5;
    text-align: left;
    box-shadow: -1px 14px 20px -1px rgba(0,0,0,.3);
  }
  .type ul {
    width: 231px;
    margin: 0 auto;
  }
  .type ul li {
    margin-top: 20px;
  }
  .type ul h1 {
    font-size: 14px;
    color: #3e3a39;
  }
  .type span {
    font-size: 12px;
    color: #727171;
    line-height: 20px;
    display: inline-block;
  }
  .type span:first-child {
    color: #d42f31;
  }
  .con {
    margin-top: 7px;
  }
  .type span:after {
    width: 1px;
    height: 13px;
    background-color: #999999;
    content: '';
    display: inline-block;
    margin: 0 6px;
    vertical-align: middle;
  }
  .type span:last-child:after {
    width: 0;
    height: 0;
  }
</style>
