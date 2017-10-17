<template>
  <div class="prese_data_panel">
    <h2 class="title">{{title}}</h2>
    <transition-group name="el-zoom-in-center">
      <Ttag @update="update($event, item.id)" :key="item.id" v-for="(item,index) in tags"  @on-close="deleteWorkType(item.id, index)" :content="item.title"></Ttag>
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
    url: String,
    getUrl: String
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
      if(this.inputVal == newVal){return}
      this.$http.post('update_' + this.url + '/' + id, {
        title: newVal
      }).then(res => {
        this.$message({
          message: '修改成功',
          type: 'success'
        })
      }).catch(err => {
                           for(let i in err.response.data.message){
                                this.$message({
                                  type: 'error',
                                  message: err.response.data.message[i]
                              })  
                            }
                                                         
                          })
    },
    // 添加工作类型
    addType () {
      this.$http.post('create_' + this.url, {
          title: this.inputVal
      }).then(res => {
          this.inputVal = ''
          this.getWorkType()
          this.$message({
              message: '创建成功',
              type: 'success'
          })
      }).catch(err => {
                           for(let i in err.response.data.message){
                                this.$message({
                                  type: 'error',
                                  message: err.response.data.message[i]
                              })  
                            }                         
                          })
    },
    // 获取工作类型
    getWorkType () {
      this.$http.get(this.getUrl).then(res => {
        this.tags = res.data.data
      })
    },
    // 删除工作类型
    deleteWorkType (id, index) {
      this.$confirm('此操作将删除该数据项, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$http.get('delete_' + this.url + '/' + id).then(res => {
          this.tags.splice(index, 1)
          this.$message({
              message: '删除成功',
              type: 'success'
          })
        }).catch(() => {
            this.$message({
                type: 'info',
                message: '已取消删除'
            })
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
