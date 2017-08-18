<template>
  <div class="t-tag" :canhover="!contenteditable">
    <div :class="{'user_select_none': !contenteditable}" @blur="update" ref="editableDIv" :contenteditable="contenteditable" class="content">
      {{content}}
    </div>
    <div class="option">
      <span @click="contenteditable = true" class="edit"><i class="el-icon-edit"></i></span>
      <span @click="$emit('on-close')" class="colse"><i class="el-icon-delete"></i></span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    content: String
  },
  data () {
    return {
      contenteditable: false
    }
  },
  methods: {
    update (event) {
      if(this.content.trim() != event.target.innerHTML.trim()){
        this.$emit('update', event.target.innerHTML)
      }
      this.contenteditable = false
    }
  },
  watch: {
    contenteditable (newVal) {
      if(newVal){
        setTimeout(() => {
          this.$refs['editableDIv'].focus();
        },70)
      }
    }
  },
  mounted () {
    this.$refs['editableDIv'].onkeydown = (event) => {
      if(event.keyCode == 13){
        return false
      }
      return true;
    }
  }
}
</script>

<style lang="css" scoped>
.user_select_none{
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.t-tag{
  position: relative;
  display: inline-block;
  margin: 0 10px 8px 0;
}
.t-tag[canhover=true]:hover>.option{display: block;}
.t-tag>.content{
  display: inline-block;
  background-color: #20a0ff;
  padding: 6px 8px;
  border-radius: 4px;
  width: auto;
  min-width: 60px;
  color: #fff;
  font-size: 14px;
  outline: none;
  border: 3px #20a0ff solid;
  transition: all .3s;
}
.t-tag>.content:focus{
  border-style: dashed;
  border-color: #1d86d4;
  background-color: #e4ecf3;
  color: #333;

}
.option{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgb(255, 255, 255);
  border-radius: 3px;
  display: none;
}
.option>span{
  position: absolute;
  top: 0;
  line-height: 37px;
  text-align: center;
  display: inline-block;
  width: 50%;
  cursor: pointer;
  color: #999;
}
.option>span:hover{
  background-color: #f1f1f1;
}
.option>span.edit{
  left: 0;
  border-right: 1px solid #efefef;
}
.option>span.close{
  right: 0;
}

</style>
