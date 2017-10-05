<template>
<div>
  <div class="query">
    <el-date-picker
      v-model="range"
      type="daterange"
      placeholder="在日期范围内汇总"
      disabled>
    </el-date-picker>
    <el-button style="position:absolute;right:100px;" @click="$router.back()" type="text">回到图表</el-button>
  </div>
  <div class="table">
         <currency-list-page ref="list" :queryName="'tasks?include=task_progresses&college='+this.$route.params.id+'&status=publish'"> 
          <template scope="list">
            <div class="table">
              <el-table
              :data="list.data"
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
                label="工作类型">
              </el-table-column>
              <el-table-column
                prop="department"
                label="对口科室">
              </el-table-column>
              <el-table-column
                inline-template
                label="任务状态">
                <span>已审核</span>
              </el-table-column>
              <el-table-column
                prop="status"
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
          </template>
       </currency-list-page>
  </div>
</div>

</template>
<script> 
import CurrencyListPage from '../../components/CurrencyListPage'
export default{
  components: {CurrencyListPage},
  data () {
    return {
      tableData:[],
      activeName: 'list',
      range:{
      	start_time: null,
      	end_time: null 
      },
      total: 0,
      perPage: 20,
      currentPage: 1,
    }
  },
	mounted () {
  if(this.autoRequest){
    this.getTaskPro();
  }
  },
  methods: {
    change (currentPage) {
      this.getTaskPro(currentPage);
    },
    refresh () {
      this.$nextTick(() => {
          this.getTaskPro(this.currentPage);
      })
    },
  	jump (row) {
      this.$router.push({name:'task_item',params: {id: row.id}})
    },
    // getTaskPro (page = 1, sort) {
    //   this.$http.get('tasks?include=task_progresses&college='+this.$route.params.id+'&status=publish',{
    //     params: {
    //       limit: this.perPage,
    //       page
    //     }
    //   }).then(res => {
    //     this.total = res.data.meta.pagination.total;
    //       this.tableData = res.data.data
    //   })
    // }
  }
}

</script>
<style scoped>
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