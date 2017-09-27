<template>
<div>
  <div class="query">
    <el-date-picker
      v-model="query.range"
       @change="getTaskPro()"
      type="daterange"
      placeholder="在日期范围内汇总任务">
    </el-date-picker>
    <el-select @change="getTaskPro()" v-model="query.college_id" placeholder="按学院汇总任务">
        <el-option
                v-for="item in collegesList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
    <el-select v-model="query.work_type_id" @change="getTaskPro()" placeholder="按工作类型汇总任务">
        <el-option
                v-for="item in workTypeList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
    <el-select @change="getTaskPro()" v-model="query.department_id" placeholder="按对口科室汇总任务">
        <el-option
                v-for="item in departmentList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
  </div>
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
      label="工作类型"
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
          <span>已审核</span>
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

</template>
<script>
export default{
  data () {
    return {
      isTable:false,
      college:[],
      tableData:[],
      workTypeList: [],
      departmentList: [],
      collegesList: [],
      query: {
        range: {
          start_date: null,
          end_date: null,
        },
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
  },
  methods: {
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
    getTaskPro () {
      let url = new Array();
      let i = 1;
      let range = this.query.range.toLocaleString().split(',');
      this.query.range.start_date = (range[0] || '').substr(0,range[0].indexOf(' '));
      this.query.range.end_date = (range[1] || '').substr(0,range[0].indexOf(' '));
            console.log(this.query.range);
      url[0] = 'tasks';
      if (this.query.college_id !== null){
        url[i] = 'include=task_progresses&college='+this.query.college_id;
        i++;
      } 
      if(this.query.work_type_id !== null){
        url[i] = 'work_type_id='+this.query.work_type_id;
        i++;
      } 
      if(this.query.department_id !== null){
        url[i] = 'department_id='+this.query.department_id;
        i++;
      }
      if (this.query.range.start_date !== null){
        url[i] = 'start_date='+this.query.range.start_date;
        i++;
      } 
      if (this.query.range.end_date !== null){
        url[i] = 'end_date='+this.query.range.end_date;
        i++;
      }
      url[i] = 'status=publish';
      this.$http.get(url.join('?')).then(res => {
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
</style>