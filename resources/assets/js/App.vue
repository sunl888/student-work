<template>
  <div id="app">
      <router-view></router-view>
  </div>
</template>

<script>
</script>

<style>
*{
  margin:0;
  padding:0;
}
body,html{
  width:100%;
  height:100%;
}
body{background-color: #f5f5f5;}
ul{
  list-style:none;
}
a,a:hover,a:visited{
  text-decoration:none;
  color:rgba(0,0,0,0.54);
}
#app {
  width:100%;
  height:100%;
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
}
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
  /* .slide-fade-leave-active for <2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
