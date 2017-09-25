<template>
  <div class='loginBox el-col-24'>
    <div class='login el-col-4'>
      <h3>欢迎使用学生处管理系统</h3>
      <div class="form">
          <p>{{wrong}}</p>
        <el-row>
          <el-form class="demo-ruleForm">
            <el-col :span="20" :offset="2">
                <el-input v-model="userName" placeholder="请输入用户名" size="small"></el-input>
            </el-col>
            <el-col :span="20" :offset="2">
              <el-input @keyup.enter.native="login()" v-model="userPsw" type="password" placeholder="请输入密码" size="small"></el-input>
            </el-col>
          </el-form>
          <el-col :span="12" :offset="6">
            <el-button type="success" @click="login()" class="el-col-24" :loading="this.isLoading">登录</el-button>
          </el-col>
        </el-row>
      </div>
    </div>
  </div>
</template>
<script>
  import { mapState } from 'vuex'
  export default {
      data() {
          return {
              userName: 'xsc',
              userPsw: 'xsc',
              wrong: '',
              isLoading: false
          }
      },
      computed: mapState({
        // 箭头函数可使代码更简练
        menus: state => state.menus
      }),
      methods: {
          login() {
              this.isLoading = true
              this.$http.post('login', {
                  name: this.userName,
                  password: this.userPsw
              }).then(res => {
                  this.isLoading = false
                  this.$router.push({name: 'home'})
              }).catch(res => {
                  this.isLoading = false
                  this.$message({
                      showClose: true,
                      type: 'error',
                      message: message
                  })
              })
          }
      }
  }
</script>
<style scoped>
.login{
  position:absolute;
  margin:auto;
  top:0;
  bottom:100px;
  left:0;
  right:0;
  min-width:400px;
  overflow:hidden;
  height:280px;
  background:white;
  border-radius: 10px;
}
.login h3{
  margin: 40px 0;
  font-size: 22px;
  color: #444;
}
.el-col{
  margin-bottom:15px;
}
.el-button{
  margin-top:15px;
}

@keyframes animatedBackground {
  from { background-position: 0 0; }
  to { background-position: 100% 0; }
}
@-webkit-keyframes animatedBackground {
  from { background-position: 0 0; }
  to { background-position: 100% 0; }
}
.loginBox{
  position: relative;
  width: 100%;
  height: 100%;
  background-color: #c0deed;
  background-image: url(../assets/images/login_bg.jpg);
  background-position: 0px 0px;
  background-repeat: repeat-x;
  animation: animatedBackground 40s linear infinite;
  -ms-animation: animatedBackground 40s linear infinite;
  -moz-animation: animatedBackground 40s linear infinite;
  -webkit-animation: animatedBackground 40s linear infinite;
}
</style>
