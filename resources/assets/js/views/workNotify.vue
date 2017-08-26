<template>
    <div class="panel el-col-24">
        <div v-if="notify != null">
            <ul class="tag-left">
                <li class="notifyBox el-col-22 el-col-push-1" v-for="value in notify">
                    您有一个新任务:&emsp;
                    <router-link :to="{name: 'task_item', params: {id: value.data.task_id}}">
                        {{value.data.title}}
                    </router-link>
                    <p>
                        <i class="material-icons">av_timer</i>
                        <span>{{'&nbsp;发布时间&emsp;' + value.created_at | dateFilter}}</span>
                    </p>
                </li>
            </ul>



        </div>
        <p v-else>当前没有新通知</p>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                notify: [],
                perPage: 5
            }
        },
        methods: {
            getNotify (page=1,sort) {
                this.$http.get('all_notifys',{
                    params: {
                        limit: this.perPage,
                        page
                    }
                }).then(res => {
                    this.notify = res.data.notifications
                    this.total = res.data.meta.pagination.total;
                })

            }
        },
        filters: {
            dateFilter (val) {
                var tempStr = new Array()
                tempStr = (val || '').split(' ')
                return tempStr[0]
            }
        },
        mounted () {
            this.getNotify()
        }
    }
</script>
<style scoped>
    .panel{
        margin-top:10px;
    }
    .panel>p {
        position:absolute;
        top:50%;
        left:50%;
        transform: translate(-50%,-50%);
        display:block;
    }
    .panel>div{
        min-height: 480px;
    }
    .tag-left{
        margin: 20px;
        padding: 5px;
        min-height:480px;
        border:2px solid #fff;
        position:relative;
        background-color:#FFF;
        /*设置圆角*/
        -webkit-border-radius:5px;
        -moz-border-radius:5px;
        border-radius:5px;
    }
    .tag-left:before,.tag-left:after{
        content:"";
        display:block;
        border-width:15px;
        position:absolute;
        left:-30px;
        top:30px;
        border-style:dashed solid solid dashed;
        border-color:transparent #fff transparent  transparent;
        font-size:0;
        line-height:0;
    }
    .tag-left:after{
        left:-27px;
        border-color:transparent #FFF transparent transparent ;
    }
    .tag-right{
        margin: 20px;
        padding: 5px;
        width:300px;
        height:60px;
        border:2px solid #fff;
        position:relative;
        background-color:#FFF;
        /*设置圆角*/
        -webkit-border-radius:5px;
        -moz-border-radius:5px;
        border-radius:5px;
    }
    .tag-right:before,.tag-right:after{
        content:"";
        display:block;
        border-width:15px;
        position:absolute;
        right:-30px;
        top:20px;
        border-style:dashed solid solid dashed;
        border-color:transparent transparent transparent #fff;
        font-size:0;
        line-height:0;
    }
    .tag-right:after{
        right:-27px;
        border-color:transparent transparent  transparent #FFF ;
    }
    .notifyBox{
        min-height:100px;
        border-bottom:1px solid #e1e4e8;
        padding:25px 20px 0px 20px;
        font-size:14px;
        text-align:left;
        color:#5e5e5e;
    }
    .notifyBox>a{
        color:#444;
    }
    .notifyBox>p>i,.notifyBox>p>span{
        float:left;
        line-height:40px;
    }
</style>