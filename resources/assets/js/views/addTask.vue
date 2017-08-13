<template>
  <div class="addTask">
    <div class="item_add">
      <div class="left el-col-18 el-col-offset-1">
        <!--表单-->
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
          <el-form-item label="工作类型" prop="workType">
            <el-select v-model="ruleForm.workType" class="optionBox">
              <el-option
                v-for="item in workTypeList"
               :key="item.id"
               :label="item.title"
               :value="item.id">
             </el-option>
            </el-select>
          </el-form-item>
          <!--对口科室-->
          <el-form-item label="对口科室" prop="department">
            <el-select v-model="ruleForm.department" class="optionBox">
              <el-option
                v-for="item in departmentList"
                :key="item.id"
                :label="item.title"
                :value="item.id"></el-option>
            </el-select>
          </el-form-item>
          <!--完成时间-->
          <el-form-item label="完成时间" prop="date">
            <el-col :span="1">
              <el-date-picker
                v-model="ruleForm.date"
                type="datetime"
                placeholder="选择日期时间"
                format="yyyy-mm-dd HH:mm:ss">
              </el-date-picker>
           </el-col>
          </el-form-item>
          <!--任务要求-->
          <el-form-item label="任务名称" prop="name">
            <el-input v-model="ruleForm.name" placeholder="请输入任务名称"></el-input>
          </el-form-item>
          <!--任务内容-->
          <el-form-item label="任务内容" prop="detail">
            <el-input type="textarea" :rows="8" placeholder="请输入任务详情" v-model="ruleForm.detail"></el-input>
          </el-form-item>
          <!--按钮组-->
          <el-form-item>
            <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
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
        // 工作类型列表
        workTypeList: [],
        // 对口科室列表
        departmentList: [],
        ruleForm: {
          workType: '',
          department: '',
          date: '',
          name: '',
          detail: ''
        },
        rules: {
          workType: [
            { type: 'number', required: true, message: '请选择工作类型', trigger: 'change' }
          ],
          department: [
            { type: 'number', required: true, message: '请选择活动区域', trigger: 'change' }
          ],
          date: [
            { type: 'date', required: true, message: '请选择日期', trigger: 'change' }
          ],
          name: [
            { required: true, message: '请输入任务名称', trigger: 'change' }
          ],
          detail: [
            { required: true, message: '请输入任务内容', trigger: 'blur' }
          ]
        }
      }
    },
    mounted () {
      this.getWorkTypeList()
      this.getDepartmentsList()
    },
    methods: {
      submitForm (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.$http.post('create_task', {
              title: this.ruleForm.name,
              detail: this.ruleForm.detail,
              work_type_id: this.ruleForm.workType,
              department_id: this.ruleForm.department,
              end_time: this.ruleForm.date
            }).then(res => {
              this.resetForm('ruleForm')
              this.$message({
                message: '添加任务成功',
                type: 'success'
              })
            }, res => {
              this.$message.error(res.body.message)
              console.log(res)
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
