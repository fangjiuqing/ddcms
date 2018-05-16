<template>
  <div class="content" v-show="panelShow">
    <div class="tasking" @click="hidePanel"></div>
    <div class="confirm">
      <div class="online">
        <h3>在线装修报价</h3>
        <h4>透明套餐价，你不变心我不变价</h4>
        <form action="" class="formdata">
          <div class="chose">
            <input type="text" placeholder="输入房屋面积" class="acreage">
            <span>m²</span>
            <select name="" class="room">
              <option value="" v-for="(item, index) in rooms" :key="index">{{item.room}}</option>
            </select>
            <select name="" class="hall">
              <option value="" v-for="(item, index) in halls" :key="index">{{item.hall}}</option>
            </select>
            <select name="" class="bashroom">
              <option value="" v-for="(item, index) in bashrooms" :key="index">{{item.bashroom}}</option>
            </select>
          </div>
          <input type="text" class="village" placeholder="小区楼盘">
          <input type="text" class="yname" placeholder="您的称呼">
          <input type="text" class="ph" placeholder="您的手机号">
          <input type="text" placeholder="4位数动态验证码" class="code">
          <button class="btn" @click="code">获取验证码</button>
          <div class="submit" @click="info">
            <div>确认提交</div>
          </div>
        </form>
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
      isShow: false,
      rooms: [
        {room: '一室'},
        {room: '二室'},
        {room: '三室'},
        {room: '四室'},
        {room: '五室'},
        {room: '六室'}
      ],
      halls: [
        {hall: '一厅'},
        {hall: '二厅'},
        {hall: '三厅'},
        {hall: '四厅'},
        {hall: '五厅'},
        {hall: '六厅'}
      ],
      bashrooms: [
        {bashroom: '一卫'},
        {bashroom: '二卫'},
        {bashroom: '三卫'},
        {bashroom: '四卫'},
        {bashroom: '五卫'},
        {bashroom: '六卫'}
      ]
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
        pc_area: $('.acreage').val(),
        pc_room0: $('.room').find('option:selected').text(),
        pc_room1: $('.hall').find('option:selected').text(),
        pc_room2: $('.bashroom').find('option:selected').text(),
        pc_local: $('.village').val()
      }).then(d => {
        // console.log('d==========', d)
        if (d.code === 0) {

        } else {
        }
      })
      $('.ph').val('')
      $('.yname').val('')
      $('.acreage').val('')
      $('.room').find('option:selected').text('一室')
      $('.hall').find('option:selected').text('一厅')
      $('.bashroom').find('option:selected').text('一卫')
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
.confirm {
  z-index: 9999;
  width: 450px;
  height: 450px;
  background-color: #f3ede7;
  position: fixed;
  left: 50%;
  top: 50%;
  margin: -225px 0 0 -225px;
}
.online {
  padding: 20px 32px 0 32px;
}
.online h3 {
  font-size: 24px;
  color: #d42f31;
  font-weight: 700;
  text-align: left;
  margin-bottom: 7px;
}
.online h4 {
  font-size: 14px;
  text-align: left;
  margin-bottom: 18px;
}
.formdata {
  text-align: left;
  font-size: 0;
}
.chose {
  display: flex;
  box-sizing: border-box;
}
input {
  box-sizing: border-box;
  border: 0 none;
  outline: none;
  padding: 0 0 0 12px;
}
select {
  padding: 0 0 0 12px;
  border: none;
  outline: none;
}
.acreage {
  box-sizing: border-box;
  width: 110px;
  height: 50px;
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
.room {
  width: 72px;
  height: 50px;
  margin: 0 8px 9px 0;
}
.bashroom, .hall {
  width: 72px;
  height: 50px;
}
.hall {
  margin-right: 9px;
}
.village, .yname, .ph {
  width: 100%;
  height: 50px;
  margin-bottom: 9px;
}
.code {
  width: 252px;
  height: 50px;
}
.btn {
  width: 134px;
  height: 50px;
  border: none;
  outline: none;
  color: #fff;
  background: #d3d3d3;
  vertical-align: top;
  margin-bottom: 13px;
  padding: 0;
  cursor: pointer;
}
.submit {
  width: 58px;
  height: 58px;
  text-align: center;
  border-radius: 50%;
  font-size: 14px;
  border: 0;
  outline: none;
  color: #fff;
  cursor: pointer;
  background-color: #d42f31;
  position: relative;
  margin: 0 auto;
}
.submit div{
  width: 29px;
  height: 29px;
  line-height: 1;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
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
