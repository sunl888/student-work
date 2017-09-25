<template>
<div>
  <div class="query">
    <el-date-picker
      v-model="query.range"
      type="daterange"
      placeholder="在日期范围内汇总任务">
    </el-date-picker>
    <el-select v-model="query.work_type" placeholder="按工作类型汇总任务">
        <el-option
                v-for="item in workTypeList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
    <el-select v-model="query.department" placeholder="按对口科室汇总任务">
        <el-option
                v-for="item in departmentList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
    <el-select v-model="query.college" placeholder="按学院汇总任务">
        <el-option
                v-for="item in collegesList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
    </el-select>
  </div>
  <div id="main">
  </div>
  <div v-if="isTable" class="table">
    <el-table
    :data="tableData"
    stripe
    border
    style="width: 100%">
    <el-table-column
      prop="title"
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
      label="任务状态">
    </el-table-column>
    <el-table-column
      prop="status"
      inline-template
      label="操作">
      <template>
        <el-button-group>
          <el-button @click="jump(row)" type="primary">查看</el-button>
        </el-button-group>
      </template>
    </el-table-column>
  </el-table>
  </div>
</div>

</template>
<script>
import echarts from 'echarts'
import ecConfig from 'echarts';  
export default{
  data () {
    return {
      isTable:false,
      finished: [],
      unfinished: [],
      college:[],
      tableData:[],
      workTypeList: [],
      departmentList: [],
      collegesList: [],
      query: {
        range: null,
        work_type: null,
        department: null,
        college:null
      },
      option:{
         tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                data:['已完成','未完成']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    clickable : true,
                    type : 'category',
                    data : ['化工',' 文化', '生工', ' 教育', '电工', '法学院',' 机电', '马克思','计算机','外国语', '经管', '体育','金融', '音乐','美院']
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    clickable : true,
                    name:'已完成',
                    stack: '已完成',
                    type:'bar'
                },
                {
                    clickable : true,
                    name:'未完成',
                    type:'bar',
                    stack: '未完成'
                }
            ]   
      }
    }
  },
	mounted () {
    this.getData()
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
      this.$router.push('task_item/' + row.id)
    },
    getData(){
      this.$http.get('echart/lists').then(res => {
        for(let x in res.data){
          this.finished.push(res.data[x].finisheds)
          this.unfinished.push(res.data[x].unfinisheds)
        }
        this.finished.pop();
        this.option.series[0].data = this.finished
        this.option.series[1].data = this.unfinished
        var myChart = echarts.init(document.getElementById('main'));
        myChart.setOption(this.option)
        myChart.on('click', this.eConsole);
      })
    },
    eConsole(param) {    
        if (typeof param.seriesIndex == 'undefined') {    
            return;    
        }    
        if (param.type == 'click') {
          this.isTable = true,
            this.getTaskPro(param.dataIndex) 
            //获取任务进程
             
        }    
    },
    getTaskPro (x) {
        this.$http.get('tasks/').then(res => {
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