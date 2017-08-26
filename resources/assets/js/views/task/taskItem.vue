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
                    <div v-if="!isWat">责任人：<span>{{ sortCollege.leading_official ? sortCollege.leading_official : '尚未指定' }}</span></div>
                    <p class="content"><span style="max-width=100%;">{{ item.detail }}</span></p>
                </div>
                <el-button v-if='isDis'  class="btn" @click="auditing()" type="success">审核任务</el-button>
                <div class="taskWatch" v-else-if="isWat">
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
                                    min-width="200">
                            </el-table-column>
                            <el-table-column
                                    inline-template
                                    sortable
                                    label="完成时间"
                                    min-width="130">
                                <span>{{end_time === undefined ? '空' : end_time}}</span>
                            </el-table-column>
                            <el-table-column
                                    inline-template
                                    sortable
                                    label="责任人"
                                    min-width="130">
                                <span>{{row.leading_official === null ? '尚未指定' : row.leading_official}}</span>
                            </el-table-column>

                            <el-table-column
                                    prop="status"
                                    sortable
                                    label="任务状态">
                            </el-table-column>
                            <el-table-column
                                label="操作"
                                inline-template
                                width="130">
                                <template class="operaBtn">
                                    <el-button size="small" :disabled="row.status === '未完成'" @click="goScore(row.id)" title="审核"  class="el-icon-check"></el-button>
                                </template>
                            </el-table-column>
                        </el-table>
                    </template>
                </div>
                <div class="appoint" v-else-if="sortCollege.status === '未完成'">
                    <el-button v-if="!sortCollege.leading_official" class="appo" @click="isDia = true" type="success">指定责任人</el-button>
                    <el-button v-else class="appo" @click="isDia = true" type="success">修改责任人</el-button>
                    <el-button :disabled='!sortCollege.leading_official'  @click="goSubmit()" type="info">提交任务</el-button>
                    <!--指定责任人-->
                    <el-dialog title="指定责任人" :visible.sync="isDia" top="30%">
                        <el-form>
                            <el-form-item label="指定责任人" :label-width="formLabelWidth">
                                <el-cascader
                                        @change="current()"
                                        :options="options"
                                        v-model="currOption"
                                        :props="prop"
                                >
                                </el-cascader>
                            </el-form-item>
                        </el-form>
                        <div slot="footer" style="margin-top:-50px;" class="dialog-footer">
                            <el-button @click="isDia = false">取 消</el-button>
                            <el-button type="primary" @click="appoint()">确 定</el-button>
                        </div>
                    </el-dialog>
                    <!--填写推迟理由-->
                    <el-dialog title="推迟理由" :visible.sync="delay.isDelay" top="30%">
                        <el-form>
                            <el-form-item label="推迟理由" :label-width="formLabelWidth2">
                                <el-input type="textarea" placeholder="请填写推迟理由" v-model="delay.delayReson"></el-input>
                            </el-form-item>
                        </el-form>
                        <div slot="footer" style="margin-top:-50px;" class="dialog-footer">
                            <el-button @click="delay.isDelay = false">取 消</el-button>
                            <el-button type="primary" @click="isSubmit(delay.delayReson)" required>确 定</el-button>
                        </div>
                    </el-dialog>
                </div>
                <div class="seal" v-else>
                    <span>已完成</span>
                </div>
            </el-card>
        </div>
    </div>
</template>
<script>
    export default{
        data () {
            return {
                item: [],
                isDis: true,
                isWat: true,
                isDia: false,
                users: [],
                taskPro: [],
                isAllot: false,
                currOption: [],
                allot: null,
                sortCollege: '',
                delay: {
                    delayReson: '',
                    isDelay: false
                },
                me: 0,
                formLabelWidth: '210px',
                formLabelWidth2: '100px',
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
            current(){
              if(this.currOption[1]){
                  this.allot = this.currOption[1]
              } else {
                  this.allot = this.currOption[0]
              }
            },
            //去提交任务
            goSubmit () {
                this.$http.get('is_delay/' + this.$route.params.id).then(res => {
                    if(res.data.isDelay){
                        this.delay.isDelay = true
                    } else {
                        this.isSubmit()
                    }
                })
            },
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
            //跳转任务评分
            goScore (x) {
              this.$router.push({name: 'task_score', params: {id: x}})
            },
            //指定责任人
            appoint () {
                this.$http.post('create_allot_task', {
                    task_id: this.$route.params.id,
                    user_id: this.allot
                }).then(res => {
                    this.isAllot = true
                    this.isDia = false
                    this.$message.success('指定成功')
                    this.getTaskPro()
                }).catch(res => {
                    this.$message.error('指定失败,请重新操作')
                })
            },
            //获取各学院完成任务进度
            getTaskPro () {
                this.$http.get('task_progress/' + this.$route.params.id).then(res => {
                    this.taskPro = res.data.data
                    this.sortCollege = this.taskPro[this.me]
                    console.log(this.sortCollege)
                })
            },
            //获取任务详情
            loadItem () {
                this.$http.get('task/' + this.$route.params.id).then(res => {
                    this.item = res.data.data
                    if(this.item.status !== 'draft'){
                        this.isDis = false
                        this.isTab = true
                    }
                })
            },
            //获取学院所有用户
            getUsers () {
              this.$http.get('users').then(res => {
                  this.options[1].children = res.data.users
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
                        this.$refs['boxCard'].refresh()
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消审核'
                    });
                });
            },
            getMe () {
                this.$http.get('me').then(res => {
                    this.me = res.data.data.college_id - 1
                    if(!res.data.data.is_super_admin){
                        this.isWat = false
                    }
                })
            }
        },
        mounted () {
            this.loadItem()
            this.getTaskPro()
            this.getMe()
            this.getUsers()
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
    .appoint{
        margin-top:50px;
    }
    .appo{
        margin-right:100px;
    }
    .el-cascader,.el-input{
        margin-left:-200px;
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
