<template>
    <div class="taskDetail">
        <div class="current">
            <el-card class="box-card">
                <div slot="header" class="clearfix">
                    <h2 style="line-height: 36px;color: #444;">{{'任务名称：' + item.title}}</h2>
                </div>
                <div class="text item">
                    <div>发布日期：<span>{{ item.created_at }}</span></div>
                    <div>工作类型：<span>{{ item.work_type }}</span></div>
                    <div> 对口科室：<span>{{ item.department }}</span></div>
                    <div>截止日期：<span>{{ item.end_time }}</span></div>
                    <p class="content"><span style="max-width=100%;">{{ item.detail }}</span></p>
                </div>
                <el-button v-if="item.status === 'draft'"  class="btn" @click="auditing()" type="success">审核任务</el-button>
                <div class="taskWatch" v-else>
                    <template>
                        <el-table
                                border
                                stripe
                                height="300"
                                :data="taskPro"
                                style="width: 100%">
                            <el-table-column
                                    sortable
                                    prop="college"
                                    label="学院"
                                    min-width="150">
                            </el-table-column>
                            <el-table-column
                                    inline-template
                                    sortable
                                    label="完成时间"
                                    min-width="100">
                                <span>{{row.end_time === null ? '空' : row.end_time}}</span>
                            </el-table-column>
                            <el-table-column
                                    inline-template
                                    sortable
                                    label="责任人">
                                <span>{{row.leading_official === null ? '尚未指定' : row.leading_official}}</span>
                            </el-table-column>

                            <el-table-column
                                    prop="status"
                                    sortable
                                    label="任务状态">
                            </el-table-column>
                            <el-table-column
                                    prop="status"
                                    sortable
                                    inline-template
                                    label="评分结果">
                                <span>{{row.assess === null ? '尚未评分' : row.assess}}</span>
                            </el-table-column>
                            <el-table-column
                                label="操作"
                                inline-template
                                min-width="150">
                                <template class="operaBtn">
                                    <el-button-group>
                                        <el-button size="small" type="danger" :disabled="row.status === '已完成'" @click="reminders(row.college_id)" title="催交">催交</el-button>
                                        <el-button size="small" type="info" :disabled="row.status === '未完成' || row.assess!==null" @click="goScore(row.college_id)" title="评分">评分</el-button>
                                        <el-button size="small" type="success" :disabled="!row.assess" @click="browse(row.college_id)" title="评分">查看</el-button>
                                    </el-button-group>
                                </template>
                            </el-table-column>
                        </el-table>
                    </template>
                </div>
            </el-card>
        </div>
    </div>
</template>
<script>
    export default{
        data () {
            return {
                //任务详情
                item: [],
                //各学院任务进度
                taskPro: [],
                //催交记录
                remind: []
            }
        },
        methods: {
            // 获取各学院完成任务进度
            getTaskPro () {
                this.$http.get('task_progress/' + this.$route.params.id).then(res => {
                    this.taskPro = res.data.data
                })
            },
            // 获取任务详情(管理员)
            loadItem () {
                this.$http.get('task/' + this.$route.params.id).then(res => {
                    this.item = res.data.data
                })
            },
            // 催交
            reminders (x) {
                //获取任务的催交情况
                this.$http.get('reminds/' + this.$route.params.id + '/' + x).then(res => {
                    this.remind = res.data.length + 1
                    if (res.data !== null) {
                        var boxMessage = '这是您第' + this.remind + '次催交此任务，确认后将无法撤销此操作，是否继续?'
                    }
                    this.$confirm(boxMessage, '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        this.$http.post('remind/' + this.$route.params.id + '/' + x).then(res => {
                            this.$message.success('催交成功！')
                        })
                    }).catch(() => {
                        this.$message.info('取消催交')
                    })
                })
            },
            // 跳转任务评分
            goScore (x) {
                this.$router.push({name: 'task_score', params: {id: this.$route.params.id, college_id: x}})
            },
            //查看评分结果
            browse(x){
                this.$router.push({name: 'browse_score',params: {id: this.$route.params.id, college_id: x}})
            },
            // 审核任务
            auditing () {
                this.$confirm('任务审核后将无法删除, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.get('audit_task/' + this.$route.params.id).then(res => {
                        this.$router.push({name: 'task_manage'})
                        this.$message({
                            type: 'success',
                            message: '审核成功!'
                        });
                        this.$refs['boxCard'].refresh()
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消审核'
                    });
                });
            }
        },
        mounted () {
            this.loadItem()
            this.getTaskPro()
        }
    }
</script>
<style scoped>
    .box-card{
        margin-top:20px;
        min-height:450px;
        padding-bottom:30px;
        position:relative;
    }
    .current p{
        margin-top:10px;
        text-align:left;
    }
    .taskDetail{
        height:100%;
        width: 100%;
    }
    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }
    .clearfix:after {
        clear: both
    }
    .text{
        font-size: 14px;
    }
    .operaBtn i{
        cursor:pointer;
    }
    .text>div{
        display:inline;
        color:#888;
        margin-right:25px;
    }
    .text>p.content{
        color:#888;
        padding: 15px 30px;
        line-height: 2;
        font-size: 16px;
        text-indent: 2em;
    }
    .text>div span,.text>p span{
        color:#333;
    }
    .el-card__header{
        padding:5px;
    }
</style>
