<template>
  <div class="taskManage item">
    <div class="table" v-if="this.taskList.length">
      <el-table
        max-height="720px"
        @row-click="jump('taskDetail')"
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
          width="350"
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
          <template v-if="row.status === 'draft1'">
            <el-button-group>
              <el-button type="success" size="small">审核</el-button>
              <el-button type="primary" size="small"  @click="jump('AddTask')">修改</el-button>
              <el-button type="danger" size="small" @click="remove($index)">删除</el-button>
            </el-button-group>
          </template>
          <template scope="scope" class="operaBtn" v-else>
            <el-button type="primary" size="small">查看</el-button>
          </template>
        </el-table-column>
      </el-table>
      <page></page>
    </div>
    <div class="ifNone" v-else>
      <p>
        当前还没有任务哦，请单击右侧按钮添加任务&emsp;
        <el-button type="primary" icon="plus" @click="jump('AddTask')"></el-button>
      </p>
    </div>
  </div>
</template>
<script>
import page from '../components/page.vue'
export default{
  components: {
    page
  },
  data () {
    return {
      pageOffset: 1,
      taskList: []
    }
  },
  mounted () {
    this.getTaskList()
  },
  methods: {
    remove (index) {
      this.tableData.splice(index, 1)
    },
    jump (address) {
      this.$router.push({name: address})
    },
    getTaskList () {
      this.$http.get('tasks/' + this.pageOffset).then(res => {
        console.log(res.data.data)
        this.taskList = res.data.data
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
