<template>
    <div class="prese_data_panel">
        <h2 class="title">{{title}}</h2>
        <transition-group name="el-zoom-in-center">
            <div class="tagGroup" :key="item.id" v-for="(item,index) in tags" >
                <Ttag @update="update($event, item.id, 1)" @on-close="deleteWorkType(item.id, index)" :content="item.title"></Ttag>
                <Ttag @update="update($event, item.id, 2)" @on-close="deleteWorkType(item.id, index)" :score="item.score"></Ttag>
            </div>
        </transition-group>
        <el-input class="add_input" v-model="inputVal" placeholder="请输入标题"></el-input>
        <span>-</span>
        <el-input @keyup.enter.native="addType" @click="addType" class="add_input" icon="plus" v-model="inputGra" placeholder="请输入分数"></el-input>
    </div>
</template>

<script>
    import Ttag from './Gtag.vue'
    export default {
        components: {
            Ttag
        },
        props: {
            title: String,
            url: String,
            getUrl: String
        },
        data () {
            return {
                inputVal: '',
                tags:[],
                inputGra: ''
            }
        },
        mounted () {
            this.getWorkType()
        },
        methods: {
            // 更新工作类型
            update (newVal, id, num) {
                if(num === 1) {
                    this.$http.post('update_' + this.url + '/' + id, {
                        title: newVal
                    }).then(res => {
                        this.$message({
                            message: '修改成功',
                            type: 'success'
                        })
                    }).catch(err => {
                            for(let i in err.response.data.errors){
                                this.$message({
                                  type: 'error',
                                  message: err.response.data.errors[i]
                              })  
                            }
                                                         
                          })
                } else {
                    this.$http.post('update_' + this.url + '/' + id, {
                        score: newVal
                    }).then(res => {
                        this.$message({
                            message: '修改成功',
                            type: 'success'
                        })
                    }).catch(err => {
                           for(let i in err.response.data.message){
                                this.$message({
                                  type: 'error',
                                  message: err.response.data.message[i]
                              })  
                            }
                                                         
                          })
                }
            },
            // 添加工作类型
            addType () {
                this.$http.post('create_' + this.url, {
                    title: this.inputVal,
                    score: this.inputGra
                }).then(res => {
                    this.inputVal = ''
                    this.inputGra = ''
                    this.getWorkType()
                    this.$message({
                        message: '添加成功',
                        type: 'success'
                    })
                }).catch(err => {
                            for(let i in err.response.data.message){
                                this.$message({
                                  type: 'error',
                                  message: err.response.data.message[i]
                              })  
                            }
                                                         
                          })
            },
            // 获取工作类型
            getWorkType () {
                this.$http.get(this.getUrl).then(res => {
                    this.tags = res.data.data
                })
            },
            // 删除工作类型
            deleteWorkType (id, index) {
                this.$http.get('delete_' + this.url + '/' + id).then(res => {
                    this.tags.splice(index, 1)
                    this.$message({
                        message: '删除成功',
                        type: 'success'
                    })
                }).catch(err => {
                           for(let i in err.response.data.message){
                                this.$message({
                                  type: 'error',
                                  message: err.response.data.message[i]
                              })  
                            }
                                                         
                          })
            }
        }
    }
</script>

<style lang="css">
    .prese_data_panel{
        width: 60%;
        padding: 20px;
        margin: 0 auto;
    }
    .prese_data_panel>.title{
        font-size: 18px;
        color: #555;
        margin-bottom: 30px;
    }
    .prese_data_panel>.add_input{
        width: 130px;
    }
    .tagGroup{
        display:inline;
        margin: 10px 20px;
    }
</style>
