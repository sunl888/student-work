<template>
<div class="taskScore">
    <div class="box">
        <div class="taskDetail">
            <el-card  class="box-card">
                <div slot="header" class="clearfix">
                    <p style="line-height: 36px;text-align:center;">{{'任务名称：&emsp;' + item.title}}</p>
                </div>
                <div class="text item left el-col-7">
                    <el-collapse v-model="activeNames">
                        <el-collapse-item title="任务详情" name="1">
                            <p>截止时间：<span>{{ item.end_time }}</span></p>
                            <p>任务要求：<span>{{ item.detail }}</span></p>
                        </el-collapse-item>
                        <el-collapse-item title="任务进程" name="2">
                            <p>负责人：<span v-if="alloter > 1">{{taskPro.leading_official[0].nickname  + '等共' + alloter + '人'}}</span>
                                <span v-else>{{taskPro.leading_official ? taskPro.leading_official[0].nickname : ''}}</span></p>
                            <p>所属学院：<span>{{ taskPro.college }}</span></p>
                        </el-collapse-item>
                    </el-collapse>
                </div>
                <div class="text item right el-col-17">
                    <el-form v-if="isScores" label-position="right"  label-width="80px" :rules="rules" :model="formData">
                        <el-form-item prop="finishedDate" label="完成日期">
                            <el-date-picker
                              v-model="formData.finishedDate"
                              align="right"
                              type="date"
                              placeholder="选择完成日期">
                            </el-date-picker>
                        </el-form-item>
                        <el-form-item prop="finishedDate" label="是否迟交">
                            <el-switch
                              v-model="isDelay"
                               on-text="是"
                              off-text="否"
                              on-color="#13ce66"
                              off-color="#ff4949">
                            </el-switch>
                        </el-form-item>
                         <el-form-item prop="delayReson" v-if="isDelay" label='推迟理由'>
                            <el-input
                                    class="el-col-19"
                                    type="textarea"
                                    :rows="1"
                                    v-model="formData.delayReson">
                            </el-input>
                        </el-form-item>
                        <el-form-item prop="quality" label="完成情况">
                            <el-input
                                    type="textarea"
                                    :rows="2"
                                    placeholder="请简述任务的完成情况"
                                    v-model="formData.quality">
                            </el-input>
                        </el-form-item>
                        <el-form-item class="remind" label="催交情况">
                            <p v-if=!remind.length>没有催交记录</p>
                            <div v-else>
                                <p v-for="value in remind">{{value.created_at + '&emsp;催交一次'}}</p>
                                <p v-if="isExpend" v-for="value in modRemind">{{value.created_at + '&emsp;催交一次'}}</p>
                                <a v-if="remindCount>0" class="expendRecord" @click="isExpend=!isExpend">{{ isExpend ? '收起' + this.remindCount + '条记录' : '展开剩余' + this.remindCount + '条记录'}}</a>
                            </div>
                        </el-form-item>
                        <el-form-item prop="access_id"  label="考核打分">
                            <el-radio-group v-model="formData.access_id">
                                <el-radio-button v-for="value in access" :key="value.id" :label="value.id">{{value.title}}</el-radio-button>
                            </el-radio-group>
                        </el-form-item>
                        <el-form-item label='备注' prop="remark">
                            <el-input
                                    class="el-col-19"
                                    type="textarea"
                                    :rows="1"
                                    v-model="formData.remark">
                            </el-input>
                        </el-form-item>
                        <el-form-item class="el-col-push-2">
                            <el-button type="info" @click="goScore()">提交</el-button>
                            <el-button :plain="true" type="info" class="el-col-push-1">重置</el-button>
                        </el-form-item>
                    </el-form>
                    <el-form v-else label-position="right"  label-width="80px" :rules="rules" :model="formData">
                        <el-form-item prop="quality" label="完成时间">
                            <p>{{taskPro.end_time ? taskPro.end_time[0] : ''}}</p>
                        </el-form-item>
                        <el-form-item prop="finishedDate" label="是否迟交">
                            <el-switch
                              v-model="isDelay"
                              on-color="#13ce66"
                              off-color="#ff4949"
                              on-text="是"
                              off-text="否"
                              disabled
                              >
                            </el-switch>
                        </el-form-item>
                         <el-form-item prop="delayReson" v-if="taskPro.delay!==null" label='推迟理由'>
                            <p>{{taskPro.delay}}</p>
                        </el-form-item>
                        <el-form-item prop="quality" label="完成情况">
                            <p>{{taskPro.quality}}</p>
                        </el-form-item>
                        <el-form-item class="remind" label="催交情况">
                            <p v-if=!remind.length>没有催交记录</p>
                            <div v-else>
                                <p v-for="value in remind">{{value.created_at + '&emsp;催交一次'}}</p>
                                <p v-if="isExpend" v-for="value in modRemind">{{value.created_at + '&emsp;催交一次'}}</p>
                                <a v-if="remindCount>0" class="expendRecord" @click="isExpend=!isExpend">{{ isExpend ? '收起' + this.remindCount + '条记录' : '展开剩余' + this.remindCount + '条记录'}}</a>
                            </div>
                        </el-form-item>
                        <el-form-item prop="access_id"  label="考核打分">
                            <el-tag style="font-size: 15px;" size="medium" :type="color">{{taskPro.assess ? taskPro.assess.title : ''}}</el-tag>
                        </el-form-item>
                        <el-form-item label='备注'>
                            <p>{{taskPro.remark}}</p>
                        </el-form-item>
                    </el-form>
                </div>
            </el-card>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data () {
            return {
                activeNames: ['1','2'],
                // 任务详情
                item: [],
                alloter:null,
                // 任务进程
                taskPro: [],
                // 获取考核等级
                access: [],
                // 催交情况
                remind: [],
                remindCount: 0,
                //是否展开
                isExpend: false,
                //随机生成颜色
                color: '',
                //未展开的记录
                modRemind: [],
                isDelay: false,
                isDelays:false,
                // 表单数据
                formData: {
                    finishedDate: null,
                    delayReson: null,
                    quality: '',
                    access_id: null,
                    remark: ''
                },
                //判断页面内容
                isScores: true,
                //表单规则
                rules: {
                    quality: [
                        { type: 'string', required: true, message: '请输入完成质量', trigger: 'blur' }
                    ],
                    access_id: [
                        { type: 'number', required: true, message: '请选择考核等级', trigger: 'blur' }
                    ],
                    finishedDate: [
                        { type: 'date', required: true, message: '请选择完成日期', trigger: 'blur' }
                    ],
                    delayReson: [
                        { type: 'string', required: true, message: '请填写推迟理由', trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            //随机生成颜色
            isColor () {
                var color = [
                    'success','warning', 'primary', 'danger']
                this.color = color[Math.floor(Math.random()*4)]
            },
            //判断页面内容
            isScore () {
              if(this.$route.name === 'browse_score'){
                  this.isScores = false
              }
            },
            //获取任务进程
            getTaskPro () {
                this.$http.get('task/' + this.$route.params.id + '?include=task_progresses').then(res => {
                    this.item = res.data.data
                    this.taskPro = res.data.data.task_progresses.data[this.$route.params.college_id-1]
                    if(this.taskPro.delay!==null)this.isDelay = true;
                    this.alloter = this.taskPro.leading_official ? this.taskPro.leading_official.length : '';
                    this.taskPro.end_time = (this.taskPro.end_time || '').split(' ');
                })
            },
            //获取此任务的催交情况
            getRemind () {
                this.$http.get('reminds/' + this.$route.params.id + '/' + this.$route.params.college_id).then(res => {
                    let temp = res.data.reverse()
                    this.remind = temp.slice(0,3)
                    this.modRemind = temp.slice(3)
                    this.remindCount = temp.length - 3
                })
            },
            //任务评分
            goScore () {
                this.$http.post('submit_task/' + this.$route.params.id + '/' + this.$route.params.college_id,{
                    assess_id: this.formData.access_id,
                    quality: this.formData.quality,
                    status: this.formData.finishedDate,
                    remark: this.formData.remark,
                    delay: this.formData.delayReson
                }).then(res => {
                    this.$message.success('成功评分！')
                    this.$router.go(-1);
                }).catch(err => {
                            for(let i in err.response.data.message){
                                this.$message({
                                  type: 'error',
                                  message: err.response.data.message[i]
                              })  
                            } 
                                                         
                          })
            },
            //获取考核等级
            getAccess () {
                this.$http.get('appraises/examines').then( res=> {
                    this.access = res.data.data
                })
            }
        },
        mounted () {
            this.getTaskPro()
            this.getRemind()
            this.getAccess()
            this.isScore()
            this.isColor()
        }
    }
</script>
<style scoped>
    .taskScore {
        padding-bottom:20px;
    }
    .box{
        margin-top:20px;
    }
    .el-card{
        text-align:left;
        padding-bottom:15px;
    }
    .taskScore,.score,.box{
        min-height:550px;
    }
    .text {
        font-size: 14px;
    }
    .left p{
        margin-bottom:5px;
        overflow : hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
    }
    .left>.el-collapse{
        margin-bottom:10px;
    }
    .item {
        margin-top:20px;
    }
    .remind p{
        /*margin-left:6em;*/
    }
    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }
    .clearfix:after {
        clear: both
    }
    .left,.right{
        height:100%;
    }
    .right{
        padding-left:35px;
        border-left:1px solid lightgray;
    }
    .left{
        min-height:350px;
        padding:0px 35px;
    }
    .el-textarea{
        width:80%;
    }
    .el-collapse-item__content{
        color:#888;
    }
    .el-collapse-item>p span{
        color:#333;
    }
    .expendRecord{
        cursor:pointer;
    }
    .expendRecord:hover{
        color:#1D8CE0;
    }
</style>
