<template>
  <div class="menuBox">
    <el-menu router unique-opened theme="dark" default-active="1" >
      <div class="mine">
        <i :title="me.nickname" v-if="me.picture == null" @click="$router.push({name:'user_update'})" style="cursor:pointer;color:white;" class="material-icons">account_circle</i>
        <img :title="me.nickname" @click="$router.push({name:'user_update'})" class="photo" v-else :src="me.picture" alt="">
        <p :title="me.nickname" style="cursor:pointer;" @click="$router.push({name:'user_update'})">{{'您好，' + me.nickname}}</p>
        <p v-if="me.college!=undefined">{{me.college.data.title}}</p>
      </div>
      <el-submenu v-for="values in menus" :index=values.name :key="values.id">
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
import { mapState } from 'vuex'
export default{
  computed:{
    me () {
      return this.$store.state.me ? this.$store.state.me : {};
    },
    menus () {
      return this.$store.state.menus ? this.$store.state.menus : {}; 
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
    overflow: auto;
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
  .photo{
    cursor:pointer;
    width:35px;
    height:35px;
    margin-bottom:10px;
    border-radius:50%;
  }
  .powerd{
    position: absolute;
    bottom: 0;
  }
</style>
