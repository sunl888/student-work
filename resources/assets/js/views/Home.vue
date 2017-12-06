<template>
  <div class="home">
    <navMenu></navMenu>
    <div class="content">
      <JHeader></JHeader>
      <div class="info_box">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import JHeader from '../components/header.vue'
import navMenu from '../components/navMenu.vue'
export default {
  data () {
      return {
      }
  },
  watch: {
    '$route' () {
      this.$router.push({name: this.$router.name});
    }
  },
  components: {
    JHeader, navMenu
  },
  methods: {
  }
}
</script>

<style lang="css" scoped>
.home>.content{
  padding-left: 180px;
}
.info_box{
  padding: 10px 15px;
  overflow: hidden;
}
</style>
