<template>
  <div class="addTask ">
    <div class="item_add item">
      <div class="left el-col-18 el-col-offset-1">
        <!--表单-->
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">

          <!--任务要求-->
          <el-form-item label="推迟理由" prop="name">
            <el-input v-model="ruleForm.name"></el-input>
          </el-form-item>
          <!--任务内容-->
          <el-form-item label="完成情况" prop="detail">
            <el-input type="textarea" :rows="8" v-model="ruleForm.detail"></el-input>
          </el-form-item>

          <!--上传附件-->
          <!--<el-form-item label="上传附件">-->
          <!--<el-upload-->
          <!--class="upload-demo el-col-6"-->
          <!--drag-->
          <!--action="https://jsonplaceholder.typicode.com/posts/"-->
          <!--multiple>-->
          <!--<i class="el-icon-upload"></i>-->
          <!--<div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>-->
          <!--&lt;!&ndash;<div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>&ndash;&gt;-->
          <!--</el-upload>-->
          <!--</el-form-item>-->

          <!--按钮组-->
          <el-form-item>
            <el-button type="primary" @click="submitForm('ruleForm')">提交任务</el-button>
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
        options: [{
          value: 'xueyuan',
          label: '学院负责人'
        }, {
          value: 'juti',
          label: '具体负责人',
          children: [{
            value: 'danyi',
            label: '具体单一'
          }, {
            value: 'all',
            label: '全体人员'
          }, {
            value: 'sort',
            label: '规则分类'
          }]
        }],
        default1: '',
        default2: '',
        ruleForm: {
          workType: '',
          section: '',
          date1: '',
          date2: '',
          name: '',
          detail: ''
        },
        rules: {
          responser: [
            { type: 'array', required: true, message: '请至少添加一个责任人', trigger: 'change' }
          ],
          name: [
            { required: true, message: '请输入推迟理由', trigger: 'change' },
            { min: 3, max: 20, message: '长度在 3 到 20 个字符', trigger: 'blur' }
          ],
          detail: [
            { required: true, message: '请简述任务完成情况', trigger: 'blur' }
          ]
        }
      }
    },
    methods: {
      submitForm (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            alert('submit!')
          } else {
            console.log('error submit!!')
            return false
          }
        })
      },
      resetForm (formName) {
        this.$refs[formName].resetFields()
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
</style>
