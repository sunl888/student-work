<template>
<div>
  <h1 style="padding:10px 0">淮南师范学院二级学院任务完成情况汇总</h1>
    <span style="color: #666;font-size: 15px;"><strong style="color: red;">*</strong> 默认显示当前学期的任务</span>
  <div class="query">
    <div class="date_range">
      <el-date-picker
          class="query_select"
          v-model="query.range.start_date"
          type="date"
          placeholder="请选择开始日期">
      </el-date-picker>
      <span>至</span>
      <el-date-picker
          class="query_select"
          v-model="query.range.end_date"
          type="date"
          @change="getTaskPro()"
          placeholder="请选择结束日期">
      </el-date-picker>
    </div>
    <el-select class="query_select" clearable @change="getTaskPro()" v-model="query.status" placeholder="按任务状态汇总">
        <el-option
          v-for="(value,index) in taskStatus"
          :key="index" 
          :label="value.title"
          :value="value.status"></el-option>
    </el-select>
    <el-select class="query_select" clearable @change="getTaskPro()" v-model="query.college_id" placeholder="按学院汇总任务">
        <el-option
                v-for="item in collegesList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
    <el-select class="query_select" clearable v-model="query.work_type_id" @change="getTaskPro()" placeholder="按任务类型汇总任务">
        <el-option
                v-for="item in workTypeList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
    <el-select class="query_select" clearable @change="getTaskPro()" v-model="query.department_id" placeholder="按对口科室汇总任务">
        <el-option
                v-for="item in departmentList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
    <el-button icon="upload2" title="导出图表" style="transform:rotate(180deg);float: left;" @click="exportTable()"></el-button>
  </div>
  <div class="table">
        <div class="table">
          <el-table
          :data="tableData"
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
            prop="status"
            inline-template
            label="任务状态">
                <span>{{row.status === 'publish' ? '已审核' : '未审核'}}</span>
          </el-table-column>
          <el-table-column
                width='220'
                inline-template
                label="操作">
                <template>
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
  <div v-if="tableData.length > 0" class="footer">
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
import axios from 'axios'
export default{
  data () {
    return {
      activeName: 'list',
      isTable:false,
      college:[],
      tableData:[],
      workTypeList: [],
      departmentList: [],
      total: 0,
      url:'',
      perPage: 20,
      currentPage: 1,
      collegesList: [],
      taskStatus: [
        {title: '已审核', status: 'publish'},
        {title: '未审核', status: 'draft'}
      ],
      query: {
        range: {
          start_date: null,
          end_date: null,
        },
        status: null,
        work_type_id: null,
        department_id: null,
        college_id:null
      }
    }
  },
	mounted () {
    this.getTaskPro()
    this.getWorkTypeList()
    this.getDepartmentsList()
    this.getCollegesList()
    if(this.autoRequest){
      this.getTaskPro();
    }
  },
  methods: {
    exportTable(){
      this.url.splice(0,1)
      console.log(this.url)
      window.open('/api/export2table?' + this.url);

      // this.$http.get('export2table').then(res => {
      //   this.$message.success('导出成功！');
      // }).catch(res => {
      //   this.$message.success(res);        
      // })
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
    refresh () {
      this.$nextTick(() => {
          this.getTaskPro();
      })
    },
    jump (row) {
      if(this.me.roles.data[0].id === 1){
         this.$router.push({name: 'task_item', params: {id: row.id}})
      } else if(this.me.roles.data[0].id === 2){
         this.$router.push({name: 'task_detail', params: {id: row.id,college: this.me.college.data.id}})
      } else if(this.me.roles.data.id === 3){
         this.$router.push({name: 'task_information', params: {id: row.id,college: this.me.college.data.id}})
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
        // 修改任务
    modifyTask (id) {
      this.$router.push({name: 'edit_task',
        params: {
          id
        }
      })
    },
      //查看任务
    browseTask (id) {
      this.$router.push({name: 'task_item',
          params: {
              id: id,
              college: this.$store.state.me.college.data.id
          }
      })
    },
    // 获取工作类型列表
    getWorkTypeList () {
      this.$http.get('work_types').then(res => {
        this.workTypeList = res.data.data
      })
    },
    // 获取对口科室列表
    getDepartmentsList () {
      this.$http.get('departments').then(res => {
        this.departmentList = res.data.data
      })
    },
     // 获取学院
    getCollegesList () {
        this.$http.get('colleges').then(res => {
            this.collegesList = res.data.data
        })
    },
    jump (row) {
      this.$router.push({name:'task_item',params: {id: row.id}})
    },
    change (currentPage) {
      this.getTaskPro(currentPage);
    },
    getTaskPro (page = 1, sort) {
      let url = new Array();
      let i = 1;
      let start_date = (this.query.range.start_date || '').toLocaleString().split(' ')[0];
      let end_date = (this.query.range.end_date || '').toLocaleString().split(' ')[0];
      url[0] = 'tasks?';
      if(this.query.status !== null){
         url[i] = 'status='+this.query.status;
         i++;
      }
      if (this.query.college_id !== null){
        url[i] = '&include=task_progresses&college='+this.query.college_id;
        i++;
      } 
      if(this.query.work_type_id !== null){
        url[i] = '&work_type_id='+this.query.work_type_id;
        i++;
      } 
      if(this.query.department_id !== null){
        url[i] = '&department_id='+this.query.department_id;
        i++;
      }
      if (this.query.range.start_date !== null){
        // this.query.range.start_date = (range[0] || '').substr(0,range[0].indexOf(' '));
        url[i] = '&start_date='+start_date;
        i++;
      } 
      if (this.query.range.end_date !== null){
        // this.query.range.end_date = (range[1] || '').substr(0,range[1].indexOf(' '));
        url[i] = '&end_date='+end_date;
        i++;
      }
      this.url = url;
      this.$http.get(this.url.join(''),{
        params: {
          limit: this.perPage,
          page
        }
      }).then(res => {
        this.total = res.data.meta.pagination.total;
        this.tableData = res.data.data
      }) 
    }
  }
}

</script>
<style >
	#main{
    width:100%;
    min-height:400px;
    margin-top:20px;
    margin-bottom:20px;
  }
  .query{
    overflow: hidden;
    padding:10px 0;
    width:100%;
    /* margin: 10px 0; */
  }
  .query_select{
    float: left;
    width:15%;
    margin-right: 10px;
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
.date_range{
  width: 30%;
  background: #fff;
  border: 1px solid #bfcbd9;
  border-radius: 4px;
  margin-right: 10px;
}
.date_range,.date_range>span{
  float: left;
}
.date_range>span{
  width: 8%;
  box-sizing: border-box;
  padding: 5px;
  color: #888;
  display: inline-block;
}
.date_range>.query_select{
  width: 46%!important;
  border: none;
  margin-right: 0px;
}
.date_range .el-input__icon+.el-input__inner{
  border: none!important;
}
</style>