<template>
    <div class="taskManage item">
        <el-tabs v-model="activeName" @tab-click="request" >
            <div class="query">
                <el-select class="querySelect sort_by_date"  @change="getUrl()" clearable v-model="query.college" placeholder="按学院筛选">
                    <el-option
                    v-for="item in collegesList"
                    :key="item.id"
                    :label="item.title"
                    :value="item.id"></el-option>
                </el-select>
                <el-date-picker
                    class="el-col-22"
                    v-model="query.start"
                    type="datetime"
                    @change="getUrl()"
                    placeholder="选择日期时间">
                </el-date-picker>
            </div>
            <el-tab-pane label="用户列表" name="list"  style="width: 20%;float: right;">
                <div class="table metting_text">
                    <currency-list-page ref="list" isPage="false" :queryName="user_url">
                        <template scope="list">
                            <el-table
                                    :data="list.data"
                                    stripe
                                    border
                                    style="width: 150%;max-height:850px;overflow: auto;">
                                <el-table-column
                                    prop="title"
                                    label="学院名称"
                                    sortable
                                >
                                </el-table-column>
                                <el-table-column
                                        label="总得分"
                                        prop="college_total_score"
                                >
                                    <template>
                                    </template>
                                </el-table-column>
                                <el-table-column
                                        label="查看"
                                        inline-template
                                >
                                    <template>
                                        <el-button type="primary" size="mini">查看</el-button>
                                    </template>
                                </el-table-column>                                                                    
                            </el-table>
                        </template>
                    </currency-list-page>
                </div>
            </el-tab-pane>
            <div id="metting_chart"></div>
        </el-tabs>
    </div>
</template>
<script>
    import echarts from 'echarts'
    import ecConfig from 'echarts'; 
    import CurrencyListPage from '../../components/CurrencyListPage'
    export default{
        components: {CurrencyListPage},
        data () {
            return {
                activeName: 'list',
                isProfile: false,
                collegesList: [],
                rolesList: [],
                user_url: 'attendance',
                item: [],
                upload_user: false,
                list: [],
                file_url: null,
                query: {
                    college: null,
                    role: null,
                    nickname: null,
                    name: null,
                    gender: null,
                    start: ''
                },
                zoomSize: 4,
                yChart: null,
                score: [],
                college: [],
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
                    dataZoom: [{
                        type: 'inside'
                    }],
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
        filters: {
          dateFilter (val) {
              var tempStr = new Array()
              tempStr = (val || '').split(' ')
              return tempStr[0]
          }
        },
        // watch: {
        //     'user_url' : 
        // },
        mounted () {
            this.getCollegesList();
            this.getRolesList();
            this.getList(this.user_url);
            this.myChart = echarts.init(document.getElementById('metting_chart'));
        },
        methods: {
            getList(url){
                this.item.splice(0, this.item.length)
                this.$http.get(url).then(res => {
                    for(let i in res.data){
                        this.item.push(res.data[i])
                    }
                    if(this.item.length !== 0){
                        this.score.splice(0,this.score.length);
                        this.college.splice(0,this.college.length);
                        for(let x in this.item){
                            this.score.push(this.item[x].college_total_score)
                            this.college.push(this.item[x].title)
                        }
                        // this.score.pop();
                        this.option.series[1].data = this.score
                        // this.college.pop();
                        this.option.xAxis[0].data = this.college
                        this.myChart = echarts.init(document.getElementById('metting_chart'));
                        this.myChart.setOption(this.option)
                        this.myChart.on('click', this.eConsole);
                        this.myChart.on('dblclick', this.eConsole2);
                        // this.myChart.on('click', function (params) {
                            
                        // });
                    } else {
                    this.myChart.dispose();
                    this.score.splice(0,this.score.length);
                    this.college.splice(0,this.college.length);
                        document.getElementById('metting_chart').innerHTML = '没有数据';
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
                eConsole2(param) {    
                    if (typeof param.seriesIndex == 'undefined') {    
                        return;    
                    }    
                    if (param.type == 'dblclick') {
                    this.$router.push({name: 'cahier_list', params: {id: param.dataIndex+1}});
                    }    
                },
            handleSuccess(response){
                this.file_url = response.path;
                this.upload_user = false;
                this.$refs['list'].refresh();
                this.$message.success('成功导入数据');
            },
            handleError(err){
                this.$message.error('数据错误或重复，请重试');
                this.upload_user = false;
                this.$refs['list'].refresh();
            },
            handleProgress(){
                this.upload_user = true;
            },
            getUrl () {
                let url = new Array();
                let i = 1;
                url[0] = 'attendance?';
                if(this.query.college !== null){
                    url[i] = '&college_id=' + this.query.college;
                    i++;
                }
                if(this.query.start !== null){
                    let datetime = new Array();
                    datetime[0] = this.query.start.toLocaleString().split(' ')[0]
                    datetime[1] = (this.query.start.toLocaleString().split(' ')[1] || '').substr(2)
                    console.log(datetime.join(' '))
                    url[i] = '&start_time=' + datetime.join(' ');
                }
                this.user_url = url.join('');
                this.$refs['list'].refresh();
                this.getList(this.user_url)
            },
            getRolesList () {
                this.$http.get('roles').then(res => {
                    this.rolesList = res.data.data
                })
            },
             // 获取学院
            getCollegesList () {
                this.$http.get('colleges').then(res => {
                    this.collegesList = res.data.data
                })
            },
            //删除用户
            deleteUser (id) {
                this.$confirm('该操作将删除此用户, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.get('delete_user/' + id).then(res => {
                        this.$refs['list'].refresh();
                        this.$message.success('删除成功')
                    })
                }).catch(() => {
                    this.$message.info('已取消删除')
                })
            },
            //查看用户信息
            browserUser (id) {
                this.isProfile = !this.isProfile
                this.$http.get('user/' + id + '?include=roles,college').then(res => {
                    this.item = res.data;
                })
            },
            //修改用户信息
            modifyUser (id) {
                this.$router.push({name: 'edit_user',
                    params: {
                        id
                    }
                })
            },
            //刷新表格
            request (tab) {
                this.$refs[tab.name].refresh();
            }
        }
    }
</script>
<style scoped>
    .taskManage{
        width: 100%;
    }
    .page{
        margin-top: 30px;
    }
    .proCard{
        max-height:400px;
        position:absolute;
        position:fixed;
        margin:auto;
        left:0;
        right:0;
        top:0;
        min-width:280px;
        bottom:0;
        z-index:2000;
    }
    .querySelect.sort_by_date{
        width:16%;
        float: left;
        margin-right: 20px;
    }
    .head{
        height:60px;
        border-bottom:1px solid #eee;
    }
    .head>img{
        width:105px;
        height:105px;
        box-shadow:2px 2px 10px #ccc,
                    -2px -2px 10px #ccc;
    }
    .head>i:hover{
        color:red;
    }
    .head>i{
        cursor:pointer;
    }
    .profile{
        margin-top:75px;
    }
    .profile>p {
        text-align:left;
        margin-bottom:5px;
        color:#777;
        font-size:14px;
    }
    .profile>p>span{
        color:#444;
        font-size:16px;
        display:inline-block;
    }
    #metting_chart{
        width: 78%;
        margin-left: 20px;
        min-height:850px;
        margin-top:20px;
        margin-bottom:20px;
        float: left;
    }
    .metting_text{
        float:right;
        width: 100%;
    }
</style>