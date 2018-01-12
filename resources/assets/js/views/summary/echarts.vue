<template>
<div>
  <h1 style="padding:10px 0">淮南师范学院二级学院任务完成情况汇总图示</h1>
  <span style="color: #666;font-size: 15px;"><strong style="color: red;">*</strong> 默认显示当前学期的任务</span>
  <div class="query">
      <el-select class="query_select query_select_new" @change="getSememter()" v-model="query.schoolYear" clearable placeholder="按学年汇总">
        <el-option
          v-for="item in schoolYear"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
      <el-select class="query_select query_select_new" @change="getMode()" :disabled="query.schoolYear===''" v-model="query.semester" placeholder="按学期汇总">
        <el-option
          v-for="item in semester"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
      <div class="date_range">
        <el-date-picker
          :disabled="query.schoolYear!==''"
            class="query_select query_select_new"
            v-model="query.range.start_date"
            type="date"
            placeholder="请选择开始日期">
        </el-date-picker>
        <span>至</span>
        <el-date-picker
          :disabled="query.schoolYear!==''"
            class="query_select query_select_new"
            v-model="query.range.end_date"
            type="date"
            @change="getData()"
            placeholder="请选择结束日期">
        </el-date-picker>
      </div>
      <el-select class="query_select query_select_new" @change="getMode()" v-model="query.work" placeholder="按工作类型汇总" clearable>
        <el-option
          v-for="item in workTypeList"
          :key="item.id"
          :label="item.title"
          :value="item.id">
        </el-option>
      </el-select>
  </div>
  <div id="main">
  </div>
</div>

</template>
<script>
import echarts from 'echarts'
import ecConfig from 'echarts';  
export default{
  data () {
    return {
      semester: [],
      schoolYear: [],
      workTypeList: [],
      query:{
         range:{
          start_date: null,
          end_date: null
        },
        work: '',
        semester: '',
        schoolYear: ''
      },
      zoomSize: 4,
      myChart: null,
      score: [],
      college: [],
      item:[],
      option:{
        tooltip : {
          trigger: 'axis',
          axisPointer : {            // 坐标轴指示器，坐标轴触发有效
              type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
          }
        },
        legend: {
          data:['所有任务的总得分情况'],
          textStyle:{  
            fontWeight:"bolder",  
            color:"#000",
            
            fontSize: 18
          }
        },
        grid: {
          left: '3%',
          right: '4%',
          bottom: '40%',
        },
        xAxis : [{
          clickable : true,
          type : 'category',
          axisLabel:{  
            interval:0,
            formatter:function(value)
            {
                return value.split("").join("\n");
            },
            margin:10, 
            textStyle:{  
              fontWeight:"bolder",  
              color:"#000",
              fontSize: 18
            }
          },
          z: 10
        }],
        yAxis: {
          axisLine: {
            show: true
          },
          axisTick: {
            show: true
          },
          axisLabel: {
            textStyle: {
              color: '#999'
            }
          }
        },
        dataZoom: [
          {
            type: 'inside'
          }
        ],
        series : [
          { // For shadow
            type: 'bar',
            itemStyle: {
              normal: {color: 'rgba(0,0,0,0.05)'}
            },
            barGap:'-100%',
            barCategoryGap:'40%',
            animation: false,
            data: ['100%']
          },
          {
            // name:'总分',
            clickable : true,
            name:'所有任务的总得分情况',
            stack: '所有任务的总得分情况',
            type:'bar',
            itemStyle: {
              normal: {
                label: {  
                  show: true,//是否展示  
                  position:'top',
                  textStyle: {  
                    fontWeight:'bolder',  
                    fontSize : '16',
                    color:'red',
                    fontFamily : '微软雅黑',  
                  }  
                } ,
                color: new echarts.graphic.LinearGradient(
                  0, 0, 0, 1,
                  [
                      {offset: 0, color: '#83bff6'},
                      {offset: 0.5, color: '#188df0'},
                      {offset: 1, color: '#188df0'}
                  ]
                )
              },
              emphasis: {
                color: new echarts.graphic.LinearGradient(
                  0, 0, 0, 1,
                  [
                      {offset: 0, color: '#2378f7'},
                      {offset: 0.7, color: '#2378f7'},
                      {offset: 1, color: '#83bff6'}
                  ]
                )
              }
            }
          }
        ]   
      }
    }
  },
	mounted () {
    this.getData()
    this.getschoolYear()
    this.getWorkTypeList()
    this.myChart = echarts.init(document.getElementById('main'));
  },
  methods: {
    jump (row) {
      this.$router.push({name:'task_item',params: {id: row.id}})
    },
    getData(){
      let url = new Array();
      let i = 1;
      let start_date = (this.query.range.start_date || '').toLocaleString().split(' ')[0];
      let end_date = (this.query.range.end_date || '').toLocaleString().split(' ')[0];
      console.log(start_date, end_date);
      url[0] = 'echart/lists';
      if (this.query.range.start_date !== null){
        // echarts.dispose();
        url[i] = '?start_date='+ start_date;
        i++;
      } 
      if (this.query.range.end_date !== null){
        url[i] = '&end_date=' + end_date;
        i++;
      }
      this.score.splice(0,this.score.length);
      this.college.splice(0,this.college.length);
      this.getList(url.join(''));
    },
    getList(url){
      this.score.splice(0,this.score.length);
      this.college.splice(0,this.college.length);
      this.$http.get(url).then(res => {
        this.item = res.data;
        if(this.item.meta.count !== 0){
           this.score.splice(0,this.score.length);
      this.college.splice(0,this.college.length);
          for(let x in this.item){
          this.score.push(this.item[x].score)
          this.college.push(this.item[x].college_name)
          }
          this.score.pop();
          this.option.series[1].data = this.score
          this.college.pop();
          this.option.xAxis[0].data = this.college
          // console.log(this.option);
          this.myChart = echarts.init(document.getElementById('main'));
          this.myChart.setOption(this.option)
          this.myChart.on('click', this.eConsole);
          this.myChart.on('dblclick', this.eConsole2);
          // this.myChart.on('click', function (params) {
              
          // });
        } else {
          this.myChart.dispose();
                this.score.splice(0,this.score.length);
      this.college.splice(0,this.college.length);
          document.getElementById('main').innerHTML = '没有数据';
        }
      })
    },
    eConsole(param) {    
        // if (typeof param.seriesIndex == 'undefined') {    
        //     return;    
        // }    
        if (param.type == 'click') {
          this.myChart.dispatchAction({
                  type: 'dataZoom',
                  startValue: this.college[Math.max(param.dataIndex -this.zoomSize / 2, 0)],
                  endValue: this.college[Math.min(param.dataIndex + this.zoomSize / 2, this.score.length - 1)]
              });
          
        }    
    },
     // 获取工作类型列表
    getWorkTypeList () {
      this.$http.get('work_types').then(res => {
        this.workTypeList = res.data.data
      })
    },
    eConsole2(param) {    
        if (typeof param.seriesIndex == 'undefined') {    
            return;    
        }    
        if (param.type == 'dblclick') {
           this.$router.push({name: 'char_table', params: {id: param.dataIndex+1}});
        }    
    },
    getschoolYear(){
      this.$http.get('semesters').then(res => {
        for(let i in res.data){
          this.schoolYear.push({
            label: res.data[i].title,
            value: res.data[i].id,
            start_time: res.data[i].start_time.substr(0,res.data[i].start_time.indexOf(' ')),
            end_time: res.data[i].end_time.substr(0,res.data[i].end_time.indexOf(' ')),
            childs: res.data[i].childs
          })
        }
      })
    },
    getSememter(){
      this.query.semester = '';
      this.semester.splice(0,this.semester.length);
      for(let i in this.schoolYear){
          if(this.query.schoolYear === this.schoolYear[i].value){
            for(let j in this.schoolYear[i].childs){
              this.semester.push({
                label:this.schoolYear[i].childs[j].title,
                value: this.schoolYear[i].childs[j].id,
                start_time: this.schoolYear[i].childs[j].start_time.substr(0,this.schoolYear[i].childs[j].start_time.indexOf(' ')),
                end_time: this.schoolYear[i].childs[j].end_time.substr(0,this.schoolYear[i].childs[j].end_time.indexOf(' '))
              })
            }
          }
        }
        let url = new Array();
        let i = 1;
        url[0] = 'echart/lists';
        for(let z in this.schoolYear){
          if(this.schoolYear[z].value === this.query.schoolYear){
            url[i] = '?start_date='+this.schoolYear[z].start_time;
            i++;
            url[i] = '&end_date='+this.schoolYear[z].end_time;
          }
        }
              this.score.splice(0,this.score.length);
      this.college.splice(0,this.college.length);
        this.getList(url.join(''));
      },
    getMode(){
       let url = new Array();
       let i = 1;
        url[0] = 'echart/lists';
        for(let z in this.semester){
          if(this.semester[z].value === this.query.semester){
            url[i] = '?start_date='+this.semester[z].start_time;
            i++;
            url[i] = '&end_date='+this.semester[z].end_time;
          }
        }
              this.score.splice(0,this.score.length);
      this.college.splice(0,this.college.length);
        this.getList(url.join(''));
    }
  }
}

</script>
<style >
	#main{
    width:100%;
    min-height:850px;
    margin-top:20px;
    margin-bottom:20px;
  }
  .query{
    padding:20px 0;
    width:100%;
  }
  .query_select_new{
    width: 21%!important;
  }
</style>