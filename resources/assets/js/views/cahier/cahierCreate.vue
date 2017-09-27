<template>
  <div class="taskManage item">
    <el-tabs v-model="activeName" @tab-click="request" >
      <el-tab-pane label="会议列表" name="list">
        <div class="table">
          <currency-list-page ref="list" queryName="mettings">
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
                        label="发布日期"
                        width="110">
                </el-table-column>
                <el-table-column
                        prop="title"
                        sortable
                        width="200"
                        label="任务名称"
                >
                </el-table-column>
                <el-table-column
                        prop="work_type"
                        label="工作类型"
                        width="100"
                        sortable
                >
                </el-table-column>
                <el-table-column
                        prop="department"
                        label="对口科室"
                        width="100"
                        sortable
                >
                </el-table-column>
                <el-table-column
                        label="截止时间"
                        width="110"
                        sortable
                        prop="end_time"
                >
                </el-table-column>
                <el-table-column
                        width="100"
                        label="责任人"
                        inline-template
                >
                  <span>{{row.user ? row.user : '尚未指定'}}</span>
                </el-table-column>
                <el-table-column
                        inline-template
                        label="状态"
                        width="100"
                >
                  <span>{{row.finished_at === null ? '未完成' : '已完成' }}</span>
                </el-table-column>
                <el-table-column
                        label="任务评分"
                        width="100"
                        inline-template
                >
                  <span>{{ !row.assess ? '尚未评分' : row.assess}}</span>
                </el-table-column>
                <el-table-column
                        label="操作"
                        width="170"
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
        computed: {
            me () {
                return this.$store.state.me ? this.$store.state.me : {};
            }
        },
        methods: {
            //查看任务
            browseTask (id) {
                this.$router.push({name: 'task_detail',
                    params: {
                        id
                    }
                })
            },
            //刷新表格
            request (tab) {
                this.$refs[tab.name].refresh();
            }
        },
        mounted () {
            console.log(this.$store.state.menus);
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
  .el-cascader,.el-input{
    margin-left:-200px;
  }
  .delayMessage{
    color:#FF4949;
    text-align:center;
    font-size:12px;
    padding-bottom:10px;
  }
</style>
