<template>
    <div class="taskManage item">
        <el-tabs v-model="activeName" @tab-click="request" >
            <el-tab-pane label="任务列表" name="list">
                <div class="table">
                    <currency-list-page ref="list" queryName="all_users">
                        <template scope="list">
                            <el-table
                                    :default-sort = "{prop: 'college.title', order: 'descending'}"
                                    :data="list.data"
                                    stripe
                                    border
                                    style="width: 100%">
                                <el-table-column
                                        prop="name"
                                        sortable
                                        label="用户名"
                                        width="120">
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
                                    <span>{{row.roles[0].description}}</span>
                                </el-table-column>
                                <el-table-column
                                        max-width="200"
                                        label="操作"
                                        inline-template
                                >
                                    <template>
                                        <el-button-group>
                                            <el-button type="primary" size="small" @click="browseUser(row.id)">查看</el-button>
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
    </div>
</template>
<script>
    import CurrencyListPage from '../../components/CurrencyListPage'
    export default{
        components: {CurrencyListPage},
        data () {
            return {
                activeName: 'list'
            }
        },
        mounted () {
        },
        methods: {
            //删除用户
            deleteUser (id) {
                this.$confirm('该操作将恢复此用户, 是否继续?', '提示', {
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
            browseUser (id) {
                this.$router.push({name: 'user_item',
                    params: {
                        id
                    }
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
</style>
