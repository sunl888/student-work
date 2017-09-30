<template>
  <div class="taskManage item collegeTask">
    <el-tabs v-model="activeName" @tab-click="request" >
      <el-tab-pane label="任务列表" name="list">
        <div class="table">
          <currency-list-page ref="list" queryName="lists?include=task_progresses&college=9">
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
                <span>
                    <p v-if="row.user!==null" v-for="value in row.user">{{value.name}}</p>
                    <span v-else>{{'尚未指定'}}</span>
                </span>
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
                    <el-button-group>
                        <el-button type="primary" size="small" @click="browseTask(row.id)">查看</el-button>
                        <el-button :disabled='row.finished_at!==null' type="success" size="small" @click="isAppoints(true, row)">{{!row.user ? '指定责任人' : '修改责任人'}}</el-button>
                    </el-button-group>
                  </template>
                </el-table-column>
              </el-table>
              <!--指定责任人-->
              <el-dialog title="指定责任人" :visible.sync="isDia" top="10%">
                <el-form>
                  <el-form-item>
                    <el-transfer class="transfer" :titles="['本学院可选责任人', '已选中的责任人']" :value="allot" v-model="allot" :data="users"></el-transfer>
                  </el-form-item>
                </el-form>
                <div slot="footer" style="margin-top:-50px;" class="dialog-footer">
                  <el-button @click="isDia = false">取 消</el-button>
                  <el-button type="primary" @click="appoint()">确 定</el-button>
                </div>
              </el-dialog>
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
                //获取各学院可选责任人
                users: [],
                //是否显示dialog
                isDia: false,
                isAllot: false,
                //是否显示评分结果
                isScores: false,
                //当前选中一级菜单
                currOption: [],
                //当前选中责任人ID
                allot: [],
                //临时数组，存放row.id
                temp: [],
                //任务提交时是否过了截止日期
                delay: {
                    delayReson: '',
                    isDelay: false,
                    delayMessage: ''
                },
                formLabelWidth: '210px',
                formLabelWidth2: '100px',
                //责任人级联选择器一级菜单
                options: [
                    {
                        name: '全体人员', id: 'all'
                    },
                    {
                        name: '具体单一', id: 'only',
                        children: [
                        ]
                    }
                ],
                prop: {
                    label: 'name',
                    value: 'id'
                }
            }
        },
        mounted () {
            this.getUsers();
        },
        computed: {
            me () {
                return this.$store.state.me.college_id ? this.$store.state.me.college_id : {};
            }
        },
        methods: {
            //查看任务
            browseTask (id) {
                this.$router.push({name: 'task_detail',
                    params: {
                        id: id,
                        college: this.me
                    }
                })
            },
            //刷新表格
            request (tab) {
                this.$refs[tab.name].refresh();
            },
            isAppoints(x, row){
                this.isDia = x
                this.temp = row
            },
            //指定责任人
            appoint () {
                Array(this.allot);
                if(this.allot.length == this.users.length){
                    this.allot = 'all';
                } else if(this.allot.length == 1){
                    this.allot = String(this.allot);
                }
                this.$http.post('create_allot_task/' + this.temp.id + '/' + this.me, {
                    user_id: this.allot == 'all' || this.allot.length === 1 ? this.allot : this.allot.join(',')
                }).then(res => {
                    this.isAllot = true
                    this.isDia = false
                    this.$message.success('指定成功')
                    this.$refs['list'].refresh()
                }).catch(res => {
                    this.$message.error('指定失败,请重新操作')
                })
            },
            //获取学院所有用户
            getUsers () {
                this.$http.get('users').then(res => {
                    for(let i in res.data.users)
                    this.users.push({
                        label: res.data.users[i].name,
                        key: res.data.users[i].id
                    })
                })
            }
        }
    }
</script>
<style scoped>
  .collegeTask{
    width: 100%;
  }
  .page{
    margin-top: 30px;
  }
  .collegeTask>.el-cascader,.el-input{
    margin-left:-200px;
  }
  .delayMessage{
    color:#FF4949;
    text-align:center;
    font-size:12px;
    padding-bottom:10px;
  }

  .el-transfer-panel__item .el-checkbox__input {
    left:40px;
  }
</style>
