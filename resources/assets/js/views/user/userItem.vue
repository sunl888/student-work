<template>
    <div class="taskDetail">
        <div class="current">
            <el-card class="box-card">
                <div class="personList el-col-16 el-col-push-4">
                    <div class="pic">
                        <img v-if="item.picture" :src="item.picture" alt="">
                        <!--<h3>没有头像</h3>-->
                    </div>
                    <div class="list">
                        <p>{{'用户名: ' + item.name}}</p>
                        p
                    </div>
                </div>
            </el-card>
        </div>
    </div>
</template>
<script>
    export default{
        data () {
            return {
                item: []
            }
        },
        methods: {
            //获取任务详情
            loadItem () {
                this.$http.get('user/' + this.$route.params.id).then(res => {
                    this.item = res.data.data
                })
            }
        },
        mounted () {
            this.loadItem()
        }
    }
</script>
<style scoped>
    .pic{
        width:150px;
        height:150px;
        float:right;
        border:2px dashed #9d9d9d;
    }
    .personList{
        margin-top:30px;
    }
    .list{
    }
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
