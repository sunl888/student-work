<template>
<div>
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
import axios from 'axios'
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
		this.loadItem();
  },
  methods: {
  	loadItem(){
		this.$http.get('tasks?keywords=' + this.$route.params.state).then(res => {
          this.tableData = res.data.data;
        })
  	},
  	beforeRouteUpdate (to, from, next) {
            // next();
           this.loadItem();
    },
    jump (row) {
      this.$router.push({name:'task_item',params: {id: row.id}})
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