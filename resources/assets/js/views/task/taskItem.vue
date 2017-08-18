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
                    <!--<div> 负责人：<span>{{  }}</span></div>-->
                    <div>截止日期：<span>{{ item.end_time }}</span></div>
                    <p class="content"><span>{{ item.detail }}</span></p>
                </div>
                <el-button class="btn" ref="draBtn" @click="auditing()" :disabled=isDis type="success">审核任务</el-button>
            </el-card>
        </div>
    </div>

</template>
<script>
    export default{
        data () {
            return {
                item: [],
                isDis: false
            }
        },
        methods: {
            //获取任务详情
            loadItem () {
                this.$http.get('task/' + this.$route.params.id).then(res => {
                    this.item = res.data.data
                    if(this.item.status !== 'draft'){
                        this.isDis = true
                    }
                })
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
        }
    }
</script>
<style scoped>
    .box-card{
        margin-top:20px;
        min-height:450px;
        padding-bottom:30px;
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
        margin-bottom:100px;
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
