<template>
<div>
  <h1 style="padding:10px 0">各学院任务完成情况汇总</h1>
  <div class="query">
      <el-select class="el-col-pull-1" @change="getSememter()" v-model="query.schoolYear" clearable placeholder="按学年汇总">
        <el-option
          v-for="item in schoolYear"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
      <el-select class="el-col-pull-1" @change="getMode()" :disabled="query.schoolYear===''" v-model="query.semester" placeholder="按学期汇总">
        <el-option
          v-for="item in semester"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
    <el-date-picker
    :disabled="query.schoolYear!==''"
      v-model="query.range"
      type="daterange"
      @change="getData()"
      placeholder="按日期范围汇总">
    </el-date-picker>
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
      query:{
         range:{
          start_date: null,
          end_date: null
        },
        semester: '',
        schoolYear: ''
      },
      myChart: null,
      score: [],
      item:[],
      option:{
         tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            legend: {
                data:['总分']
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
                    name:'总分',
                    stack: '总分',
                    type:'bar'
                }
            ]   
      }
    }
  },
	mounted () {
    this.getData()
    this.getschoolYear()
    this.myChart = echarts.init(document.getElementById('main'));
  },
  methods: {
    jump (row) {
      this.$router.push({name:'task_item',params: {id: row.id}})
    },
    getData(){
      let url = new Array();
      let i = 1;
      let range = this.query.range.toLocaleString().split(',');
      url[0] = 'echart/lists';
      if (this.query.range.start_date !== null){
                // echarts.dispose();
        this.query.range.start_date = (range[0] || '').substr(0,range[0].indexOf(' '));
        url[i] = '?start_date='+this.query.range.start_date;
        i++;
      } 
      if (this.query.range.end_date !== null){
        this.query.range.end_date = (range[1] || '').substr(0,range[1].indexOf(' '));
        url[i] = '&end_date='+this.query.range.end_date;
        i++;
      }
      this.getList(url.join(''));
    },
    getList(url){
      this.$http.get(url).then(res => {
        this.item = res.data;
        if(this.item.meta.count !== 0){
          for(let x in res.data){
          this.score.push(res.data[x].score)
          }
          this.score.pop();
          this.option.series[0].data = this.score
          // console.log(this.option);
          this.myChart = echarts.init(document.getElementById('main'));
          this.myChart.setOption(this.option)
          this.myChart.on('click', this.eConsole);
        } else {
          this.myChart.dispose();
          document.getElementById('main').innerHTML = '没有数据';
        }
      })
    },
    eConsole(param) {    
        if (typeof param.seriesIndex == 'undefined') {    
            return;    
        }    
        if (param.type == 'click') {
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
        this.getList(url.join(''));
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