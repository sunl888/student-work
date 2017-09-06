<template>
    <div class="taskDetail">
        <div class="current">
            <el-card class="box-card">
                <!--头部-->
                <div slot="header" class="clearfix">
                    <h2 style="line-height: 36px;color: #444;">{{'任务名称：' + item.title}}</h2>
                </div>
                <!--任务详情-->
                <div class="text item">
                    <div>发布日期：<span>{{ item.created_at }}</span></div>
                    <div>工作类型：<span>{{ item.work_type }}</span></div>
                    <div> 对口科室：<span>{{ item.department }}</span></div>
                    <div>截止日期：<span>{{ item.end_time }}</span></div>
                    <div>责任人：<span>{{ item.user ? item.user : '尚未指定' }}</span></div>
                    <p class="content"><span style="max-width=100%;">{{ item.detail }}</span></p>
                </div>
                <!--操作按钮-->
                <div class="seal">
                    <span v-if="item.finished_at">已完成</span>
                    <el-button :disabled="!item.assess" @click="isScores = true" type="info">查看评分结果</el-button>
                    <el-dialog title="评分结果" :visible.sync="isScores" class="scoreBox el-col-16 el-col-offset-4">
                        <el-form :label-width="formLabelWidth2" label-position="right">
                            <el-form-item label="完成质量">
                                <p class="scoreRes">{{item.quality}}</p>
                            </el-form-item>
                            <el-form-item label="考核等级">
                                <el-tag :type="color">{{item.assess}}</el-tag>
                            </el-form-item>
                            <el-form-item label="备注">
                                <p class="scoreRes">{{item.remark}}</p>
                            </el-form-item>
                        </el-form>
                    </el-dialog>
                </div>
            </el-card>
        </div>
    </div>
</template>
<script>
    export default{
        data () {
            return {
                color: '',
                //任务详情
                item: [],
                //获取各学院可选责任人
                users: [],
                //是否显示dialog
                isDia: false,
                isAllot: false,
                //是否显示评分结果
                isScores: false,
                //催交情况
                remind: 0,
                //当前选中一级菜单
                currOption: [],
                //当前选中责任人ID
                allot: null,
                //任务提交时是否过了截止日期
                delay: {
                    delayReson: '',
                    isDelay: false,
                    delayMessage: ''
                },
                formLabelWidth: '210px',
                formLabelWidth2: '100px',
                //责任人级联选择器一级菜单
                options: [
                    {
                        name: '全体人员', id: 'all'
                    },
                    {
                        name: '具体单一', id: 'only',
                        children: [
                        ]
                    }
                ],
                prop: {
                    label: 'name',
                    value: 'id'
                }
            }
        },
        methods: {
            //随机生成颜色
            isColor () {
                var color = [
                    'success','warning', 'primary', 'danger', 'success','warning', 'primary', 'danger', 'warning', 'success']
                this.color = color[Math.floor(Math.random()*10)]
            },
            //获取当前选项
            current(){
                if(this.currOption[1]){
                    this.allot = this.currOption[1]
                } else {
                    this.allot = this.currOption[0]
                }
            },
            //判断提交时间是否过了截止日期
            goSubmit () {
                this.$confirm('提交任务后将无法取消, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.get('is_delay/' + this.$route.params.id).then(res => {
                        if (res.data.isDelay) {
                            this.delay.delayMessage = '此任务已经过了截止日期，请填写推迟理由后提交！'
                            this.delay.isDelay = true
                        } else {
                            this.isSubmit()
                        }
                    })
                }).catch(() => {
                    this.$message.info('取消提交任务')
                })
            },
            //去提交任务
            isSubmit(val){
                this.$http.post('submit_task/' + this.$route.params.id,{
                    delay: val
                }).then(res=>{
                    this.$message.success('提交成功,此任务已完成!')
                    this.$router.push({name: 'tasks_of_college'})
                }).catch(res => {
                    this.$message.error(res.message)
                })
            },
            //指定责任人
            appoint () {
                this.$http.post('create_allot_task', {
                    task_id: this.$route.params.id,
                    user_id: this.allot
                }).then(res => {
                    this.isAllot = true
                    this.isDia = false
                    this.loadItem()
                    this.$message.success('指定成功')
                }).catch(res => {
                    this.$message.error('指定失败,请重新操作')
                })
            },
            //获取任务详情()
            loadItem () {
                this.$http.get('task_detail/' + this.$route.params.id).then(res => {
                    this.item = res.data.data
                })
            },
            //获取学院所有用户
            getUsers () {
                this.$http.get('users').then(res => {
                    this.options[1].children = res.data.users
                })
            }
        },
        beforeRouteUpdate (to, from, next) {
            next();
            this.loadItem()
            this.getUsers()
        },
        mounted () {
            this.loadItem()
            this.getUsers()
            this.isColor()
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
    .current>p{
        margin-top:10px;
        text-align:left;
    }
    .scoreBox{
        position:fixed;
        overflow-y:hidden;
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
        min-height:200px;
        padding-bottom:50px;
        font-size: 14px;
    }
    .el-form-item>p{
        text-align:left;
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
    .content{
        text-align:left;text-indent: 2em;
    }
    .delayMessage{
        color:#FF4949;
        text-align:center;
        font-size:12px;
        padding:10px 0;
    }
    .appoint{
        /*margin-top:50px;*/
    }
    .appo{
        margin-right:100px;
    }
    .el-cascader,.el-input{
        margin-left:-200px;
    }
    .seal>.el-button{
        /*position:absolute;*/
        /*bottom:80px;*/
        /*left:50%;*/
        /*transform: translateX(-50%)*/
    }
    .scoreRes{
        text-align:left;
        color:#444;
        margin-left:20px;
    }
    .seal>span{
        position:absolute;
        margin:auto;
        top:0;
        bottom:0;
        left:0;
        right:0;
        display:block;
        width:150px;
        height:60px;
        line-height:60px;
        border:10px solid #FF4949;
        font-size:45px;
        color:#FF4949;
        font-weight:bold;
        transform: rotate(25deg);
        animation: play 0.5s ease;
    }
    @keyframes play{
        from{
            transform:scale(5,5);
        }
        to {
            transform:none;
            transform: rotate(25deg);
        }
    }
</style>
