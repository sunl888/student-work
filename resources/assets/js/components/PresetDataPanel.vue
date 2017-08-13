<template>
  <div class="prese_data_panel">
    <h2 class="title">{{title}}</h2>
    <transition-group name="el-zoom-in-center">
      <Ttag @update="update($event, item.id)" @on-close="deleteWorkType(item.id, index)" :key="item.id" v-for="(item,index) in tags" :content="item.title"></Ttag>
    </transition-group>
    <el-input @keyup.enter.native="addType" @click="addType" class="add_input" icon="plus" v-model="inputVal" placeholder="请输入内容"></el-input>
  </div>
</template>

<script>
import Ttag from './Ttag.vue'
export default {
  components: {
    Ttag
  },
  props: {
    title: String,
    url: String
  },
  data () {
    return {
      inputVal: '',
      tags:[]
    }
  },
  mounted () {
    this.getWorkType()
  },
  methods: {
    // 更新工作类型
    update (newVal, id) {
      this.$http.post('update_' + this.url + '/' + id, {
        title: newVal
      }).then(res => {
        this.$message({
          message: '修改成功',
          type: 'success'
        })
      })
    },
    // 添加工作类型
    addType () {
      this.$http.post('create_' + this.url,{
        title: this.inputVal
      }).then(res => {
        this.inputVal = ''
        this.getWorkType()
        this.$message({
          message: '添加成功',
          type: 'success'
        })
      })
    },
    // 获取工作类型
    getWorkType () {
      this.$http.get(this.url + 's').then(res => {
        this.tags = res.data.data
      })
    },
    // 删除工作类型
    deleteWorkType (id, index) {
      this.$http.get('delete_' + this.url + '/' + id).then(res => {
        this.tags.splice(index, 1)
        this.$message({
          message: '删除成功',
          type: 'success'
        })
      })
    }
  }
}
</script>

<style lang="css">
.prese_data_panel{
  width: 50%;
  padding: 20px;
  margin: 0 auto;
}
.prese_data_panel>.title{
  font-size: 18px;
  color: #555;
  margin-bottom: 30px;
}
.prese_data_panel>.add_input{
  width: 130px;
}
</style>
