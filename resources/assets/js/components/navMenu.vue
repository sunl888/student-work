<template>
  <div class="menuBox">
    <el-menu router unique-opened theme="dark" default-active="1" >
      <div class="mine">
        <i style="color:white;" class="material-icons">account_circle</i>
        <p>{{me.college}}</p>
        <p>{{'您好，' + me.name + '老师'}}</p>
      </div>
      <el-submenu v-for="(values, index) in menus" :index=index :key="values.id">
        <template slot="title" >
          <i class="material-icons newIcon">{{values.icon}}</i>
          <span class="menu_txt">{{values.name}}</span>
        </template>
        <div v-for="value in values.child">
          <el-menu-item :index=value.name :route="{name: value.url}">{{value.name}}</el-menu-item>
        </div>
      </el-submenu>
    </el-menu>
  </div>
</template>
<script>
export default{
    data () {
      return {
          me: '',
          menus: []
      }
    },
    mounted () {
      this.getMe()
      this.getMenu()
    },
    methods: {
        getMe () {
          this.$http.get('me').then(res => {
              this.me = res.data.data

          })
        },
        getMenu () {
          this.$http.get('menus').then(res => {
              this.menus = res.data
          })
        }
    }
}
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
    height:100px;
    margin-top:20px;
  }
  .mine i{
    font-size:35px;
    margin-bottom:10px;
  }
  .mine>p{
    font-size: 12px;
    margin-bottom:5px;
    color: #fff;
  }
  .el-menu-item {
      min-width: 180px !important;
  }
</style>
