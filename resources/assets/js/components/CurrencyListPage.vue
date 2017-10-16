<template>
    <div class="currency-list-page">
          <div v-loading="loading" class="main">
              <slot v-if="list.length > 0" :data="list"></slot>
              <template v-else>
                <div v-if="queryName==='tasks'">
                  <p>
                    当前还没有任务哦，请单击右侧按钮添加任务&emsp;
                    <el-button type="primary" icon="plus" @click="$router.push({path: 'add_task'})"></el-button>
                  </p>
                </div>
                <div v-else-if="queryName.match('task_progresses')">
                  <p>
                    正在加载数据中...
                    <!-- <el-button type="primary" icon="plus" @click="$router.push({path: 'add_task'})"></el-button> -->
                  </p>
                </div>
                <div v-else-if="queryName.match('trashed_tasks=1')">
                  <p>
                    当前还没有已删除的任务
                  </p>
                </div>
                <div v-else-if="queryName.match('lists') || queryName.match('tasks_of_teacher')">
                  <p>
                      当前没有可查看的任务
                  </p>
                </div>
              <div v-else-if="queryName.match('users')">
                  <p>
                      当前没有已创建的用户
                  </p>
              </div>
              <div v-else-if="queryName.match('mettings')">
                  <p>
                      当前没有会议记录
                  </p>
              </div>
              <div v-else>
                  <p>
                      当前没有已创建的角色
                  </p>
              </div>
              </template>
          </div>
          <div v-if="list.length > 0" class="footer">
              <div class="page_num_box">
                  显示:
                  <el-select @change="change()" class="page_num" size="small" v-model="perPage">
                      <el-option label="5" :value="5"></el-option>
                      <el-option label="10" :value="10"></el-option>
                      <el-option label="15" :value="15"></el-option>
                      <el-option label="20" :value="20"></el-option>
                      <el-option label="30" :value="30"></el-option>
                      <el-option label="40" :value="40"></el-option>
                  </el-select>
                  项结果
              </div>
              <el-pagination
                class="page"
                layout="prev, pager, next"
                :total="total"
                :current-page="currentPage"
                :page-size="perPage"
                @current-change="change">
              </el-pagination>
          </div>
    </div>

</template>

<script>
    export default{
        name: 'currencyListPage',
        props: {
            queryName: String,
            autoRequest: {
              type: Boolean,
              default: true
            }
        },
        data () {
            return {
                total: 0,
                perPage: 20,
                currentPage: 1,
                list: [],
                loading: false
            }
        },
        mounted () {
          this.getList();
          if(this.autoRequest){
            this.getList();
          }
        },
        methods: {
            refresh () {
              this.$nextTick(() => {
                  this.getList(this.currentPage);
              })
            },
            dataFilter (val) {
                let stringA = new Array()
                stringA = (val || '').split(' ')
                return stringA[0]
            },
            getList (page = 1, sort) {
                if(this.queryName){
                    this.loading = true;
                    this.$http.get(this.queryName, {
                        params: {
                            limit: this.perPage,
                            page
                        }
                    }).then(res => {
                        this.loading = false;
                        if(this.queryName === 'tasks_of_teacher') {
                            this.list = res.data.data;
                            this.total = res.data.meta.pagination.total;
                            this.perPage = res.data.meta.pagination.per_page;
                            for(let x in this.list){
                                this.list[x].created_at = this.dataFilter(this.list[x].created_at)
                                this.list[x].task.end_time = this.dataFilter(this.list[x].task.end_time);
                            }
                        }else if(this.queryName.match('mettings')){
                            this.list = res.data.data;
                            this.total = res.data.meta.pagination.total;
                        this.perPage = res.data.meta.pagination.per_page
                            for(let x in this.list){
                              if(this.list[x].title.length>100){
                                this.list[x].title = this.list[x].title.substr(0,100) + '...';
                              }
                            }
                          } else if(this.queryName.match('task_progresses&college=')){
                            this.list = res.data.data
                          } else if(this.queryName.match('include=task_progresses')){
                            this.list = res.data.data.task_progresses.data
                            for(let x in this.list){
                                  if(this.list[x].end_time === null){
                                      this.list[x].end_time = '尚未完成'
                                  }
                                  if(this.list[x].assess === null){
                                      this.list[x].assess = '尚未评分'
                                  }
                              }
                            
                          } else{
                          this.list = res.data.data;
                          this.total = res.data.meta.pagination.total;
                          this.perPage = res.data.meta.pagination.per_page
                          for(let x in this.list){
                              this.list[x].created_at = this.dataFilter(this.list[x].created_at)
                          }
                        }

                    }).catch(err => {
                        this.loading = false;
                    })
                }
            },
            change (currentPage) {
                this.getList(currentPage);
            }
        }
    }
</script>

<style scoped>
.footer{
  padding: 15px 20px;
}
.page_num_box{
    font-size: 14px;
    color: #666;
    float: left;
}
.page_num_box .page_num{
    margin: 0 5px;
    width: 70px;
}
.footer .page{
  float: right;
}
</style>
