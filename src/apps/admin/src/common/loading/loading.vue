<template>
  <div class="common-loading" v-show="open" :style="get_style()">
    <div class="common-loadding-wrap">
      <h5>
          <i class="fa fa-spinner" v-if="type === 'loading'"></i>
          <i class="fa fa-check-circle" v-if="type === 'success'"></i>
          <i class="fa fa-info-circle" v-if="type === 'info'"></i>
          &nbsp;<span>{{msg}}</span>
      </h5>
    </div>
  </div>
</template>

<style scoped>
.common-loading {
  background: rgba(0, 0, 0, 0.5);
  z-index: 1060;
  position: fixed;
  height: calc(100%);
  width: 100%;
  top: 0px;
}
.common-loadding-wrap {
  position: relative;
  width: 100%;
  height: 100%;
}
.common-loading h5 {
  display: block;
  position: absolute;
  margin: auto;
  height: 50px;
  width: 500px;
  text-align: center;
  left: 0;
  top: 40%;
  right: 0;
  font-size: 16px;
  vertical-align: middle;
  color: #fff;
  font-weight: 350;
}
.common-loading h5 span {
  font-size: 14px;
}
i.fa-spinner {
  display: inline-block;
  -moz-animation: fa-spin 3s infinite linear;
  -o-animation: fa-spin 3s infinite linear;
  -webkit-animation: fa-spin 3s infinite linear;
  animation: fa-spin 3s infinite linear;
}
@-moz-keyframes spin {
    0% {
        -moz-transform: rotate(0deg)
    }
    100% {
        -moz-transform: rotate(359deg)
    }
}

@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
        opacity:0.2;
    }
    100% {
        -webkit-transform: rotate(359deg);
        opacity:1;
    }
}

@-o-keyframes spin {
    0% {
        -o-transform: rotate(0deg);
    }
    100% {
        -o-transform: rotate(359deg)
    }
}

@-ms-keyframes spin {
    0% {
        -ms-transform: rotate(0deg)
    }
    100% {
        -ms-transform: rotate(359deg)
    }
}

@keyframes spin {
    0% {
        transform: rotate(0deg)
    }
    100% {
        transform: rotate(359deg)
    }
}
</style>
<script>

export default {
  data () {
    return {
      open: false,
      msg: '',
      type: 'loading',
      left_offset: 160
    }
  },
  methods: {
    get_style: function () {
      return {
        left: this.left_offset,
        width: 'calc(100% - ' + this.left_offset + ')'
      }
    },
    show: function (opt) {
      this.open = true
      this.msg = opt.msg || '加载中, 请稍后 ...'
      this.type = opt.type || 'loading'
      this.left_offset = opt.left_offset || '160px'
    },
    hide: function () {
      this.open = false
    }
  }
}
</script>
