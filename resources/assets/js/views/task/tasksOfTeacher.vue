<template>
    <div class="taskManage item">
        <el-tabs v-model="activeName" @tab-click="request" >
            <el-tab-pane label="任务列表" name="list">
                <div class="table">
                    <currency-list-page ref="list" queryName="tasks_of_teacher">
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
                                        label="发布日期"
                                        width="120">
                                    <span>{{row.created_at | dataFilter}}</span>
                                </el-table-column>
                                <el-table-column
                                        prop="task.title"
                                        sortable
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
                                        inline-template
                                        sortable
                                        label="状态"
                                        width="100"
                                >
                                    <span>{{row.status === null ? '未完成' : '已完成' }}</span>
                                </el-table-column>
                                <el-table-column
                                        label="截止时间"
                                        width="120"
                                        sortable
                                        inline-template
                                >
                                    <span>{{row.task.end_time | dataFilter}}</span>
                                </el-table-column>
                                <el-table-column
                                        label="任务评分"
                                        width="120"
                                        sortable
                                        inline-template
                                >
                                    <span>{{ !row.assess ? '尚未评分' : row.assess}}</span>
                                </el-table-column>
                                <el-table-column
                                        label="操作"
                                        inline-template
                                >
                                    <template>
                                        <el-button type="primary" size="small" @click="browseTask(row.task.id)">查看</el-button>
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
            //查看任务
            browseTask (id) {
                this.$router.push({name: 'task_information',
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
