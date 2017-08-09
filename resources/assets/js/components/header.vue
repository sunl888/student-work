<template>
  <div class="item el-col-24">
    <div class="top el-col-24">
      <img class="el-col-1 logo el-col-push-2" src="../assets/images/logo.png">
      <h2 class="el-col-3 el-col-push-2">学生处管理系统</h2>
      <el-autocomplete
        icon="search"
        class="inline-input el-col-10 el-col-push-2 search"
        v-model="state1"
        :fetch-suggestions="querySearch"
        placeholder="请输入内容"
        @select="handleSelect"
      ></el-autocomplete>
      <el-button @click="jump('Login')" class="btn el-col-2 el-col-push-3">退出登录</el-button>
    </div>
      <!--<div v-if="this.isMenu" class="menuBox el-col-3">-->
        <!--<el-menu default-active="1" class="el-menu-vertical-demo el-col-24" router>-->
          <!--<el-submenu index="1">-->
            <!--<template slot="title">-->
              <!--<i class="material-icons newIcon">dashboard</i>-->
              <!--<span class="menu_txt">任务管理</span>-->
            <!--</template>-->
            <!--<el-menu-item index="taskManage">任务管理</el-menu-item>-->
            <!--<el-menu-item index="1-1-2">任务考核汇总</el-menu-item>-->
            <!--<el-menu-item index="addTask">添加任务</el-menu-item>-->
          <!--</el-submenu>-->
          <!--<el-menu-item index="2">-->
            <!--<i class="material-icons newIcon">account_box</i>-->
            <!--<span class="menu_txt">用户管理</span>-->
          <!--</el-menu-item>-->
          <!--<el-submenu index="3">-->
            <!--<template slot="title">-->
              <!--<i class="material-icons newIcon">message</i>-->
              <!--<span class="menu_txt">工作通知</span>-->
            <!--</template>-->
            <!--<el-menu-item index="1-3-1">通知公告</el-menu-item>-->
            <!--<el-menu-item index="1-3-2">工作讨论</el-menu-item>-->
          <!--</el-submenu>-->
        <!--</el-menu>-->
      <!--</div>-->
    <el-col :span="24" class="local">
      <el-breadcrumb class="el-col-10 el-col-offset-2" separator="/">
        <span>当前位置 : &emsp;</span>
        <el-breadcrumb-item>任务管理</el-breadcrumb-item>
        <el-breadcrumb-item>任务管理</el-breadcrumb-item>
      </el-breadcrumb>
      <router-link :to="{path: 'home/addTask'}" class="newest el-col-offset-7">添加任务</router-link>
      <a class="newest">最新通知（5）</a>
    </el-col>

  </div>
</template>
<script>
  export default {
    data () {
      return {
        task: [],
        state1: '',
        isMenu: false
      }
    },
    methods: {
      isShow () {
        this.isMenu = !this.isMenu
      },
      jump (x) {
        this.$router.push({name: x})
      },
      querySearch (queryString, cb) {
        var task = this.task
        var results = queryString ? task.filter(this.createFilter(queryString)) : task
        // 调用 callback 返回建议列表的数据
        cb(results)
      },
      createFilter (queryString) {
        return (task) => {
          return (task.value.indexOf(queryString.toLowerCase()) === 0)
        }
      },
      loadAll () {
        return [
          {'value': '暑假留校注意事项'},
          {'value': '考前动员大会'},
          {'value': '学院招生'}
        ]
      },
      handleSelect (item) {
        console.log(item)
      }
    },
    mounted () {
      this.task = this.loadAll()
    }
  }
</script>
<style scoped>
  .item{
    background:white;
  }
  .top{
    height:80px;
  }
  .logo{
    width:60px;
    height:60px;
    margin-top:10px;
  }

  .top h2{
    color:#444;
    font-size:1.4em;
    line-height:80px;
    min-width:200px;
  }
  .search{
    margin-top:20px;
    margin-left:20px;
  }
  .btn{
    margin-top:22.5px;
    min-width:80px;
  }

  .el-submenu .el-menu{
    background-color: white;
  }
  .local{
    height:30px;
    line-height:30px;
    background:#f5f5f5;
    font-size:14px;
    border-top:1px solid lightgrey;
  }
  .el-breadcrumb{
    line-height:30px;
  }
  .el-breadcrumb span, .newest{
    float:left;
  }
  .newest{
    cursor:pointer;
    margin-right:20px;
  }
  .newest:hover{
    color:#20a0ff;
  }
  .el-submenu .el-menu-item{
    min-width: 150px;
  }
</style>
