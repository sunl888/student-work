<template>
<div class="taskScore">
    <div class="box">
        <div class="taskDetail">
            <el-card  class="box-card">
                <div slot="header" class="clearfix">
                    <p style="line-height: 36px;text-align:center;">{{'任务名称' + item.title}}</p>
                </div>
                <div class="text item left el-col-7">
                    <el-collapse v-model="activeNames">
                        <el-collapse-item title="任务详情" name="1">
                            <p>截止时间：<span>{{ item.end_time }}</span></p>
                            <p>任务要求：<span>{{ item.detail }}</span></p>
                        </el-collapse-item>
                        <el-collapse-item title="任务进程" name="2">
                            <p>负责人：<span>{{ taskPro.leading_official }}</span></p>
                            <p>所属学院：<span>{{ taskPro.college }}</span></p>
                            <p>完成时间：<span>{{ taskPro.end_time}}</span></p>
                            <p>推迟理由：<span>{{ taskPro.delay  }}</span></p>
                        </el-collapse-item>
                    </el-collapse>
                </div>
                <div class="text item right el-col-17">
                    <el-form>
                        <el-form-item label="完成质量">
                            <el-radio class="radio" v-model="score.qutity" label="1">很差</el-radio>
                            <el-radio class="radio" v-model="score.qutity" label="2">一般</el-radio>
                            <el-radio class="radio" v-model="score.qutity" label="3">良好</el-radio>
                            <el-radio class="radio" v-model="score.qutity" label="4">优秀</el-radio>
                        </el-form-item>
                        <el-form-item label="存在问题">
                            <el-input
                                    class="el-col-20"
                                    type="textarea"
                                    :rows="2"
                                    placeholder="请简述任务存在问题"
                                    v-model="score.question">
                            </el-input>
                        </el-form-item>
                        <el-form-item label="工作提醒">
                            <el-select v-model="default1">
                                <el-option
                                    v-for="value in option"
                                    :value="value.value"
                                    :key="value.value"
                                    :label="value.title"
                                ></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item class="cuijiao" label="催交情况">
                            <p>2017-5-30 15:30:54 催交一次</p>
                            <p>2017-6-7 8:15:30 催交一次</p>
                            <p>2017-6-20 12:21:02 催交一次</p>
                            <p>2017-8-2 17:28:21 催交一次</p>
                        </el-form-item>
                        <el-form-item label="考核打分">
                            <el-radio-group v-model="value5">
                                <el-radio-button label="很差"></el-radio-button>
                                <el-radio-button label="一般"></el-radio-button>
                                <el-radio-button label="良好"></el-radio-button>
                                <el-radio-button label="优秀"></el-radio-button>
                            </el-radio-group>
                        </el-form-item>
                        <el-form-item class="el-col-push-2">
                            <el-button type="info">提交</el-button>
                            <el-button :plain="true" type="info" class="el-col-push-1">重置</el-button>
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
                activeNames: '',
                score: {
                    qutity: '1',
                    question: ''
                },
                option: [
                    {value: 'metionRecord', title: '提醒记录'},
                    {value: 'metionList', title: '预警通知单'}
                ],
                default1: 'metionRecord',
                value4: null,
                value5: '',
                item: [],
                taskPro: []
            }
        },
        methods: {
            //获取任务详情
            loadItem () {
                this.$http.get('task/' + this.$route.params.id).then(res => {
                    this.item = res.data.data
                })
            },
            //获取任务进程
            getTaskPro () {
                this.$http.get('task_progress/' + this.$route.params.id).then(res => {
                    this.taskPro = res.data.data[this.$route.params.college_id-1]
                })
            }
        },
        mounted () {
            this.loadItem()
            this.getTaskPro()
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
        min-height:470px;
        height:100%;
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
    .cuijiao p{
        margin-left:2em;
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
    }
    .left{
        min-height:500px;
        border-right:1px solid lightgray;
        padding:0px 35px;
    }
    .el-textarea{
        width:90%;
    }
    .el-collapse-item__content{
        color:#888;
    }
    .el-collapse-item>p span{
        color:#333;
    }
</style>
