<template>
<div>
  <h1 style="padding:10px 0">各学院任务完成情况汇总</h1>
  <div class="query">
    <el-select v-model="query.semester" placeholder="按学期汇总">
      <el-option
        v-for="item in semester"
        :key="item.value"
        :label="item.label"
        :value="item.value">
      </el-option>
    </el-select>
    <el-select v-model="query.schoolYear" placeholder="按学年汇总">
      <el-option
        v-for="item in schoolYear"
        :key="item.value"
        :label="item.label"
        :value="item.value">
      </el-option>
    </el-select>
    <el-date-picker
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
      semester: [{
          value: '1',
          label: '2016-2017学年第一学期'
        }, {
          value: '2',
          label: '2016-2017学年第二学期'
        }, {
          value: '3',
          label: '2015-2016学年第一学期'
        }, {
          value: '4',
          label: '2015-2016学年第二学期'
        }, {
          value: '5',
          label: '2014-2015学年第一学期'
        }],
        schoolYear: [{
          value: '1',
          label: '2016-2017学年'
        }, {
          value: '2',
          label: '2016-2017学年'
        }, {
          value: '3',
          label: '2015-2016学年'
        }, {
          value: '4',
          label: '2015-2016学年'
        }, {
          value: '5',
          label: '2014-2015学年'
        }],
        query:{
           range:{
            start_date: null,
            end_date: null
          },
          semester: '',
          schoolYear: ''
        },
     
      myChart: null,
      finished: [],
      unfinished: [],
      item:[],
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
      if (this.range.start_date !== null){
                // echarts.dispose();
        this.range.start_date = (range[0] || '').substr(0,range[0].indexOf(' '));
        url[i] = '?start_date='+this.range.start_date;
        i++;
      } 
      if (this.range.end_date !== null){
        this.range.end_date = (range[1] || '').substr(0,range[1].indexOf(' '));
        url[i] = '&end_date='+this.range.end_date;
        i++;
      }
      this.$http.get(url.join('')).then(res => {
        this.item = res.data;
        if(this.item.meta.count !== 0){
          for(let x in res.data){
          this.finished.push(res.data[x].finisheds)
          this.unfinished.push(res.data[x].unfinisheds)
          }
          this.finished.pop();
          this.option.series[0].data = this.finished
          this.option.series[1].data = this.unfinished
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