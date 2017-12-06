<template>
  <div class="taskManage item">

       <div class="table">
            <div class="table">
              <el-table
              :data="item"
              stripe
              border
              style="width: 100%">
              <el-table-column
                prop="created_at"
                label="发布日期"
                >
              </el-table-column>
              <el-table-column
                prop="title"
                min-width="100"
                label="任务名称"
                >
              </el-table-column>
              <el-table-column
                prop="work_type"
                label="任务类型"
                width="180">
              </el-table-column>
              <el-table-column
                prop="department"
                label="对口科室">
              </el-table-column>
              <el-table-column
                inline-template
                label="任务状态">
                    <span>{{row.status === 'draft' ? '未审核' : '已审核'}}</span>
              </el-table-column>
              <el-table-column
                width='220'
                inline-template
                label="操作">
                <template v-if="!me.is_super_admin">
                  <el-button-group>
                    <el-button @click="jump(row)" type="primary" size="small">查看</el-button>
                  </el-button-group>
                </template>
                <template v-else>
                    <template v-if="row.status === 'draft'">
                      <el-button-group>
                        <el-button type="success" size="small" @click="auditing(row.id)">审核</el-button>
                        <el-button type="primary" size="small"  @click="modifyTask(row.id)">修改</el-button>
                        <el-button type="danger" size="small" @click="deleteTask(row.id)">删除</el-button>
                        <el-button type="primary" size="small" @click="browseTask(row.id)">查看</el-button>
                      </el-button-group>
                    </template>
                    <template v-else>
                      <el-button type="primary" size="small" @click="browseTask(row.id)">考核</el-button>
                    <el-button type="danger" size="small" @click="cancelAudit(row.id)">取消审核</el-button>
                    </template>
                </template>
                
              </el-table-column>
            </el-table> 
          </div>
     </div>
     <div v-if="item.length > 0" class="footer">
              <div class="page_num_box">
                  显示:
                  <el-select @change="change()" class="page_num" size="small" v-model="perPage">
                      <el-option label="5" :value="5"></el-option>
                      <el-option label="10" :value="10"></el-option>
                      <el-option label="15" :value="15"></el-option>
                      <el-option label="20" :value="20"></el-option>
                      <el-option label="30" :value="30"></el-option>
                      <el-option label="40" :value="40"></el-option>
                  </el-select>
                  项结果
              </div>
              <el-pagination
                class="page"
                layout="prev, pager, next"
                :total="total"
                :current-page="currentPage"
                :page-size="perPage"
                @current-change="change">
              </el-pagination>
          </div>
   </div>
</template>
<script>
export default{
  data () {
    return {
      total: 0,
      perPage: 20,
      currentPage: 1,
      activeName: 'list',
      item: []
    }
  },
  mounted () {
      this.getList();
  },
  computed: {
    me () {
      return this.$store.state.me ? this.$store.state.me : {}
    }
  },
  methods: {
    refresh () {
      this.$nextTick(() => {
          this.getList(this.currentPage);
      })
    },
    jump (row) {
      if(this.me.role_id === 1){
         this.$router.push({name: 'task_item', params: {id: row.id}})
      } else if(this.me.role_id === 2){
         this.$router.push({name: 'task_detail', params: {id: row.id,college: this.me.college_id}})
      } else if(this.me.role_id === 3){
         this.$router.push({name: 'task_information', params: {id: row.id,college: this.me.college_id}})
      }
     
    },
    // 取消审核
      cancelAudit (id) {
        this.$http.get('cancel_audit/' + id).then(res => {
             this.refresh();
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
                 this.refresh();
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
        this.refresh();
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
          this.refresh();
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
      this.$confirm('该操作将恢复该任务。, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$http.get('restore_task/' + id).then(res => {
          this.refresh();
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
              id: id,
              college: this.$store.state.me.college_id
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
    getList (page = 1, sort) {

            this.loading = true;
            this.$http.get('tasks?keywords=' + this.$route.params.state, {
                params: {
                    limit: this.perPage,
                    page
                }
            }).then(res => {
              this.item = res.data.data;
               this.total = res.data.meta.pagination.total;
                this.loading = false;
              }).catch(err => {
                this.loading = false;
            })
    },
    // 恢复任务
    restoreTask (id) {
      this.$confirm('该操作将恢复该任务。, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$http.get('restore_task/' + id).then(res => {
           this.refresh();
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
              id: id,
              college: this.$store.state.me.college_id
          }
      })
    },
    change (currentPage) {
        this.getList(currentPage);
    }
  },
  beforeRouteUpdate (to, from, next) {
      next();
      this.getList();
  }
} 
</script>
<style>
.table{
  margin-top:20px;
}
.footer{
  padding: 15px 20px;
}
.page_num_box{
    font-size: 14px;
    color: #666;
    float: left;
}
.page_num_box .page_num{
    margin: 0 5px;
    width: 70px;
}
.footer .page{
  float: right;
}
</style>