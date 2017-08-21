<template>
  <div class="taskManage item">
    <el-tabs v-model="activeName" @tab-click="request" >
     <el-tab-pane label="任务列表" name="list">
       <div class="table">
         <currency-list-page ref="list" queryName="tasks">
           <template scope="list">
             <el-table
               :default-sort = "{prop: 'date', order: 'descending'}"
               :data="list.data"
               stripe
               border
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
                     <el-button type="primary" size="small" @click="browseTask(row.id)">查看</el-button>
                   </el-button-group>
                 </template>
                 <template scope="scope" v-else>
                   <el-button type="primary" size="small" @click="browseTask(row.id)">查看</el-button>
                   <el-button type="danger" size="small" @click="cancelAudit(row.id)">取消审核</el-button>
                 </template>
               </el-table-column>
             </el-table>
           </template>
         </currency-list-page>
       </div>
     </el-tab-pane>
     <el-tab-pane label="回收站" name="trashed_list">
       <div class="table">
         <currency-list-page :autoRequest="false" ref="trashed_list" queryName="trashed_tasks">
           <template scope="list">
             <el-table
               :default-sort = "{prop: 'date', order: 'descending'}"
               :data="list.data"
               stripe
               border
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
                   <el-button-group>
                     <el-button type="success" size="small" @click="restoreTask(row.id)">恢复</el-button>
                     <el-button type="primary" size="small" @click="force_delete_task(row.id)">永久删除</el-button>
                   </el-button-group>
               </el-table-column>
             </el-table>
           </template>
         </currency-list-page>
       </div>
     </el-tab-pane>
   </el-tabs>
  </div>
</template>
<script>
import CurrencyListPage from '../../components/CurrencyListPage'
export default{
  components: {CurrencyListPage},
  data () {
    return {
      activeName: 'list'
    }
  },
  mounted () {
  },
  methods: {
    // 取消审核
      cancelAudit (id) {
        this.$http.get('cancel_audit/' + id).then(res => {
            this.$refs['list'].refresh()
          this.$message({
              type: 'success',
              message: '已取消对该任务的审核'
          })
        })
    },
    // 硬删除任务
    force_delete_task (id) {
        this.$confirm('此操作将永久删除该任务, 是否继续?', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
        }).then(() => {
            this.$http.get('force_delete_task/' + id).then(res => {
                this.$refs['trashed_list'].refresh();
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
    // 软删除任务
    deleteTask (id) {
      this.$confirm('此操作将把该任务放入回收站, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$http.get('delete_task/' + id).then(res => {
          this.$refs['list'].refresh();
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
    // 审核任务
    auditing (id) {
      this.$confirm('任务审核后将无法删除, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$http.get('audit_task/' + id).then(res => {
          this.$refs['list'].refresh();
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
    // 恢复任务
    restoreTask (id) {
      this.$confirm('该操T作将恢复该任务。, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$http.get('restore_task/' + id).then(res => {
          this.$refs['trashed_list'].refresh();
          this.$message({
            type: 'success',
            message: '恢复成功!'
          });
        })
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消恢复'
        });
      });
    },
      //查看任务
    browseTask (id) {
      this.$router.push({name: 'task_item',
          params: {
              id
          }
      })
    },
    // 修改任务
    modifyTask (id) {
      this.$router.push({name: 'edit_task',
        params: {
          id
        }
      })
    },
    request (tab) {
      this.$refs[tab.name].refresh();
    }
  }
}
</script>
<style scoped>
  .taskManage{
    width: 100%;
  }
  .page{
    margin-top: 30px;
  }
</style>
