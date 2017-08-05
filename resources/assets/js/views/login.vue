<template>
  <div class='loginBox el-col-24'>
    <div class='login el-col-4'>
      <h3>欢迎使用学生处管理系统</h3>
      <div class="form">
        <el-row>
          <el-form class="demo-ruleForm">
            <el-col :span="20" :offset="2">
                <el-input placeholder="请输入用户名" size="small"></el-input>
            </el-col>
            <el-col :span="20" :offset="2">
              <el-input type="password" placeholder="请输入密码" size="small"></el-input>
            </el-col>
          </el-form>
          <el-col :span="12" :offset="6">
            <el-button type="success" @click="jump(1)" class="el-col-24" size="small" :loading="this.isLoading">登录</el-button>
          </el-col>
        </el-row>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        restaurants: [],
        name: '',
        psd: '',
        isLoading: false
      }
    },
    mounted () {
    },
    methods: {
      jump () {
        console.log(this.x)
        this.isLoading = true
        window.setTimeout(() => {
          this.isLoading = false
          if (this.x === 0) {
            this.$router.push({name: 'TaskManage'})
          } else {
            this.$router.push({name: 'TaskManage'})
          }
        }, 3000)
      }
    }
  }
</script>
<style scoped>
  .loginBox{
    position:fixed;
    top:0;
    left:0;
    height:100%;
    background:url('../assets/images/login_bg.jpg');
    background-size:cover;
  }
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
    box-shadow:1px 1px 5px 1px #bbb,
                -1px -1px 5px #bbb;
  }
  .login h3{
    margin:40px 0;
  }
  .el-col{
    margin-bottom:15px;
  }
  .el-button{
    margin-top:15px;
  }
</style>
