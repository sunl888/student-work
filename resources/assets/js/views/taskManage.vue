<template>
  <div class="taskManage item">
    <el-tabs v-model="activeName">
     <el-tab-pane label="任务列表" name="first">
       <div class="table" v-if="this.taskList.length">
         <el-table
           max-height="720px"
           :default-sort = "{prop: 'date', order: 'descending'}"
           :data="taskList"
           border
           stripe
           style="width: 100%">
           <el-table-column
             prop="created_at"
             sortable
             label="发布日期"
             width="120">
           </el-table-column>
           <el-table-column
             prop="title"
             sortable
             label="任务名称"
             width="320"
           >
           </el-table-column>
           <el-table-column
             prop="work_type"
             label="工作类型"
             width="120"
             sortable
           >
           </el-table-column>
           <el-table-column
             prop="department"
             label="对口科室"
             width="120"
             sortable
           >
           </el-table-column>
           <el-table-column
             inline-template
             sortable
             label="状态"
             width="100"
           >
           <span>{{row.status === 'draft' ? '未审核' : '已审核' }}</span>
           </el-table-column>
           <el-table-column
             prop="end_time"
             label="截止时间"
             width="120"
             sortable
           ></el-table-column>
           <el-table-column
             label="操作"
             inline-template>
             <template v-if="row.status === 'draft'">
               <el-button-group>
                 <el-button type="success" size="small" @click="auditing(row.id)">审核</el-button>
                 <el-button type="primary" size="small"  @click="modifyTask(row.id)">修改</el-button>
                 <el-button type="danger" size="small" @click="deleteTask(row.id)">删除</el-button>
                 <el-button type="primary" size="small" @click="jump('taskDetail')">查看</el-button>
               </el-button-group>
             </template>
             <template scope="scope" class="operaBtn" v-else>
               <el-button type="primary" size="small" @click="jump('taskDetail')">查看</el-button>
             </template>
           </el-table-column>
         </el-table>
         <!-- 分页 -->
         <el-pagination
           layout="prev, pager, next"
           :total="50">
         </el-pagination>
       </div>
       <div class="ifNone" v-else>
         <p>
           当前还没有任务哦，请单击右侧按钮添加任务&emsp;
           <el-button type="primary" icon="plus" @click="jump('addTask')"></el-button>
         </p>
       </div>
     </el-tab-pane>
     <el-tab-pane label="回收站" name="second">
       回收站
     </el-tab-pane>
   </el-tabs>
  </div>
</template>
<script>

export default{
  data () {
    return {
      activeName: 'first',
      pageOffset: 1,
      taskList: []
    }
  },
  mounted () {
    this.getTaskList()
  },
  methods: {
    // 添加任务
    deleteTask (id) {
      this.$confirm('此操作将永久删除该任务, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$http.get('delete_task/' + id).then(res => {
          this.getTaskList()
          this.$message({
            type: 'success',
            message: '删除成功!'
          });
        })
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消删除'
        });
      });
    },
    jump (address) {
      this.$router.push({path: address})
    },
    // 获取任务列表
    getTaskList () {
      this.$http.get('tasks/' + this.pageOffset).then(res => {
        this.taskList = res.data.data
      })
    },
    // 审核任务
    auditing (id) {
      this.$confirm('任务审核后将无法删除, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$http.get('audit_task/' + id).then(res => {
          this.getTaskList()
          this.$message({
            type: 'success',
            message: '审核成功!'
          });
        })
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消审核'
        });
      });
    },
    // 修改任务
    modifyTask (id) {
      this.$router.push({path: 'home/addTask',
        params: {
          id
        }
      })
    }
  }
}
</script>
<style scoped>
  .taskManage{
    width: 100%;
  }
  .el-table th{
    text-align:center;
  }
  .el-form-item__content{
    line-height:30px;
    margin-left:40px;
  }
  .table{
    background:#f5f5f5;
  }
  .active{
    color:red;
  }
  .operaBtn i{
    width:14px;
    height:14px;
  }
  .el-table{
    cursor:pointer;
  }

</style>
