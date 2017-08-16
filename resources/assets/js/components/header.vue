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
      <el-button @click="jump('login')" class="btn el-col-2 el-col-push-3">退出登录</el-button>
    </div>
    <el-col class="local">
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>首页</el-breadcrumb-item>
        <el-breadcrumb-item>任务管理</el-breadcrumb-item>
      </el-breadcrumb>
      <div class="operation">
        <el-button type="primary" @click="$router.push({name: 'add_task'})">添加任务</el-button>
        <el-badge :value="3" class="item">
          <el-button>最新通知</el-button>
        </el-badge>
      </div>
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
.local{
  position: relative;
  background:#f5f5f5;
  padding: 10px 20px 0;
}
.local>.operation{
  position: absolute;
  top: 8px;
  right: 20px;
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
.el-breadcrumb{
  line-height:30px;
}
.el-breadcrumb span,{
  float:left;
}
.el-submenu .el-menu-item{
  min-width: 150px;
}
</style>
