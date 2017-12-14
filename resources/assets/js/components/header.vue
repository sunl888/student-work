<template xmlns="http://www.w3.org/1999/html">
  <div class="item el-col-24">
    <div class="top el-col-24">
      <img class="el-col-1 logo el-col-push-1" src="../assets/images/logo.png">
      <h2 style="margin:0 20px" class="el-col-8 el-col-push-1">淮南师范学院学生事务进程考核系统</h2>
      <el-input
        placeholder="输入关键字查询系统中的任务"
        icon="search"
        class="search el-col-10 el-col-push-1"
        :on-icon-click="handleIconClick"
        @keyup.enter.native="handleIconClick"
        style="width:35%"
        v-model="state"
        >
      </el-input>
      <el-button @click="logout()" class="btn el-col-2 el-col-push-2">切换账号</el-button>
    </div>
    <el-col class="local">
      <el-breadcrumb separator="/">
        <el-breadcrumb-item v-for="(item, index) in breadcrumbs" :key="index" :to="{ path: item.path }">{{item.title}}</el-breadcrumb-item>
      </el-breadcrumb>
      <div class="operation">
        <el-button :disabled="!me.is_super_admin" :plain="true" type="primary" @click="$router.push({name: 'cahier_create'})">会议记录</el-button>
        <el-button style="margin:0 10px;" :disabled="!me.is_super_admin" type="primary" @click="$router.push({name: 'add_task'})">添加任务</el-button>
        <el-badge :value=unread class="item">
          <el-button style="background:#f5f5f5;" type="text"><i @click="setAlread" style="color:#444;background:#f5f5f5" :title="tips" class="material-icons">notifications</i></el-button>
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
        state: '',
        unread: null,
        breadcrumbs: [],
        unreadData: [],
        tips: null
      }
    },
    computed:{
      me () {
        return this.$store.state.me ? this.$store.state.me : {};
      }
    },
    watch: {
        '$route': 'updateBreadcrumbs'
    },
    methods: {
      handleIconClick () {
        this.$router.push({name: 'query_task',params: {state: this.state}});
      },
      //设为已读
      setAlread () {
        this.$http.get('notifys_as_read').then(
            this.unread = null
        ).then(res => {
            if(this.visible === false) {
                this.unreadData = null
            }
            this.$router.push({name:'notify'})

        })
      },
      //获取未读通知
      unreadNotify () {
        this.$http.get('un_read_notifys').then(res => {
            if(res.data == null){
                this.unread = null
                this.isTips = true
            } else {
                this.isTips = false
                this.unread = res.data.data.length
                if(this.unread > 0) {
                  this.tips = '请查看' + this.unread + '条新通知';
                }else{
                  this.tips = '当前没有新通知';
                }
                this.unreadData = res.data.data.splice(0,3)
            }
        })
      },
      logout () {
          this.$http.get('logout').then(res => {
              this.$router.push({name: 'login'});
          })
      },
      goItem (x) {
        if(this.me.role_id === 2){
            this.$router.push({name: 'task_detail', params:{id: x}})
        } else if(this.me.role_id === 3) {
            this.$router.push({name: 'task_information', params:{id: x}})
        } else {
            this.$router.push({name: 'task_item', params:{id: x}})
        }
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
  margin-top:22px;
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
.el-popover{
    max-height:148px;
}
.el-popover>a{
  cursor:pointer;
  height:30px;
  color:#444;
  overflow: hidden;
  text-overflow:ellipsis;
  white-space: nowrap;
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
  margin-top:5px;
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
