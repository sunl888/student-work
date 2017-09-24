<template>
	<div id="main">
		
	</div>
</template>
<script>
import echarts from 'echarts'
export default{
	mounted () {
      // 基于准备好的dom，初始化echarts实例
      var myChart = echarts.init(document.getElementById('main'));
      // 绘制图表
      myChart.setOption({
              title : {
                  text: '最近一个月任务情况'
                  // subtext: '数据来自网络'
              },
              tooltip : {
                  trigger: 'axis'
              },
              legend: {
                  data : ['完成情况', '质量评分'],
              },
              toolbox: {
                  show : true,
                  feature : {
                      mark : {show: true},
                      dataView : {show: true, readOnly: false},
                      magicType: {show: true, type: ['line', 'bar']},
                      restore : {show: true},
                      saveAsImage : {show: true}
                  }
              },
              calculable : true,
              xAxis : [
                  {
                      type : 'value',
                      boundaryGap : [0, 0.01]
                  }
              ],
              yAxis : [
                  {
                      type : 'category',
                      data : ['化学与材料工程学院','生物工程学院','电子工程学院','机械与电气工程学院','计算机学院','经济与管理学院',
                '金融学院','美术与设计学院','文化创意与传播学院','教育学院','法学院','马克思主义学院','外国语学院','体育学院','音乐与舞蹈学院']
                  }
              ],
              series : [
                  {
                      name:'完成情况',
                      type:'bar',
                      data:[15,20,3,5,8,12,24,31,23,5,11,8,4,6,7]
                  },
                  {
                      name:'质量评分',
                      type:'bar',
                      data:[82,71,42,61,77,81,90,68,77,62,97,52,44,84,92]
                  }
              ]      
      })
  }
}

</script>
<style scoped>
	#main{
    width:100%;
    min-height:1200px;
  }
</style>