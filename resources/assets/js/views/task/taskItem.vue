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
                <div class="appoint" v-else>
                    <el-button class="appo" @click="isDia = true" type="success">指定责任人</el-button>
                    <el-button @click="goSubmit()" type="info">提交任务</el-button>
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
                formLabelWidth: '210px',
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
                this.$router.push({name: 'going_finish', params: {id: this.$route.params.id}})
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
                }).catch(res => {
                    this.$message.error(res.data.message)
                })
            },
            //获取各学院完成任务进度
            getTaskPro () {
                this.$http.get('task_progress/' + this.$route.params.id).then(res => {
                    this.taskPro = res.data.data
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
    .el-cascader{
        margin-left:-200px;
    }
</style>
