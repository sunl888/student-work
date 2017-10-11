<template>
    <div class="taskManage item">
        <el-tabs v-model="activeName" @tab-click="request" >
            <el-tab-pane label="任务列表" name="list">
                <div class="table">
                    <currency-list-page ref="list" queryName="tasks_of_teacher">
                        <template scope="list">
                            <el-table
                                    :default-sort="{prop: 'created_at', order: 'descending'}"
                                    :data="list.data"
                                    stripe
                                    filters
                                    border
                                    style="width: 100%">
                                <el-table-column
                                        sortable
                                        prop="created_at"
                                        label="发布日期"
                                        width="120">
                                </el-table-column>
                                <el-table-column
                                        prop="title"
                                        sortable
                                        min-width="200"
                                        label="任务名称"
                                >
                                </el-table-column>
                                <el-table-column
                                        prop="work_type"
                                        label="工作类型"
                                        width="120"
                                        sortable
                                >
                                </el-table-column>
                                <el-table-column
                                        prop="department"
                                        label="对口科室"
                                        width="120"
                                        sortable
                                >
                                </el-table-column>
                                <el-table-column
                                        prop="status"
                                        label="状态"
                                        width="100"
                                        slot="empty"
                                >
                                </el-table-column>
                                <el-table-column
                                        label="截止时间"
                                        width="120"
                                        prop="end_time"
                                        sortable
                                >
                                </el-table-column>
                                <el-table-column
                                        label="任务评分"
                                        width="120"
                                        sortable
                                        inline-template
                                >
                                <span>{{!row.assess ? '尚未评分' : row.assess}}</span>
                                </el-table-column>
                                <el-table-column
                                        label="操作"
                                        width="100"
                                        inline-template
                                >
                                    <template>
                                        <el-button type="primary" size="small" @click="browseTask(row.task_id)">查看</el-button>
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
        methods: {
            //查看任务
            browseTask (id) {
                this.$router.push({name: 'task_information',
                    params: {
                        id: id,
                        college: this.$store.state.me.college_id
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
