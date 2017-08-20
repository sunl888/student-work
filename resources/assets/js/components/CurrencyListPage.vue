<template>
    <div class="currency-list-page">
          <div v-loading="loading" class="main">
              <slot v-if="list.length > 0" :data="list"></slot>
              <template v-else>
                <div v-if="queryName == 'tasks'">
                  <p>
                    当前还没有任务哦，请单击右侧按钮添加任务&emsp;
                    <el-button type="primary" icon="plus" @click="$router.push({path: 'add_task'})"></el-button>
                  </p>
                </div>
                <div v-else-if="queryName == 'trashed_tasks'">
                  <p>
                    当前还没有已删除的任务
                  </p>
                </div>
                <div v-else="queryName == 'lists'">
                  <p>
                      当前没有可查看的任务
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
                        this.list = res.data.data;
                        this.total = res.data.meta.pagination.total;
                        // this.perPage = res.data.meta.pagination.per_page
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
