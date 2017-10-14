<template>
  <div class="addTask">
    <div class="item_add">
      <div class="left el-col-18 el-col-offset-1">
        <!--表单-->
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="150px" label-position="right" class="demo-ruleForm">
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
            <el-form-item label="全体人员参会">
               <el-checkbox style="margin-left:-25px;" class="el-col-pull-11" v-model="checked"></el-checkbox>
            </el-form-item> 
          <el-form-item v-if="!checked" label="参会学院" prop="college">
            <el-col>
              <el-select class="optionBox" v-model="ruleForm.college" @change="loadTransfer(ruleForm.college)">
              <el-option
                      v-for="item in collegesList"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id"></el-option>
              </el-select>
            </el-col>
          </el-form-item>
          <el-form-item v-if="!checked" label="该学院参会人员" prop="people">
              <el-transfer style="margin-left:15px;" class="el-col-pull-5" :titles="['该学院所有老师','已选中老师']" v-model="ruleForm.people" :data="users"></el-transfer>
          </el-form-item>
          <el-form-item>
             <p class="el-col-pull-6" style="color:#666;"><span style="color:red;">*</span>参会人员全部选择完成后，请单击选择完成按钮以确认选择情况</p>
              <el-button :disabled="ruleForm.people ===null" class="el-col-10" @click="allAttend()">完成</el-button>
          </el-form-item>
           <el-form-item label="是否有缺勤人员" prop="people">
              <el-switch
              class="el-col-pull-11"
                v-model="isLate"
                on-text="是"
                off-text="否">
              </el-switch>
           </el-form-item>
           <div v-if="isLate">
              <el-form-item label="缺勤情况" prop="late_id">
            <el-col>
              <el-select class="optionBox" v-model="ruleForm.late_id">
              <el-option
                      v-for="item in lates"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id"></el-option>
              </el-select>
            </el-col>
          </el-form-item>
          <el-form-item label="缺勤人员" prop="late">
            <el-checkbox-group v-model="ruleForm.late">
              <el-checkbox v-for="value in attendPeo" :label="value.label" :key="value.key"></el-checkbox>
            </el-checkbox-group>
          </el-form-item>
           </div>
         
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
        lates: [],
        collegesList: [],
        checked: false,
        users: [],
        tags: [],
        item: [],
        attendPeo: [],
        isLate: false,
        ruleForm: {
          title: '',
          detail: '',
          people: [],
          college: null,
          time: '',
          late: [],
          late_id: null
        },
        allUsers: [],
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
          late_id: [
            { type: 'number', required: true, message: '请选择缺勤原因', trigger: 'change' }
          ],
          late: [
            { type: 'array', required: true, message: '请选择缺勤人员' }
          ],
          time: [
            { type: 'date', required: true, message: '请选择会议开始时间', trigger: 'change' }
          ]
        }
      };
    },
    mounted () {
      this.getCollegesList();
      this.getLate();
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
      allAttend(){
        if(this.checked){
          alert('确认成功！参会人员为全体成员，请继续填写表单');
          this.getAllUsers();
          this.attendPeo = this.allUsers;
        } else {
          alert('确认成功！已选参会人员共' + this.ruleForm.people.length + '人，请继续填写表单')
          for(let x = 0; x < this.ruleForm.people.length;x++){
            for(let y=0;y < this.users.length;y++){
              if(this.ruleForm.people[x] === this.users[y].key){
                this.attendPeo.push({
                  label: this.users[y].label,
                  key: this.users[y].key
                })
              }
            }
          }
          console.log(this.attendPeo)
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
      getAllUsers(){
        this.users.splice(this.users.length);
        this.$http.get('all_users').then(res => {
          for(let x in res.data.data){
            this.allUsers.push({
              key: res.data.data[x].id,
              label: res.data.data[x].name
            });
          }
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
      },
      //获取缺勤原因
      getLate () {
          this.$http.get('appraises/lates').then( res=> {
              this.lates = res.data.data
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
