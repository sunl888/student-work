<template>
    <div class="taskDetail">
        <div class="current">
            <el-card class="box-card">
                <div slot="header" class="clearfix">
                    <h2 style="line-height: 36px;color: #444;width:80%;margin:0 auto;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{'任务名称：' + item.title}}</h2>
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
                     <currency-list-page :autoRequest="false" ref="list" :queryName="'task/' + this.$route.params.id + '?include=task_progresses'">
                    <template scope="list">
                        <el-table
                                border
                                stripe
                                :data="list.data"
                                height="500"
                                style="width: 100%">
                            <el-table-column
                                    sortable
                                    prop="college"
                                    label="学院"
                                    min-width="150">
                            </el-table-column>
                            <el-table-column
                                    prop="end_time"
                                    sortable
                                    label="完成时间"
                                    min-width="100">
                            </el-table-column>
                            <el-table-column
                                    inline-template
                                    sortable
                                    label="责任人">
                                    <span>
                                        <span v-if="row.leading_official!==null">{{row.leading_official.length === 1 ? (row.leading_official[0].name || '') : (row.leading_official[0].name || '') + '等'+ (row.leading_official.length-1) + '人'}}</span>
                                    <span v-else>尚未指定</span>
                                    </span>
                            </el-table-column>

                            <el-table-column
                                    prop="status"
                                    sortable
                                    label="任务状态">
                            </el-table-column>
                            <el-table-column
                                    inline-template
                                    label="评分结果">
                                    <span>{{row.assess === '尚未评分' ? row.assess:row.assess.title}}</span>
                            </el-table-column>
                            <el-table-column
                                label="操作"
                                inline-template
                                min-width="200">
                                <template class="operaBtn">
                                    <el-button-group>
                        <el-button :disabled="row.assess !== '尚未评分'" type="success" size="small" @click="isAppoints(true, row)">{{!row.leading_official ? '指定责任人' : '修改责任人'}}</el-button>
                                        <el-button size="small" type="danger" :disabled="row.assess !== '尚未评分'" @click="reminders(row)" title="催交">催交</el-button>
                                        <el-button size="small" type="info" :disabled="row.assess !== '尚未评分' || !row.leading_official" @click="goScore(row.college_id)" title="评分">评分</el-button>
                                        <el-button size="small" type="success" :disabled="row.assess === '尚未评分'" @click="browse(row.college_id)" title="评分">查看</el-button>
                                    </el-button-group>
                                </template>
                            </el-table-column>
                        </el-table>
                        <!--指定责任人-->
              <el-dialog title="指定责任人" :visible.sync="isDia" top="10%">
                <el-form>
                  <el-form-item>
                    <el-transfer class="transfer" :titles="['本学院可选责任人', '已选中的责任人']" :value="allot" v-model="currOption" :data="users"></el-transfer>
                  </el-form-item>
                </el-form>
                <div slot="footer" style="margin-top:-50px;" class="dialog-footer">
                  <el-button @click="isDia = false">取 消</el-button>
                  <el-button type="primary" @click="appoint()">确 定</el-button>
                </div>
              </el-dialog>
                    </template>
                     </currency-list-page>
                </div>
            </el-card>
        </div>
    </div>
</template>
<script>
import CurrencyListPage from '../../components/CurrencyListPage'
    export default{
         components: {CurrencyListPage},
        data () {
            return {
                //任务详情
                item: [],
                //各学院任务进度
                taskPro: [],
                //催交记录
                remind: [],
                //催交按钮是否可用
                isRemind: [],
                 //获取各学院可选责任人
                users: [],
                //是否显示dialog
                isDia: false,
                isAllot: false,
 //当前选中一级菜单
                currOption: [],
                //当前选中责任人ID
                allot: '',
                //临时数组，存放row.id
                temp: null,
            }
        },
        watch: {
            temp: function (temp) {
                // this.users = null;
                this.getUsers();
            }
        },
        methods: {
            // 获取各学院完成任务进度
            getTaskPro () {
                this.$http.get('task/' + this.$route.params.id + '?include=task_progresses').then(res => {
                    this.item = res.data.data
                    this.taskPro = res.data.data.task_progresses.data
                })
            },
            // 获取任务详情(管理员)
            // loadItem () {
            //     this.$http.get('task/' + this.$route.params.id).then(res => {
            //         this.item = res.data.data
            //     })
            // },
            // 催交
            reminders (x) {
                //获取任务的催交情况
                this.$http.get('reminds/' + this.$route.params.id + '/' + x.college_id).then(res => {
                    this.remind = res.data.length + 1
                    if (res.data !== null) {
                        var boxMessage = '这是您第' + this.remind + '次催交此任务，确认操作后无法撤销，是否继续?'
                    }
                    this.$confirm(boxMessage, '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        type: 'warning'
                    }).then(() => {
                        this.$http.post('remind/' + this.$route.params.id + '/' + x.college_id).then(res => {
                            this.$message.success('催交成功！十秒后可再次催交')
                        }),
                        x.status = '催交成功！请稍后...',
                        window.setTimeout(() => {
                            x.status =  '未完成'
                        },10000)
                    }).catch(() => {
                        this.$message.info('取消催交')
                    })
                })
            },
            // 跳转任务评分
            goScore (x) {
                this.$router.push({name: 'task_score', params: {id: this.$route.params.id, college_id: x}})
            },
             isAppoints(x, row){
                this.isDia = x
                this.temp = row.college_id
            },
            //指定责任人
            appoint () {
                // Array(this.allot);
                this.users.splice(this.users.length);
                if(this.currOption.length == this.users.length){
                    this.allot = 'all';
                } else if(this.currOption.length == 1){
                    this.allot = String(this.currOption[0])
                } else {
                    this.allot = this.currOption.join(',');
                }
                this.$http.post('create_allot_task/' + this.$route.params.id + '/' + this.temp, {
                    user_id: this.allot
                }).then(res => {
                    this.isAllot = true
                    this.isDia = false
                    this.$message.success('指定成功')
                    this.$refs['list'].refresh()
                })
            },
            //获取学院所有用户
            getUsers () {
                this.users = this.users.splice(this.users.length);
                this.$http.get('users/' + this.temp).then(res => {
                    for(let i in res.data.users)
                    this.users.push({
                        label: res.data.users[i].name,
                        key: res.data.users[i].id
                    })
                })
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
            // this.loadItem()
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
        word-wrap:break-word;
    }
    .text>div span,.text>p span{
        color:#333;
    }
    .el-card__header{
        padding:5px;
    }
</style>
