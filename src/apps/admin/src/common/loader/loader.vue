<template>
  <div class="common-loading" v-show="open">
    <div class="common-loadding-wrap">
      <h5><i class="fa fa-cog"></i> {{msg}}</h5>
    </div>
  </div>
</template>

<style scoped>
.common-loading {
  background: rgba(0, 0, 0, 0.3);
  z-index: 1000;
  position: fixed;
  width: calc(100%  - 200px);
  height: calc(100% - 50px);
  left: 200px;
  top: 50px;
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
  width: 200px;
  text-align: center;
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  font-size: 36px;
  vertical-align: middle;
  color: #fff;
  font-weight: 150;
}
i.fa {
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
      msg: ''
    }
  },
  created () {
  },
  mounted () {
  },
  methods: {
    show: function (opt) {
      this.open = true
      this.msg = opt.msg
    },
    hide: function () {
      this.open = false
    }
  }
}
</script>
