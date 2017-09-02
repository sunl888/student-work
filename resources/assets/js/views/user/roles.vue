<template>
    <div class="taskManage item">
        <el-tabs v-model="activeName" @tab-click="request" >
            <el-tab-pane label="角色列表" name="list">
                <div class="table">
                    <currency-list-page ref="list" queryName="roles">
                        <template scope="list">
                            <el-table
                                    :default-sort = "{prop: 'date', order: 'descending'}"
                                    :data="list.data"
                                    stripe
                                    border
                                    style="width: 100%">
                                <el-table-column
                                    inline-template
                                    sortable
                                    label="发布日期">
                                <span>{{row.created_at | dataFilter}}</span>
                                </el-table-column>
                                <el-table-column
                                        prop="display_name"
                                        sortable
                                        label="角色名称">
                                </el-table-column>
                                <el-table-column
                                        prop="description"
                                        sortable
                                        label="角色描述">
                                </el-table-column>
                                <el-table-column
                                        label="操作"
                                        inline-template
                                >
                                    <template>
                                        <el-button-group>
                                            <el-button type="primary" size="small" @click="browseRoles(row.id)">查看</el-button>
                                            <el-button type="success" size="small" @click="editRoles(row.id)">修改</el-button>
                                            <el-button type="danger" size="small" @click="deleteRoles(row.id)">删除</el-button>
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
        filters: {
            dataFilter (val, row) {
                let stringA = new Array()
                stringA = (val || '').split(' ')
                return stringA[0]
            }
        },
        methods: {
            //刷新表格
            request (tab) {
                this.$refs[tab.name].refresh();
            },
            browseRoles (id) {
                this.$router.push({name: 'browser_roles', params: {id: id}})
            },
            editRoles (id) {
                this.$router.push({name: 'edit_roles', params: {id: id}})
            },
            deleteRoles (id) {
                this.$http.get('delete_role/' + id).then(res => {
                    this.$message.success('成功删除角色！')
                }).catch(res => {
                    this.$message.error(res)
                })
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
