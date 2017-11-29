<template>
<div>
  <h1 style="padding:10px 0">各学院任务完成情况汇总</h1>
  <div class="query">
    <el-select class="querySelect" clearable @change="getTaskPro()" v-model="query.status" placeholder="按任务状态汇总">
        <el-option
          v-for="(value,index) in taskStatus"
          :key="index" 
          :label="value.title"
          :value="value.status"></el-option>
    </el-select>
    <el-date-picker
    class="querySelect"
      v-model="query.range"
       @change="getTaskPro()"
      type="daterange"
      placeholder="在日期范围内汇总任务">
    </el-date-picker>
    <el-select class="querySelect" clearable @change="getTaskPro()" v-model="query.college_id" placeholder="按学院汇总任务">
        <el-option
                v-for="item in collegesList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
    <el-select class="querySelect" clearable v-model="query.work_type_id" @change="getTaskPro()" placeholder="按任务类型汇总任务">
        <el-option
                v-for="item in workTypeList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
    <el-select class="querySelect" clearable @change="getTaskPro()" v-model="query.department_id" placeholder="按对口科室汇总任务">
        <el-option
                v-for="item in departmentList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
    <el-button icon="upload2" title="导出图表" style="transform:rotate(180deg);" @click="exportTable()"></el-button>
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
            inline-template
            label="操作">
            <template>
              <el-button-group>
                <el-button @click="jump(row)" type="primary" size="small">查看</el-button>
              </el-button-group>
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
      window.open("/api/export2table");
      // this.$http.get('export2table').then(res => {
      //   this.$message.success('导出成功！');
      // }).catch(res => {
      //   this.$message.success(res);        
      // })
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
    refresh () {
      this.$nextTick(() => {
          this.getTaskPro(this.currentPage);
      })
    },
    getTaskPro (page = 1, sort) {
      let url = new Array();
      let i = 1;
      let range = this.query.range.toLocaleString().split(',');
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
        this.query.range.start_date = (range[0] || '').substr(0,range[0].indexOf(' '));
        url[i] = '&start_date='+this.query.range.start_date;
        i++;
      } 
      if (this.query.range.end_date !== null){
        this.query.range.end_date = (range[1] || '').substr(0,range[1].indexOf(' '));
        url[i] = '&end_date='+this.query.range.end_date;
        i++;
      }
      this.url = url.join('');
      this.$http.get(url.join(''),{
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
<style scoped>
	#main{
    width:100%;
    min-height:400px;
    margin-top:20px;
    margin-bottom:20px;
  }
  .query{
    padding:20px 0;
    width:100%;
  }
  .querySelect{
    width:18%;
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