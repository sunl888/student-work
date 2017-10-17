<template>
    <div class="prese_data_panel">
        <h2 class="title">{{title}}</h2>
        <div style="color:#666;font-size:12px;margin-top:-20px;margin-bottom:20px" >
        <p>使用提示：有<i class="el-icon-star-on" style="color:orange;margin:0 3px"></i>标记的为当前学期</p>
            <p>点击非当前学期后的<i style="color:#13CE66;margin:0 3px" class="el-icon-check"></i>按钮可以将此学期设置为当前学期哦</p>
        </div>
        
        <div>
            <el-input style="margin-right:10px;width:130px;" class="add_input" v-model="inputTitle" placeholder="请输入学年名称"></el-input>
            <el-date-picker
        style="margin-right:10px;" 
          v-model="range"
          type="daterange"
          placeholder="选择学年范围">
            </el-date-picker>
            <el-button icon="plus" style="color:#666" title="添加学年" @click="addType()">
            </el-button>
        </div>
        <transition-group name="el-zoom-in-center">
            <div class="tagGroup tagbox el-col-24" :key="item.id" v-for="(item,index) in tags" >
                <Ttag @update="update($event, item.id, 1)" @on-close="deleteWorkType(item.id, 'parent', index)" :title="item.title"></Ttag>
                <Ttag @update="update($event, item.id, 2)" @on-close="deleteWorkType(item.id,'parent', index)" :range="item.start_time + ' - ' +item.end_time"></Ttag>
               <el-button style="position:absolute;margin-left:20px" v-if="item.parent_id == 0" type="text" @click="openDia(item.id)">添加学期</el-button>
               <p style="width:80%;margin:5px auto;background:#999;height:1px;"></p>
               <el-dialog title="添加学期" :visible.sync="isSemester">
                  <el-form>
                    <el-col>
                         <el-input style="margin-right:10px;width:200px;" class="add_input" v-model="inputTitle" placeholder="请输入学期名称"></el-input>
                        <el-date-picker
                        style="margin-right:10px;" 
                          v-model="range"
                          type="daterange"
                          placeholder="选择学期范围">
                        </el-date-picker>
                        <el-checkbox v-model="currentSemester">设为当前学期</el-checkbox>
                    </el-col>
               
                          
                  </el-form>
                  <div slot="footer" style="margin-top:20px" class="dialog-footer">
                    <el-button @click="isSemester = false">取 消</el-button>
                    <el-button type="primary" @click="addType()">确 定</el-button>
                  </div>
                </el-dialog>
               <div style="margin-top:10px" v-for="(value,key) in item.childs">
                    <Ttag @update="update($event, value.id, 1)" @on-close="deleteWorkType(value.id, 'childs'. index,key)" :title="value.title"></Ttag>
                    <Ttag @update="update($event, value.id, 2)" @on-close="deleteWorkType(value.id, 'childs',index,key)" :range="value.start_time + ' - ' +value.end_time"></Ttag>
                    <i v-if="value.checked === 1" style="color:orange;position:absolute;margin-left:20px;margin-top:8px;" title="当前学期" class="el-icon-star-on"></i>
                    <i v-else style="color:#13CE66;position:absolute;margin-left:20px;margin-top:8px;cursor:pointer" class="el-icon-check" title="点击设为当前学期" @click="setCurrent(value.id)"></i>
               </div>
            </div>

        </transition-group>
       
    </div>
</template>

<script>
    import Ttag from './Stag.vue'
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
                currentSemester:false,
                isSemester:false,
            	range:[],
                inputTitle: '',
                tags:[],
                inputGra: '',
                temp: ''
            }
        },
        mounted () {
            this.getWorkType()
        },
        methods: {
            setCurrent(id){
                this.$http.post('set_current_semester' + '/' + id).then(res => {
                    this.$message.success('已设置为当前学期');
                    this.getWorkType();
                })
            },
            openDia(id){
                this.isSemester = true
                this.temp = id
            },
            // 更新工作类型
            update (newVal, id, num) {
                if(num === 1) {
                    this.$http.post('update_' + this.url + '/' + id, {
                        title: newVal,
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
                } else {
                	newVal = newVal.split('~');
        //         	this.range = this.range.toLocaleString().split(',')
		    		// this.range.push({
		    		//    start_time: (this.range[0] || '').substr(0,(this.range[0] || '').indexOf(' ')),
		    		//    end_time: (this.range[1] || '').substr(0,(this.range[1] || '').indexOf(' '))
		    		// })
                    this.$http.post('update_' + this.url + '/' + id, {
	                    start_time:newVal[0],
	                    end_time:newVal[1]
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
            	this.range = this.range.toLocaleString().split(',')
        		this.range.push({
        		   start_time: this.range[0].substr(0,this.range[0].indexOf(' ')),
        		   end_time: this.range[1].substr(0,this.range[1].indexOf(' '))
        		})
                if(this.isSemester){
                    if(this.currentSemester){
                        this.$http.post('create_' + this.url, {
                        title: this.inputTitle,
                        start_time:this.range[2].start_time,
                        end_time: this.range[2].end_time,
                        parent_id: this.temp,
                        checked: 1
                        }).then(res => {
                            this.inputTitle = ''
                            this.range = ''
                            this.getWorkType()
                            this.$message({
                                message: '添加成功',
                                type: 'success'
                            })
                            this.isSemester = false
                            this.currentSemester = null
                        }).catch(err => {
                            for(let i in err.response.data.message){
                                this.$message({
                                  type: 'error',
                                  message: err.response.data.message[i]
                              })  
                            }
                                                         
                          })
                    } else {
                       this.$http.post('create_' + this.url, {
                            title: this.inputTitle,
                            start_time:this.range[2].start_time,
                            end_time: this.range[2].end_time,
                            parent_id: this.temp,
                        }).then(res => {
                            this.inputTitle = ''
                            this.range = ''
                            this.getWorkType()
                            this.$message({
                                message: '添加成功',
                                type: 'success'
                            })
                            this.isSemester = false
                            this.currentSemester = null
                        }).catch(err => {
                            for(let i in err.response.data.message){
                                this.$message({
                                  type: 'error',
                                  message: err.response.data.message[i]
                              })  
                            }
                                                         
                          })
                    }
                } else {
                        this.$http.post('create_' + this.url, {
                        title: this.inputTitle,
                        start_time:this.range[2].start_time,
                        end_time: this.range[2].end_time
                        // parent_id: this.temp,
                        // checked: this.currentSemester
                        }).then(res => {
                            this.inputTitle = ''
                            this.range = ''
                            this.getWorkType()
                            this.$message({
                                message: '添加成功',
                                type: 'success'
                            })
                            this.isSemester = false
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
            // 获取工作类型
            getWorkType () {
                this.$http.get(this.getUrl).then(res => {
                    this.tags = res.data
                    for(let i in this.tags){
                    	  this.tags[i].start_time = (this.tags[i].start_time || '').substr(0,this.tags[i].start_time.indexOf(' '))
                    	  this.tags[i].end_time = (this.tags[i].end_time || '').substr(0,this.tags[i].end_time.indexOf(' '))
                          for(let j in this.tags[i].childs){
                             this.tags[i].childs[j].start_time = (this.tags[i].childs[j].start_time || '').substr(0,this.tags[i].childs[j].start_time.indexOf(' '))
                            this.tags[i].childs[j].end_time = (this.tags[i].childs[j].end_time || '').substr(0,this.tags[i].childs[j].end_time.indexOf(' '))
                          }
                    }
                })
            },
            // 删除工作类型
            deleteWorkType (id, position, index,key) {
                this.$http.get('delete_' + this.url + '/' + id).then(res => {
                    if(position == 'parent'){
                        this.tags.splice(index, 1)
                    } else{
                        this.tags[index].childs.splice(key,1);
                        console.log()
                    }
                    this.$message({
                        message: '删除成功',
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
            }
        }
    }
</script>

<style lang="css">
    .prese_data_panel{
        width: 60%;
        padding: 25px;
        margin: 0 auto;
    }
    .prese_data_panel>.title,.title{
        font-size: 18px;
        color: #555;
        margin-bottom: 30px;
    }
    .prese_data_panel>.add_input,.add_input{
        width: 130px;
    }
    .tagbox{
       float:left;
        margin: 20px;
        padding:10px;
        background:#fff;
        border-radius:3px;
    }
</style>
