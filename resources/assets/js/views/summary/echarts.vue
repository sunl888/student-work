<template>
<div>
  <div class="query">
    <el-date-picker
      v-model="range"
      type="daterange"
      placeholder="在日期范围内汇总">
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
      range:{
        start_time: null,
        end_time: null
      },
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
  },
  methods: {
    jump (row) {
      this.$router.push({name:'task_item',params: {id: row.id}})
    },
    getData(){
      this.$http.get('echart/lists').then(res => {
        this.item = res.data;
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