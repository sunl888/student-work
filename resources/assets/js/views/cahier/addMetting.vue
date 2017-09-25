<template>
  <div class="addTask">
    <div class="item_add">
      <div class="left el-col-18 el-col-offset-1">
        <!--表单-->
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
          <el-form-item label="会议名称" prop="title">
             <el-input v-model="ruleForm.title" placeholder="请输入会议名称"></el-input>
          </el-form-item>
          <!--对口科室-->
          <el-form-item label="会议详情" prop="detail">
            <el-input v-model="ruleForm.detail" type="textarea" placeholder="请输入详细内容"></el-input>
          </el-form-item>
        <!--任务要求-->
          <el-form-item label="开始时间" prop="time">
             <el-date-picker
              class="el-col-22"
              v-model="ruleForm.time"
              type="date"
              placeholder="选择日期"
              >
            </el-date-picker>
          </el-form-item>
          <!--完成时间-->
          <el-form-item label="参会人员" prop="people">
            <el-checkbox-group v-model="ruleForm.people">
                 <el-checkbox @change="addTag(value)" v-for="value in users" :label="value.id" :key="value.id">{{value.name}}</el-checkbox>
                 <el-tag style="margin-right:10px"
                  @close="removeTag(tag)"
                  v-if="tags"
                  v-for="(tag,index) in tags"
                  :key="tag"
                  :closable="true"
                  :type="color[index]" 
                >
                    {{tag}}
                </el-tag>
             </el-checkbox-group>
          </el-form-item>
          <!--按钮组-->
          <el-form-item>
            <el-button v-if="isEdit" type="primary" @click="editTask('ruleForm')">立即修改</el-button>
            <el-button v-else type="primary" @click="createTask('ruleForm')">立即添加</el-button>
            <el-button @click="resetForm('ruleForm')">重置</el-button>
          </el-form-item>
        </el-form>
      </div>

    </div>
  </div>
</template>
<script>
  export default{
    data () {
      return {
        // 是否是修改
        isEdit: false,
        users: [],
        // 工作类型列表
        workTypeList: [],
        tags: [],
        // 对口科室列表
        departmentList: [],
        ruleForm: {
          title: '',
          detail: '',
          people: [],
          time: ''
        },
        color: [],
        rules: {
          title: [
            { type: 'string', required: true, message: '请填写会议名称', trigger: 'change' }
          ],
          detail: [
            { type: 'string', required: true, message: '请填写会议内容', trigger: 'change' }
          ],
          people: [
            { type: 'array', required: true, message: '请选择参会人员', trigger: 'change' }
          ],
          time: [
            { type: 'date', required: true, message: '请选择会议开始时间', trigger: 'change' }
          ]
        }
      }
    },
    watch: {
      '$route' () {
        this.ruleForm =  {
          work_type_id: '',
          department_id: '',
          end_time: '',
          title: '',
          detail: ''
        }
        this.$route.name === 'editTask' ? this.isEdit = true : this.isEdit = false
      }
    },
    mounted () {
      this.getWorkTypeList()
      this.getDepartmentsList()
      this.getUsers()
      // 修改任务
      if(this.$route.name === 'edit_task'){
        this.isEdit = true
        this.$http.get('task/' + this.$route.params.id).then(res => {
          res.data.data.end_time = new Date(res.data.data.end_time);
          this.ruleForm = res.data.data
          this.$diff.save(this.ruleForm);
        })
      }else{
        this.isEdit = false
      }
    },
    methods: {
        removeTag(x){
            for(let y in this.tags){
                if(this.tags[y] === x){
                    this.tags.splice(y,1);
                    this.ruleForm.people.splice(y,1);
                }
            }
        },
      // 创建任务
      createTask (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.$http.post('metting',{
                title: this.ruleForm.title,
                detail: this.ruleForm.detail,
                users: this.ruleForm.people,
                start_time: this.ruleForm.time
            }).then(res => {
                console.log(this.ruleForm)
              this.$message({
                message: '添加任务成功',
                type: 'success'
              })
              this.$router.push({name: 'cahier_create'})
            })
          } else {
            return false
          }
        })
      },
      addTag(value){
        for(let x in this.users){
           if(value.id === this.users[x].id){
                this.tags.push(this.users[x].name);
           }
        }
                   console.log(this.ruleForm.people);
        var color = [
                        'success','warning', 'primary', 'danger', 'gray', 'success','warning', 'primary', 'danger', 'gray']
                for(var i = 0; i < color.length; i++){
                    this.color[i] = color[Math.floor(Math.random()*10)]
                }
      },
      // 修改任务
      editTask (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.$http.post('update_task/' + this.$route.params.id, this.$diff.diff(this.ruleForm)).then(res => {
                this.$message({
                message: '修改任务成功',
                type: 'success'
              })
              this.$router.push({name: 'task_manage'})
            })
          } else {
            return false
          }
        })
      },
      // 重置
      resetForm (formName) {
        this.$refs[formName].resetFields()
      },
      // 获取工作类型列表
      getWorkTypeList () {
        this.$http.get('work_types').then(res => {
          this.workTypeList = res.data.data
        })
      },
      // 获取对口科室列表
      getDepartmentsList () {
        this.$http.get('departments').then(res => {
          this.departmentList = res.data.data
        })
      },
      //获取学院所有用户
            getUsers () {
                this.$http.get('all_users').then(res => {
                    this.users = res.data.data
                })
            }
    }
  }
</script>
<style scoped>
.item_add{
  height:100%;
  background:#fff;
}
.left{
  margin-top:30px;
}
.el-select{
  float:left;
}
.addTask{
  height:100%;
}
</style>
