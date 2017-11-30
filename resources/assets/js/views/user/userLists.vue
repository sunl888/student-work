<template>
    <div class="taskManage item">
        <el-tabs v-model="activeName" @tab-click="request" >
            <el-tab-pane label="用户列表" name="list">
                <div class="table">
                    <currency-list-page ref="list" queryName="all_users">
                        <template scope="list">
                            <el-table
                                    :default-sort = "{prop: 'created_at', order: 'descending'}"
                                    :data="list.data"
                                    stripe
                                    border
                                    style="width: 100%">
                                <el-table-column
                                        prop="created_at"
                                        sortable
                                        label="创建日期"
                                        width="120">
                                </el-table-column>
                                <el-table-column
                                        inline-template
                                        sortable
                                        width="70px"
                                        label="头像">
                                    <img style="border-radius:50%;width:30px;height:30px" v-if="row.picture!==null" :src="row.picture" alt="">
                                    <img style="border-radius:50%;width:30px;height:30px;" v-else src="../../assets/images/picture.jpg" alt="">
                                </el-table-column>
                                <el-table-column
                                        prop="name"
                                        sortable
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
                                        width="70px"
                                        label="性别">
                                </el-table-column>
                                <el-table-column
                                        prop="college.title"
                                        sortable
                                        label="所属学院"
                                >
                                </el-table-column>
                                <el-table-column
                                        inline-template
                                        label="用户角色"
                                        sortable
                                >
                                    <span>{{row.role_dispname}}</span>
                                </el-table-column>
                                <el-table-column
                                        prop="email"
                                        label="邮箱"
                                        sortable
                                >
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
                <img style="border-radius:50%;" v-if="item.picture" :src="item.picture">
                <img style="border-radius:50%;" v-else src="../../assets/images/picture.jpg" alt="">
            </div>
            <div class="profile el-col-20 el-col-push-2">
                <p>用户名(工号)：<span>{{item.name}}</span></p>
                <p>用户昵称：<span>{{item.nickname}}</span></p>
                <p>性&emsp;别：<span>{{item.gender_str}}</span></p>
                <p>用户邮箱：<span>{{item.email}}</span></p>
                <p>用户角色：<span>{{item.role_dispname}}</span></p>
                <p v-if="item.college != undefined">所属学院：<span>{{item.college.title}}</span></p>
                <p>用户创建时间：<span>{{item.created_at | dateFilter}}</span></p>
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
                item: []
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
        },
        methods: {
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
                this.$http.get('user/' + id).then(res => {
                    this.item = res.data.data
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
