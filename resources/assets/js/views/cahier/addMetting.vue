<template>
  <div class="addTask">
    <div class="item_add">
      <div class="left el-col-18 el-col-offset-1">
        <!--表单-->
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" label-position="right" class="demo-ruleForm">
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
          <el-form-item label="参会学院" prop="college">
            <el-col style="margin-bottom:15px">
              <el-checkbox class="el-col-pull-10" v-model="checked">全体人员</el-checkbox>
            </el-col>
            <el-col>
              <el-select v-if="!checked" class="optionBox" v-model="ruleForm.college" @change="loadTransfer(ruleForm.college)">
              <el-option
                      v-for="item in collegesList"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id"></el-option>
              </el-select>
            </el-col>
          </el-form-item>
          <el-form-item v-if="!checked" label="该学院参会人员" prop="people">
              <el-transfer class="el-col-pull-5" :titles="['该学院所有老师','已选中老师']" v-model="ruleForm.people" :data="users"></el-transfer>
          </el-form-item>
          <!--按钮组-->
          <el-form-item>
            <el-button type="primary" @click="createTask('ruleForm')">立即添加</el-button>
            <el-button @click="resetForm('ruleForm')">重置</el-button>
          </el-form-item>
          <!-- 缺勤情况 -->
          <el-form-item v-if="!checked" label="该学院参会人员" prop="people">
              <el-transfer class="el-col-pull-5" :titles="['该学院所有老师','已选中老师']" v-model="ruleForm.people" :data="users"></el-transfer>
          </el-form-item>
          <!--按钮组-->
          <el-form-item>
            <el-button type="primary" @click="createTask('ruleForm')">立即添加</el-button>
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
        collegesList: [],
         checked: false,
        users: [],
        tags: [],
        item: [],
        ruleForm: {
          title: '',
          detail: '',
          people: [],
          college: null,
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
          college: [
            { type: 'number', required: true, message: '请选择参会学院', trigger: 'change' }
          ],
          people: [
            { type: 'array', required: true, message: '请选择参会人员' }
          ],
          time: [
            { type: 'date', required: true, message: '请选择会议开始时间', trigger: 'change' }
          ]
        }
      };
    },
    mounted () {
      this.getCollegesList();
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
      createTask (formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            if(this.checked){
              this.ruleForm.people = 'all'
            } else {
              this.ruleForm.people = this.ruleForm.people.join(',')
            }
            this.$http.post('metting',{
                title: this.ruleForm.title,
                detail: this.ruleForm.detail,
                users: this.ruleForm.people,
                start_time: this.ruleForm.time
            }).then(res => {
                console.log(this.ruleForm)
              this.$message({
                message: '添加会议成功',
                type: 'success'
              })
              this.$router.push({name: 'cahier_lists'})
            })
          } else {
            return false
          }
        })
      },
      resetForm (formName) {
        this.$refs[formName].resetFields()
      },
      getCollegesList () {
          this.$http.get('colleges').then(res => {
              this.collegesList = res.data.data
          })
      },
      loadTransfer (id) {
          this.users.splice(this.users.length);
          this.$http.get('users/'+id).then(res => {
            for(let x in res.data.users){
              this.users.push({
                key: res.data.users[x].id,
                label: res.data.users[x].name
              });
            }
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
.el-transfer-panel__item .el-checkbox__input{
    left:40px;
  }
</style>
