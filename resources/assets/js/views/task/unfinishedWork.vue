<template>
  <div class="taskManage item">
    <el-tabs v-model="activeName" @tab-click="request" >
      <el-tab-pane label="任务列表" name="list">
        <div class="table">
          <currency-list-page ref="list" queryName="lists">
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
                        inline-template
                >
                  <template>
                    <el-button-group>
                        <el-button type="primary" size="small" @click="browseTask(row.id)">查看</el-button>
                        <el-button :disabled='row.finished_at!==null' type="success" size="small" @click="isAppoints(true, row)">{{!row.user ? '指定责任人' : '修改责任人'}}</el-button>
                        <el-button :disabled='row.finished_at!==null' type="danger" size="small" @click="goSubmit(row)">提交</el-button>
                    </el-button-group>
                  </template>
                </el-table-column>
              </el-table>
              <!--指定责任人-->
              <el-dialog title="指定责任人" :visible.sync="isDia" top="30%">
                <el-form>
                  <el-form-item label="指定责任人" :label-width="formLabelWidth">
                    <el-cascader
                            @change="current()"
                            :options="options"
                            v-model="currOption"
                            :props="prop"
                    >
                    </el-cascader>
                  </el-form-item>
                </el-form>
                <div slot="footer" style="margin-top:-50px;" class="dialog-footer">
                  <el-button @click="isDia = false">取 消</el-button>
                  <el-button type="primary" @click="appoint()">确 定</el-button>
                </div>
              </el-dialog>
              <!--填写推迟理由-->
              <el-dialog title="推迟理由" :visible.sync="delay.isDelay" top="30%">
                <p class='delayMessage'>{{delay.delayMessage}}</p>
                <el-form>
                  <el-form-item label="推迟理由" :label-width="formLabelWidth2">
                    <el-input type="textarea" placeholder="请填写推迟理由" v-model="delay.delayReson"></el-input>
                  </el-form-item>
                </el-form>
                <div slot="footer" style="margin-top:-50px;" class="dialog-footer">
                  <el-button @click="delay.isDelay = false">取 消</el-button>
                  <el-button type="primary" @click="isSubmit(delay.delayReson)" required>确 定</el-button>
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
                allot: null,
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
            this.getUsers()
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
            },
            isAppoints(x, row){
                this.isDia = x
                this.temp = row
            },
            //获取当前选项
            current(){
                if(this.currOption[1]){
                    this.allot = this.currOption[1]
                } else {
                    this.allot = this.currOption[0]
                }
            },
            //判断提交时间是否过了截止日期
            goSubmit (x) {
                this.$confirm('提交任务后将无法取消, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$http.get('is_delay/' + x.id).then(res => {
                        this.temp = x
                        if (res.data.isDelay) {
                            this.delay.delayMessage = '此任务已经过了截止日期，请填写推迟理由后提交！'
                            this.delay.isDelay = true
                        } else {
                            this.isSubmit()
                        }
                    })
                }).catch(() => {
                    this.$message.info('取消提交任务')
                })
            },
            //去提交任务
            isSubmit(val){
                this.$http.post('submit_task/' + this.temp.id,{
                    delay: val
                }).then(res=>{
                    this.$message.success('提交成功,此任务已完成!')
                    this.delay.isDelay = false
                    this.$refs['list'].refresh()
                }).catch(res => {
                    this.$message.error(res.message)
                })
            },
            //指定责任人
            appoint () {
                this.$http.post('create_allot_task', {
                    task_id: this.temp.id,
                    user_id: this.allot
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
                    this.options[1].children = res.data.users
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
