<template>
  <div class="work_type">
    <h2 class="title">工作类型设置</h2>
    <transition-group name="el-zoom-in-center">
      <Ttag @on-close="deleteWorkType(item.id, index)" :key="item.id" v-for="(item,index) in tags" :content="item.title"></Ttag>
    </transition-group>
    <el-input @keyup.enter.native="addType" @click="addType" class="add_input" icon="plus" v-model="inputVal" placeholder="请输入内容"></el-input>
  </div>
</template>

<script>
import Ttag from '../../components/Ttag.vue'
export default {
  components: {
    Ttag
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
    // 添加工作类型
    addType () {
      this.$http.post('create_work_type',{
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
      this.$http.get('work_types').then(res => {
        this.tags = res.data.data
      })
    },
    // 删除工作类型
    deleteWorkType (id, index) {
      this.$http.delete('delete_work_type/' + id).then(res => {
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
.work_type{
  width: 50%;
  padding: 20px;
  margin: 0 auto;
}
.work_type>.title{
  font-size: 18px;
  color: #555;
  margin-bottom: 30px;
}
.work_type>.add_input{
  width: 130px;
}
</style>
