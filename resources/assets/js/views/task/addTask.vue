<template>
  <div class="addTask">
    <div class="item_add">
      <div class="left el-col-18 el-col-offset-1">
        <!--表单-->
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
          <el-form-item label="工作类型" prop="work_type_id">
            <el-select v-model="ruleForm.work_type_id" class="optionBox">
              <el-option
                v-for="item in workTypeList"
               :key="item.id"
               :label="item.title"
               :value="item.id">
             </el-option>
            </el-select>
          </el-form-item>
          <!--对口科室-->
          <el-form-item label="对口科室" prop="department_id">
            <el-select v-model="ruleForm.department_id" class="optionBox">
              <el-option
                v-for="item in departmentList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
            </el-select>
          </el-form-item>
          <!--完成时间-->
          <el-form-item label="完成时间" prop="end_time">
            <el-col :span="1">
              <el-date-picker
                v-model="ruleForm.end_time"
                type="date"
                placeholder="选择日期">
              </el-date-picker>
           </el-col>
          </el-form-item>
          <!--任务要求-->
          <el-form-item label="任务名称" prop="title">
            <el-input v-model="ruleForm.title" placeholder="请输入任务名称"></el-input>
          </el-form-item>
          <!--任务内容-->
          <el-form-item label="任务内容" prop="detail">
            <el-input type="textarea" :rows="8" placeholder="请输入任务详情" v-model="ruleForm.detail"></el-input>
          </el-form-item>
          <!--按钮组-->
          <el-form-item>
            <el-button v-if="isEdit" type="primary" @click="editTask('ruleForm')">立即修改</el-button>
            <el-button v-else type="primary" @click="createTask('ruleForm')">立即创建</el-button>
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
        // 工作类型列表
        workTypeList: [],
        // 对口科室列表
        departmentList: [],
        ruleForm: {
          work_type_id: '',
          department_id: '',
          end_time: '',
          title: '',
          detail: ''
        },
        rules: {
          work_type_id: [
            { type: 'number', required: true, message: '请选择工作类型', trigger: 'change' }
          ],
          department_id: [
            { type: 'number', required: true, message: '请选择对口科室', trigger: 'change' }
          ],
          end_time: [
            { type: 'date', required: true, message: '请选择日期', trigger: 'change' }
          ],
          title: [
            { required: true, message: '请输入任务名称', trigger: 'change' }
          ],
          detail: [
            { required: true, message: '请输入任务内容', trigger: 'blur' }
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
      // 修改任务
      if(this.$route.name === 'edit_task'){
        this.isEdit = true
        this.$http.get('task/' + this.$route.params.id).then(res => {
          res.data.data.end_time = new Date(res.data.data.end_time);

          this.ruleForm = res.data.data
            console.log(this.ruleForm)
          this.$diff.save(this.ruleForm);
        })
      }else{
        this.isEdit = false
      }
    },
    methods: {
      // 创建任务
      createTask (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.$http.post('create_task',this.ruleForm).then(res => {
                console.log(this.ruleForm)
              this.$message({
                message: '添加任务成功',
                type: 'success'
              })
              this.$router.push({name: 'task_manage'})
            }).catch(res => {
                $message: ({
                    type: 'error',
                    message: res.data.message
                })
            })
          } else {
            return false
          }
        })
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
