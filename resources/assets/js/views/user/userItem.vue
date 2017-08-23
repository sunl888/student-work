<template>
    <div class="taskDetail">
        <div class="current">
            <el-card class="box-card">
                <div slot="header" class="clearfix card_head">
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
    .el-card{
       background:url('../../assets/images/item_bg.jpg') 100% 100%;
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
    .card_head{
        height:200px;
        backgound:grey;
    }
</style>
