s<template>
    <div class="taskDetail">
        <div class="current">
            <el-card class="box-card">
                <!--头部-->
                <div slot="header" class="clearfix">
                    <h2 style="line-height: 36px;color: #444;width:80%;margin:0 auto;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{'会议名称：' + item.title}}</h2>
                </div>
                <!--任务详情-->
                <div class="text item">
                    <div class="cahierProps">
                        <span>会议时间：{{ item.start_time }}</span>
                        <span>会议地点：{{ item.address }}</span>
                        <span>会议考核分数：{{ item.detail_of_colleges[0] }}</span>
                        <span v-if="isPeople">参会人员：全体人员</span>
                    </div>
                    <p class="content"><span style="color: #aaa;">会议内容：</span> <span style="max-width=100%;">{{ item.detail }}</span></p>
                </div>
                <div class="table">
                    <h3 style="margin-bottom: 10px;color: #444;">会议出勤情况</h3>
                    <template>
                      <el-table
                        :data="absent"
                        :default-sort="{prop: 'attention', order: 'descending'}"
                        stripe
                        border
                        style="width: 100%">
                        <el-table-column
                          prop="name"
                          label="应参会人员(工号)"
                          min-width="80">
                        </el-table-column>
                        <el-table-column
                          prop="nickname"
                          label="应参会人员(昵称)"
                          min-width="180">
                        </el-table-column>
                        <el-table-column
                          sortable
                          prop="attention"
                          label="出勤情况"
                          min-width="100">
                        </el-table-column>
                          <el-table-column
                                  prop="status"
                                  label="缺勤原因"
                                  min-width="180">
                          </el-table-column>
                      </el-table>
                    </template>
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
                absent:[],
                leading: [],
                isPeople: false
            }
        },
        computed: {
            me () {
                return this.$store.state.me ? this.$store.state.me : {};
            }
        },
        filters: {
            filterTime (val) {
                return (val || '').split(' ')[0];
            }
        },
        methods: {
            //获取任务详情()
            loadItem () {
                    this.$http.get('metting/' + this.$route.params.id).then(res => {
                        this.item = res.data.data
                        if((this.item.users[0].id || '') === 'all'){
                            this.isPeople = true;
                            for(let j in this.item.absentees) {
                                this.absent.push({
                                    name: this.item.absentees[j].user.name,
                                    nickname: this.item.absentees[j].user.nickname,
                                    attention: '缺勤',
                                    status: this.item.absentees[j].assess.title
                                });
                            }
                        } else {
                            for(let i in this.item.users){
                                this.item.users[i].attention = '出勤';
                                for(let j in this.item.absentees) {
                                    if (this.item.users[i].id === this.item.absentees[j].user_id) {
                                        this.item.users[i].attention = '缺勤';
                                        this.item.users[i].status = this.item.absentees[j].assess.title
                                    }
                                }
                            }
                            this.absent = this.item.users;
                        }
                    })

            }
        },
        beforeRouteUpdate (to, from, next) {
            next();
            this.loadItem()
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
    .clearfix{
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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
        text-align:left;text-indent: 2em;word-wrap:break-word;
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
    .cahierProps span{
        margin-right: 20px;
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
