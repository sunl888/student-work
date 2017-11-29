<template>
  <div class='loginBox el-col-24'>
    <div class='login el-col-4'>
      <h3>淮南师范学院学生事务进程考核系统</h3>
      <div class="form">
          <p>{{wrong}}</p>
        <el-row>
          <el-form class="demo-ruleForm">
            <el-col :span="20" :offset="2">
                <el-input v-model="userName" placeholder="请输入用户名" size="small"></el-input>
            </el-col>
            <el-col :span="20" :offset="2">
              <el-input v-model="userPsw" type="password" placeholder="请输入密码" size="small"></el-input>
            </el-col>
            <el-col class="vaild_code" :span="20" :offset="2">
              <img src="../assets/images/vaildCode.png" alt="">
              <input class="vaild_code_input" @keyup.enter.native="login()" v-model="userCode" type="text" placeholder="请输入验证码" size="small"></input>
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
              userCode: '',
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
              }).catch(err => {
                this.isLoading = false
                for(let i in err.response.data.errors){
                    this.$message({
                      type: 'error',
                      message: err.response.data.errors[i]
                  })  
                }
                                             
              })
          }
      }
  }
</script>
<style scoped>
.login{
  position:absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  min-width:400px;
  overflow:hidden;
  padding-bottom: 20px;
  background:white;
  border-radius: 10px;
}
.el-input{
  margin-left:0;
}
.login h3{
  margin: 40px 0;
  font-size: 18px;
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
.vaild_code{
  height: 40px;
}
.vaild_code img{
  height: 100%;
  float: left;
  width: 29%;
}
.vaild_code_input{
  box-sizing: border-box;
  float: left;
  width: 70%;
  border: none;
  border-top-right-radius: 3px;
  border-bottom-right-radius: 3px;
  border: 1px solid #bfcbd9;
  border-left: none;
  outline: none;
  padding-left:10px;
  height: 40px;
}
  .vaild_code_input:focus{
    border: 1px solid #20a0ff;
    border-left: none;
  }
</style>
