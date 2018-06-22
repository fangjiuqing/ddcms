<template>
  <div class="content" v-show="panelShow">
    <div class="tasking" @click="hidePanel"></div>
    <div class="popUp">
      <img src="../assets/home/popUp.png" alt="" class="popImg">
      <div class="confirm">
        <div class="online">
          <h3>在线装修报价</h3>
          <h4>透明套餐价，你不变心我不变价</h4>
          <form action="" class="formdata">
            <input type="text" class="village" placeholder="请输入楼盘名称">
            <input type="text" class="yname" placeholder="您的姓名">
            <input type="text" class="ph" placeholder="您的手机号">
            <input type="text" placeholder="4位数动态验证码" class="code">
            <button class="btn" @click="code">获取验证码</button>
            <p class="start" @click="info">立即获取报价享优惠</p>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery'
export default {
  name: 'price',
  props: {
    panelShow: {
      type: Boolean
    }
  },
  data () {
    return {
      isShow: false
    }
  },
  mounted () {
    $('.btn').click(function (e) {
      e.preventDefault()
    })
    document.addEventListener('keyup', this.bgc)
  },
  methods: {
    hidePanel () {
      this.$emit('update:panelShow', false)
    },
    info () {
      this.$http.post('public/customer/info', {
        pc_mobile: $('.ph').val(),
        pc_code: $('.code').val(),
        pc_nick: $('.yname').val(),
        pc_local: $('.village').val()
      }).then(d => {
        // console.log('d==========', d)
        if (d.code === 0) {

        } else {
        }
      })
      $('.ph').val('')
      $('.yname').val('')
      $('.code').val('')
      $('.village').val('')
    },
    bgc () {
      if ($('.ph').val() !== '' && $('.code').val() === '') {
        $('.btn').css({'background': 'red'})
      } else {
        $('.btn').css({'background': '#d3d3d3'})
      }
    },
    code () {
      this.$http.post('public/customer/code', {
        verify_mobile: $('.ph').val()
      }).then(d => {
        if ($('.ph').val() === '') {
          alert('手机号不能为空')
        } else {
          alert(d.msg)
        }
      })
      $('.btn').css({'background': '#d3d3d3'})
    }
  }
}
</script>
<style scoped>
  .popUp {
    width: 700px;
    height: 454px;
    position: fixed;
    left: 50%;
    top: 50%;
    margin: -227px 0 0 -350px;
    z-index: 9999;
    overflow: hidden;
  }
  .popImg {
    width: 300px;
    float: left;
  }
  .confirm {
    width: 400px;
    height: 454px;
    background-color: #fff;
    float: left;
  }
  .online {
    padding: 50px 50px 0 50px;
  }
  .online h3 {
    font-size: 24px;
    letter-spacing: 1px;
    color: #363636;
    text-align: left;
    margin-bottom: 12px;
  }
  .online h4 {
    font-size: 14px;
    color: #979797;
    text-align: left;
    margin-bottom: 38px;
  }
  .formdata {
    width: 300px;
    text-align: left;
    font-size: 0;
  }
  input {
    box-sizing: border-box;
    outline: none;
    width: 300px;
    height: 40px;
    border: solid 1px #d6d6d6;
    padding: 0 0 0 12px;
  }
  .formdata span {
    display: inline-block;
    font-size: 16px;
    height: 50px;
    line-height: 50px;
    margin-right: 9px;
    padding-right: 15px;
    background-color: #fff;
  }
  .village, .yname, .ph {
    width: 100%;
    height: 40px;
    margin-bottom: 11px;
  }
  .code {
    width: 200px;
    height: 40px;
  }
  .btn {
    width: 100px;
    height: 40px;
    border: none;
    outline: none;
    color: #fff;
    background: #d3d3d3;
    vertical-align: top;
    padding: 0;
    cursor: pointer;
  }
  .start {
    width: 300px;
    height: 40px;
    background-color: #ce292c;
    font-size: 16px;
    line-height: 40px;
    text-align: center;
    margin: 37px auto 0;
    color: #ffffff;
  }
  .tasking {
    position: fixed;
    z-index: 9998;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.2);
  }
</style>
