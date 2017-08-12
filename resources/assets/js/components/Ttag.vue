<template>
  <div class="t-tag">
    <div contenteditable="true" class="content">
      {{content}}
    </div>
    <span @click="$emit('on-close')" class="colse">+</span>
  </div>
</template>

<script>
export default {
  props: {
    content: String
  }
}
</script>

<style lang="css">
.t-tag{
  position: relative;
  display: inline-block;
  margin: 0 10px 8px 0;
}
.t-tag>.content{
  display: inline-block;
  background-color: #20a0ff;
  border-color: #20a0ff;
  padding: 6px 8px;
  border-radius: 4px;
  width: auto;
  min-width: 60px;
  color: #fff;
  font-size: 14px;
  outline: none;
}
.t-tag>.colse{
  position: absolute;
  top: -6px;
  right: -7px;
  display: inline-block;
  width: 15px;
  height: 15px;
  text-align: center;
  line-height: 15px;
  font-weight: bold;
  transform: rotate(45deg);
  background-color: #ff4949;
  color: #fff;
  border-radius: 100px;
  cursor: pointer;
  display: none;
}
.t-tag:hover>.colse{display: inline-block;}
</style>
