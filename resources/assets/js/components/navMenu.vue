<template>
  <div class="menuBox">
    <el-menu router unique-opened theme="dark" default-active="1" >
      <div class="mine">
        <i class="material-icons">account_circle</i>
        <p>欢迎您，XX老师</p>
      </div>
      <el-submenu index="1">
        <template slot="title">
          <i class="material-icons newIcon">dashboard</i>
          <span class="menu_txt">任务管理</span>
        </template>
        <el-menu-item index="/home/taskManage">任务管理</el-menu-item>
        <el-menu-item index="1-1-2">任务考核汇总</el-menu-item>
        <el-menu-item index="/home/addTask">添加任务</el-menu-item>
      </el-submenu>
      <el-menu-item index="2">
        <i class="material-icons newIcon">account_box</i>
        <span class="menu_txt">用户管理</span>
      </el-menu-item>
      <el-submenu index="3">
        <template slot="title">
          <i class="material-icons newIcon">message</i>
          <span class="menu_txt">工作通知</span>
        </template>
        <el-menu-item index="3-1-1">通知公告</el-menu-item>
        <el-menu-item index="3-1-2">工作讨论</el-menu-item>
      </el-submenu>
      <el-submenu index="4">
        <template slot="title">
          <i class="material-icons newIcon">multiline_chart</i>
          <span class="menu_txt">预置数据</span>
        </template>
        <el-menu-item index="/home/colleges">学院名称设置</el-menu-item>
        <el-menu-item index="/home/workType">工作类型设置</el-menu-item>
        <el-menu-item index="/home/department">对口科室设置</el-menu-item>
        <el-menu-item index="4-1-4">考核等级设置</el-menu-item>
      </el-submenu>
    </el-menu>
  </div>
</template>
<script>

</script>
<style scoped>
  .el-menu{
    border-radius: 0;
    width: 180px;
    transition: transform .3s;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
  }
  .menu{
    font-size:30px;
    line-height:80px;
    margin-left:20px;
    cursor:pointer;
  }
  .newIcon{
    float:left;
    line-height:56px;
  }
  .mine{
    height:80px;
    margin-top:20px;
  }
  .mine i{
    font-size:35px;
    margin-bottom:10px;
  }
  .mine>p{
    font-size: 12px;
    color: #fff;
  }
  .el-menu-item{
    min-width: 180px!important;
  }
</style>
