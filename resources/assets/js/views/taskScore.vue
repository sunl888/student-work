<script src="../api.js"></script>
<template>
<div class="taskScore">
    <div class="el-col-19 el-col-offset-1 box">
        <div class="taskDetail">
            <el-card  class="box-card">
                <div slot="header" class="clearfix">
                    <p style="line-height: 36px;text-align:center;">{{detail.title}}</p>
                </div>
                <div class="text item left el-col-7">
                    <el-collapse v-model="activeNames">
                        <el-collapse-item title="任务详情" name="1">
                            <p>截止时间：<span>{{ tableData.zip }}</span></p>
                            <p>任务要求：<span>{{ tableData.item }}</span></p>
                        </el-collapse-item>
                        <el-collapse-item title="任务进程" name="2">
                            <p>负责人：<span>{{ detail.responser }}</span></p>
                            <p>推迟理由：<span>{{ detail.delayReason }}</span></p>
                            <p>完成情况：<span>{{ detail.situation   }}</span></p>
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
                tableData: {
                    createDate: '2017-06-21',
                    name: '暑期留校注意事项',
                    province: '常规工作',
                    city: '学生管理',
                    address: '学院负责人',
                    zip: '2017-07-06',
                    addFile: '有',
                    item: '随后，许江荣和全体党员职工一起学习了习近平总书记在中共中央政治局第三十三次集体学习时发表的重要讲话：严肃党内政治生活净化党内政治生态、为全面从严治党打下重要政治基础。学习了王岐山在贵州检查工作时的讲话：当好党内政治生态“护林员”，以新面貌新气象迎接十九大。会议结合《关于组织开展庆祝中国共产党成立96周年纪念活动的通知》精神，讨论了下一步学习与实践活动计划。 '
                },
                detail: {
                    title: '暑期留校注意事项',
                    responser: '孙龙',
                    delayReason: '早上起晚了',
                    situation: '就暑期留校注意事项开了个大会，详细通知到了各负责老师并落实到每个留校学生'
                },
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
                value5: ''
            }
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
