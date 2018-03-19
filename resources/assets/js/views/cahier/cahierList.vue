<template>
    <div class="taskManage item">
        <el-tabs v-model="activeName" @tab-click="request" >
            <el-tab-pane label="会议考核" name="list">
                <div class="table">
                            <el-table
                                    :data="item"
                                    stripe
                                    border
                                    style="width: 100%">
                                <el-table-column
                                        prop="title"
                                        sortable
                                        label="会议名称">
                                </el-table-column>
                                <el-table-column
                                        prop="start_time"
                                        sortable
                                        label="开会时间">
                                </el-table-column>
                                <el-table-column
                                        prop="address"
                                        sortable
                                        label="开会地点">
                                </el-table-column>
                                <el-table-column
                                        inline-template
                                        sortable
                                        label="参会人员">
                                        <span>{{row.users[0].id == 'all' ? row.users[0].nickname : row.users[0].nickname + '等共'+row.users.length + '人'}}</span>
                                </el-table-column>
                                <el-table-column
                                        prop="meeting_total_score"
                                        sortable
                                        label="会议得分">
                                </el-table-column>
                                <el-table-column
                                        width="200"
                                        label="操作"
                                        inline-template
                                >
                                    <template>
                                        <el-button-group>
                                            <el-button type="primary" size="small" @click="browserUser(row.id)">查看</el-button>
                                            <!-- <el-button type="primary" size="small"  @click="modifyTask(row.id)">修改</el-button>
                                            <el-button type="danger" size="small" @click="deleteTask(row.id)">删除</el-button> -->
                                        </el-button-group>
                                    </template>
                                </el-table-column>
                            </el-table>
                </div>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>
<script>
    import CurrencyListPage from '../../components/CurrencyListPage'
    export default{
        components: {CurrencyListPage},
        data () {
            return {
                activeName: 'list',
                isProfile: false,
                collegesList: [],
                rolesList: [],
                user_url: 'all_users?include=roles,college',
                item: [],
                upload_user: false,
                list: [],
                genders: [
                    {gender_str: '男', gender: false, id: "0"},
                    {gender_str: '女', gender: true, id: "1"}
                ],
                file_url: null,
                query: {
                    college: null,
                    role: null,
                    nickname: null,
                    name: null,
                    gender: null,
                    range: {
                        start_date: null,
                        end_date: null
                    }
                }
            }
        },
        filters: {
          dateFilter (val) {
              var tempStr = new Array()
              tempStr = (val || '').split(' ')
              return tempStr[0]
          }
        },
        // watch: {
        //     'user_url' : 
        // },
        mounted () {
            this.getItem();
            this.getCollegesList();
            this.getRolesList();
        },
        methods: {
            getItem(){
                this.$http.get('attendance?college_id='+this.$route.params.id).then(res=>{
                    this.item = res.data[0].meetings
                })
            },
            handleSuccess(response){
                this.file_url = response.path;
                this.upload_user = false;
                this.$refs['list'].refresh();
                this.$message.success('成功导入数据');
            },
            handleError(err){
                this.$message.error('数据错误或重复，请重试');
                this.upload_user = false;
                this.$refs['list'].refresh();
            },
            handleProgress(){
                this.upload_user = true;
            },
            getUrl () {
                let url = new Array();
                let i = 1;
                url[0] = 'all_users?include=roles,college';
                if(this.query.college !== null){
                    url[i] = '&college_id=' + this.query.college;
                    i++;
                }
                if(this.query.role !== null){
                    url[i] = '&role_id=' + this.query.role; 
                    i++;
                }
                if(this.query.gender !== null){
                   url[i] = '&gender=' + this.query.gender;
                    i++;
                }
                if(this.query.name !== null){
                    url[i] = '&name=' + this.query.name;
                    i++;
                }
                if(this.query.nickname !== null){
                    url[i] = '&nickname=' + this.query.nickname;
                }
                this.user_url = url.join('');
                this.$refs['list'].refresh();
            },
            getRolesList () {
                this.$http.get('roles').then(res => {
                    this.rolesList = res.data.data
                })
            },
             // 获取学院
            getCollegesList () {
                this.$http.get('colleges').then(res => {
                    this.collegesList = res.data.data
                })
            },
            //删除用户
            deleteUser (id) {
                this.$confirm('该操作将删除此用户, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.get('delete_user/' + id).then(res => {
                        this.$refs['list'].refresh();
                        this.$message.success('删除成功')
                    })
                }).catch(() => {
                    this.$message.info('已取消删除')
                })
            },
            //查看用户信息
            browserUser (id) {
                this.$router.push({name: 'cahier_detail', params: {id: id}})
            },
            //修改用户信息
            modifyUser (id) {
                this.$router.push({name: 'edit_user',
                    params: {
                        id
                    }
                })
            },
            //刷新表格
            request (tab) {
                this.$refs[tab.name].refresh();
            }
        }
    }
</script>
<style scoped>
    .taskManage{
        width: 100%;
    }
    .page{
        margin-top: 30px;
    }
    .proCard{
        max-height:400px;
        position:absolute;
        position:fixed;
        margin:auto;
        left:0;
        right:0;
        top:0;
        min-width:280px;
        bottom:0;
        z-index:2000;
    }
    .querySelect{
    width:16%;
  }
    .head{
        height:60px;
        border-bottom:1px solid #eee;
    }
    .head>img{
        width:105px;
        height:105px;
        box-shadow:2px 2px 10px #ccc,
                    -2px -2px 10px #ccc;
    }
    .head>i:hover{
        color:red;
    }
    .head>i{
        cursor:pointer;
    }
    .profile{
        margin-top:75px;
    }
    .profile>p {
        text-align:left;
        margin-bottom:5px;
        color:#777;
        font-size:14px;
    }
    .profile>p>span{
        color:#444;
        font-size:16px;
        display:inline-block;
    }
</style>
