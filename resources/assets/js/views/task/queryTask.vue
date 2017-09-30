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
      isTable:false,
      college:[],
      total: 0,
      perPage: 20,
      currentPage: 1,
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
  watch:{
    '$route' () {
      this.loadItem();
    }
  },
	mounted () {
		this.loadItem();
    if(this.autoRequest){
      this.getList();
    }
  },
  methods: {
    change (currentPage) {
      this.loadItem(currentPage);
    },
    refresh () {
      this.$nextTick(() => {
          this.loadItem(this.currentPage);
      })
    },
  	loadItem(page=1, sort){
		this.$http.get('tasks?keywords=' + this.$route.params.state,{
       params: {
          limit: this.perPage,
          page
        }
    }).then(res => {
          this.tableData = res.data.data;
          this.total = res.data.meta.pagination.total;
        })
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