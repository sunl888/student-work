<template>
    <div class="taskManage item">
        <el-tabs v-model="activeName" @tab-click="request" >
            <div class="query">
                <el-select class="querySelect"  @change="getUrl()" clearable v-model="query.college" placeholder="按学院筛选">
                    <el-option
                    v-for="item in collegesList"
                    :key="item.id"
                    :label="item.title"
                    :value="item.id"></el-option>
                </el-select>
                <el-select class="querySelect"  @change="getUrl()" clearable v-model="query.role" placeholder="按用户角色筛选">
                    <el-option
                        v-for="item in rolesList"
                        :key="item.id"
                        :label="item.description"
                        :value="item.id"
                    ></el-option>
                </el-select>
                <el-select class="querySelect"  @change="getUrl()" clearable v-model="query.gender" placeholder="按用户性别筛选">
                    <el-option
                        v-for="item in genders"
                        :key="item.id"
                        :label="item.gender_str"
                        :value="item.id">
                    </el-option>
                </el-select>
                <el-input class="querySelect" @blur="getUrl()" v-model="query.name" placeholder="按用户工号筛选"></el-input>
                <el-input class="querySelect" @blur="getUrl()" v-model="query.nickname" placeholder="按用户姓名筛选"></el-input>
                <el-upload
                    class="upload-demo"
                    style="float: right;"
                    multiple
                    :show-file-list="false"
                    action="api/upload_users"
                    :on-success="handleSuccess"
                    :on-error="handleError"
                    :on-progress="handleProgress"
                >
                    <el-button type="primary">导入数据<i class="el-icon-upload el-icon--right"></i></el-button>
                </el-upload>
            </div>
            <el-tab-pane label="用户列表" name="list">
                <div class="table">
                    <currency-list-page ref="list" :queryName="user_url">
                        <template scope="list">
                            <el-table
                                    v-loading="upload_user"
                                    :default-sort = "{prop: 'created_at', order: 'descending'}"
                                    :data="list.data"
                                    stripe
                                    border
                                    style="width: 100%">
                                <el-table-column
                                        inline-template
                                        sortable
                                        width="100px"
                                        label="头像">
                                    <img style="border-radius:50%;width:30px;height:30px" v-if="row.picture!==null" :src="row.picture" alt="">
                                    <img style="border-radius:50%;width:30px;height:30px;" v-else src="../../assets/images/picture.jpg" alt="">
                                </el-table-column>
                                <el-table-column
                                        prop="name"
                                        sortable
                                        min-width="100"
                                        label="用户名（工号）">
                                </el-table-column>
                                <el-table-column
                                        prop="nickname"
                                        sortable
                                        min-width="150"
                                        label="用户昵称">
                                </el-table-column>
                                <el-table-column
                                        prop="gender_str"
                                        sortable
                                        width="90px"
                                        label="性别">
                                </el-table-column>
                                <el-table-column
                                        prop="college.data.title"
                                        sortable
                                        label="所属学院"
                                >
                                </el-table-column>
                                <el-table-column
                                        inline-template
                                        label="用户角色"
                                        sortable
                                >
                                    <span>{{row.roles.data[0].display_name}}</span>
                                </el-table-column>
                                <el-table-column
                                        width="200"
                                        label="操作"
                                        inline-template
                                >
                                    <template>
                                        <el-button-group>
                                            <el-button type="primary" size="small" @click="browserUser(row.id)">查看</el-button>
                                            <el-button type="success" size="small" @click="modifyUser(row.id)">修改</el-button>
                                            <el-button type="danger" size="small" @click="deleteUser(row.id)">删除</el-button>
                                        </el-button-group>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </template>
                    </currency-list-page>
                </div>
            </el-tab-pane>
        </el-tabs>
        <el-card v-if="isProfile" class="proCard el-col-5">
            <div class="head">
                <i class="el-icon-close" style="position:absolute;right:20px;" @click="isProfile =false"></i>
                <img style="border-radius:50%;" v-if="item.data.picture" :src="item.data.picture">
                <img style="border-radius:50%;" v-else src="../../assets/images/picture.jpg" alt="">
            </div>
            <div class="profile el-col-20 el-col-push-2">
                <p>用户名(工号)：<span>{{item.data.name}}</span></p>
                <p>用户昵称：<span>{{item.data.nickname}}</span></p>
                <p>性&emsp;别：<span>{{item.data.gender_str}}</span></p>
                <p>手机号码：<span>{{item.data.phone}}</span></p>
                <p>用户邮箱：<span>{{item.data.email}}</span></p>
                <p>用户角色：<span>{{item.meta.role[0].display_name}}</span></p>
                <p v-if="item.data.college.data !== {}">所属学院：<span>{{item.data.college.data.title}}</span></p>
                <p>用户创建时间：<span>{{item.data.created_at | dateFilter}}</span></p>
            </div>
        </el-card>
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
                    gender: null
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
            this.getCollegesList();
            this.getRolesList();
        },
        methods: {
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
                this.isProfile = !this.isProfile
                this.$http.get('user/' + id + '?include=roles,college').then(res => {
                    this.item = res.data;
                })
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
