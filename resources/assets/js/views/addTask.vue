<template>
  <div class="addTask">
    <JHeader></JHeader>
    <navMenu></navMenu>
    <div class="item_add">
      <div class="left el-col-18 el-col-offset-1">
        <!--表单-->
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">

          <!--责任人-->
          <!--<el-form-item label="责任人" prop="name">-->
            <!--<el-cascader-->
              <!--:options="options"-->
              <!--change-on-select-->
              <!--class="el-col-6"-->
            <!--&gt;</el-cascader>-->
          <!--</el-form-item>-->

          <!--工作类型-->
          <el-form-item label="工作类型" prop="workType">
            <el-select v-model="default1" class="optionBox">
              <el-option
                v-for="item in options1"
               :key="item.value"
               :label="item.label"
               :value="item.value"></el-option>
            </el-select>
          </el-form-item>
          <!--对口科室-->
          <el-form-item label="对口科室" prop="section">
            <el-select v-model="default2" class="optionBox">
              <el-option
                v-for="item in options2"
                :key="item.value"
                :label="item.label"
                :value="item.value"></el-option>
            </el-select>
          </el-form-item>
          <!--完成时间-->
          <el-form-item label="完成时间">
            <el-col :span="7" :pull="1">
              <el-form-item prop="date1">
                <el-date-picker type="date" placeholder="选择日期" v-model="ruleForm.date1" style="width: 100%;"></el-date-picker>
              </el-form-item>
            </el-col>
            <el-col class="line" :pull="1" :span="1">-</el-col>
            <el-col :span="7" :pull="2">
              <el-form-item prop="date2">
                <el-time-picker type="fixed-time" placeholder="选择时间" v-model="ruleForm.date2" style="width: 100%;"></el-time-picker>
              </el-form-item>
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
            <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
            <el-button @click="resetForm('ruleForm')">重置</el-button>
          </el-form-item>
        </el-form>
      </div>

    </div>
  </div>
</template>
<script>
  import JHeader from '../components/header.vue'
  import navMenu from '../components/navMenu.vue'
  export default{
    components: {
      JHeader,
      navMenu
    },
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
        options1: [
          {
            value: 'zhongdian',
            label: '重点'
          },
          {
            value: 'changgui',
            label: '常规工作'
          },
          {
            value: 'tufa',
            label: '突发工作'
          },
          {
            value: 'other',
            label: '其他工作'
          }
        ],
        options2: [
          {
            value: 'student',
            label: '学生管理'
          },
          {
            value: 'sixiang',
            label: '思想教育'
          },
          {
            value: 'zizhu',
            label: '学生资助'
          },
          {
            value: 'healthy',
            label: '心理健康'
          },
          {
            value: 'lingdao',
            label: '领导交办'
          }
        ],
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
          workType: [
            { required: true, message: '请选择工作类型', trigger: 'blur' }
          ],
          section: [
            { type: 'array', required: true, message: '请选择对口科室', trigger: 'blur' }
          ],
          date1: [
            { type: 'date', required: true, message: '请选择日期', trigger: 'change' }
          ],
          date2: [
            { type: 'date', required: true, message: '请选择时间', trigger: 'change' }
          ],
          name: [
            { required: true, message: '请输入任务名称', trigger: 'change' },
            { min: 3, max: 20, message: '长度在 3 到 20 个字符', trigger: 'blur' }
          ],
          detail: [
            { required: true, message: '请输入任务内容', trigger: 'blur' }
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
.addTask{
  height:100%;
}
</style>
