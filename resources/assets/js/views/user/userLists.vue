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
                                        <el-button type="primary" size="small" @click="browseTask(row.id)">查看</el-button>
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
            //查看任务
            browseTask (id) {
                this.$router.push({name: 'task_item',
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
