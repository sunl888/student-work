<template xmlns="http://www.w3.org/1999/html">
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
      <el-button @click="logout()" class="btn el-col-2 el-col-push-3">退出登录</el-button>
    </div>
    <el-col class="local">
      <el-breadcrumb separator="/">
        <el-breadcrumb-item v-for="(item, index) in breadcrumbs" :key="index" :to="{ path: item.path }">{{item.title}}</el-breadcrumb-item>
      </el-breadcrumb>
      <div class="operation">
        <el-button type="primary" @click="$router.push({name: 'add_task'})">添加任务</el-button>
        <el-popover
                ref="unreadBox"
                placement="top"
                width="160"
                v-model="visible">
          <router-link :to="{name: 'task_item', params: {id: value.data.task_id}}" :key="value.id" v-for="value in unreadData">
            {{value.data.message}}
          </router-link>
          <div style="text-align: right; margin: 0">
            <button class="more">
              显示更多通知&emsp;>>
            </button>
          </div>
        </el-popover>
        <el-badge :value=unread class="item">
          <el-button v-popover:unreadBox>最新通知</el-button>
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
        unread: null,
        breadcrumbs: [],
        visible: false,
        unreadData: []
      }
    },
    watch: {
        '$route': 'updateBreadcrumbs',
    },
    methods: {
      //获取未读通知
      unreadNotify () {
        this.$http.get('un_read_notifys').then(res => {
            if(res.data.length === 0){
                this.unread = null
            } else {
                this.unread = res.data.notifications.length
                this.unreadData = res.data.notifications
                console.log(this.unreadData)
            }
        })
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
      logout () {
          this.$http.get('logout').then(res => {
              this.$router.push({name: 'login'})
          })
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
      },
      updateBreadcrumbs () {
        this.breadcrumbs = [];
        this.$route.matched.forEach(item => {
          if(!item.parent || this.formatPath(item.parent.path) != this.formatPath(item.path)){
            this.breadcrumbs.push({path: item.path, title: item.meta.title})
          }
        })
      },
      formatPath (path) {
        if(path.charAt(path.length - 1) != '/'){
          return path + '/';
        }else{
          return path;
        }
      }
    },
    mounted () {
      this.task = this.loadAll(),
      this.updateBreadcrumbs(),
      this.unreadNotify()
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
.el-popover>a{
  height:30px;
  color:#444;
  text-overflow:ellipsis;
  line-height:30px;
  display:block;
  border-bottom:1px dashed #eee;
}
.el-popover>a:hover{
  color:#1d90e6;
}
.more{
  width:100%;
  background:transparent;
  border:none;
  margin-top:20px;
  border:1px solid #bbb;
  font-size:12px;
  color:#bbb;
  padding:5px 0;
  cursor:pointer;
  border-radius:3px;
  outline:none;
}
.more:hover{
  color:#1d90e6;
  border:1px solid #1d90e6;
}
</style>
