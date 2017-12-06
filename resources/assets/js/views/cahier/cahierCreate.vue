<template>
  <div class="taskManage item">
    <el-tabs v-model="activeName" @tab-click="request" >
      <el-tab-pane label="会议列表" name="list">
        <div class="table">
          <currency-list-page ref="list" :queryName="query">
            <template scope="list">
              <!-- {{list}} -->
              <el-table
                      :default-sort = "{prop: 'created_at', order: 'descending'}"
                      :data="list.data"
                      stripe
                       border
                      style="width: 100%">
                <el-table-column
                        sortable
                        inline-template
                        label="发布日期"
                        width="200">
                        <span>{{row.start_time | filterTime}}</span>
                </el-table-column>
                <el-table-column
                        prop="title"
                        sortable
                        min-width="150"
                        label="会议名称"
                >
                </el-table-column>
                <el-table-column
                        prop="address"
                        sortable
                        min-width="100"
                        label="会议地点"
                >
                </el-table-column>
                <el-table-column
                        inline-template
                        min-width="200"
                        sortable
                        label="参会人员"
                >
                <span>
                  <span>{{row.users[0].nickname === '全体人员' ? row.users[0].nickname : row.users[0].nickname + '等共'+ row.users.length + '人'}}</span>
                </span>
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
                activeName: 'list',
                query: '',
                list: []
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
            //查看任务
            browseTask (id) {
                this.$router.push({name: 'cahier_detail',
                    params: {
                        id
                    }
                })
            },
            querys () {
                if(this.me.is_super_admin){
                    this.query = 'mettings';
                } else {
                    this.query = 'mettings?user=' + this.me.id;
                }
            },
            //刷新表格
            request (tab) {
                this.$refs[tab.name].refresh();
            }
        },
        beforeMount () {
            this.querys()
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
