<template>
  <div class="addTask">
    <div class="item_add">
      <div class="left el-col-18 el-col-offset-1">
        <!--表单-->
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="150px" label-position="right" class="demo-ruleForm">
          <el-form-item label="会议名称" prop="title">
             <el-input v-model="ruleForm.title" placeholder="请输入会议名称"></el-input>
          </el-form-item>
            <el-form-item label="开会地点" prop="place">
                <el-input v-model="ruleForm.place" placeholder="请输入开会地点"></el-input>
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
              placeholder="选择日期">
            </el-date-picker>
          </el-form-item>
          <!--完成时间-->
    <!--         <el-form-item style="margin-bottom:0px;" label="全体人员">
               <el-checkbox style="margin-left:-25px;" class="el-col-pull-11" v-model="checked"></el-checkbox>
            </el-form-item>  -->
          <!-- <el-form-item v-if="!checked" label="参会学院" prop="college">
            <el-col>
              <el-select class="optionBox" v-model="ruleForm.college" @change="loadTransfer(ruleForm.college)">
              <el-option
                      v-for="item in collegesList"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id"></el-option>
              </el-select>
            </el-col>
          </el-form-item> -->
          <el-form-item style="margin:22px 0;"  label="参会人员" prop="people">
              <el-transfer filterable filter-placeholder="请输入老师姓名或学院名称" style="margin-left:15px;" class="el-col-pull-1 allUser" :titles="['所有老师','已选中老师']" v-model="ruleForm.people" :data="allUsers"></el-transfer>
          </el-form-item>
          <el-form-item>
             <p class="el-col-pull-5" style="color:#666;"><span style="color:red;">*</span>参会人员全部选择完成后，请单击选择完成按钮以便填写缺勤情况</p>
              <el-button :disabled="ruleForm.people ===null" class="el-col-8" @click="allAttend()">选择完成</el-button>
          </el-form-item>
           <el-form-item label="是否有缺勤人员" prop="absent">
              <el-switch
              :disabled="isHas"
              class="el-col-pull-11"
                v-model="isLate"
                on-text="是"
                off-text="否">
              </el-switch>
           </el-form-item>
           <div v-if="isLate">
            <el-form-item label="缺勤人员" prop="late">
            <el-checkbox-group v-model="late" v-if="attendPeo.length !== 0">
              <el-checkbox :disabled="value.status !== null" v-for="value in attendPeo" :label="value.key" :key="value.key">{{value.label}}</el-checkbox>
            </el-checkbox-group>
                <p v-else>当前参会人员为空, 请先选择参会人员</p>
          </el-form-item>
          <el-form-item label="缺勤情况" prop="late_id" >
            <el-col :pull="6">
              <el-radio-group v-model="ruleForm.late_id" @change="changeUser()">
                <el-radio-button v-for="item in lates" :key="item.id" :label="item.id">{{item.title}}</el-radio-button>
              </el-radio-group>
             <!--  <el-select class="optionBox" v-model="ruleForm.late_id" @change="changeUser()">
              <el-option
                      v-for="item in lates"
                      :key="item.id"
                      :label="item.title"
                      :value="item.id"></el-option>
              </el-select> -->
            </el-col>
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
        isHas: true,
        collegesList: [],
        tags: [],
        absent_cause:[],
        item: [],
        attendPeo: [],
        isLate: false,
        late: [],
        checked: false,
        temp:[],
        ruleForm: {
          title: '',
          place: '',
          detail: '',
          people: [],
          time: '',
          late_id: null,
          late: []
        },
        allUsers: [],
        color: [],
        rules: {
          title: [
            { type: 'string', required: true, message: '请填写会议名称', trigger: 'change' }
          ],
          place: [
            { type: 'string', required: true, message: '请填写会议地点', trigger: 'change' }
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
          // absent: [
          //   {type:'boolean', required: true,message: '请选择缺勤情况',trigger: 'change'}
          // ],
          // late: [
          //   { type: 'array', required: true, message: '请选择缺勤人员',trigger: 'change' }
          // ],
          time: [
            { type: 'date', required: true, message: '请选择会议开始时间', trigger: 'change' }
          ]
        }
      };
    },
    // watch:{
    //   late: function(){
    //     this.ruleForm.late.splice(this.ruleForm.late)
    //     for(let i in this.late){
    //       this.ruleForm.late.push({
    //         id: this.ruleForm.late_id,
    //         users: this.late[i]
    //       })
    //     }
    //   }
    // },
    mounted () {
      this.getCollegesList();
      this.getLate();
      this.getAllUsers();
    },
    watch:{
      users: function(){
        this.getAllUsers()
      }
    },
    computed: {
        users () {
            return this.$store.state.users ? this.$store.state.users : {};
        }
    },
    methods: {
      changeUser(){
        for(let i in this.late){
          this.absent_cause.push({
            assess_id: this.ruleForm.late_id,
            user_id: this.late[i]
          })
        }
        this.late.splice(0,this.late.length);
        for(let x in this.absent_cause){
         for(let y in this.attendPeo){
          if(this.absent_cause[x].user_id === this.attendPeo[y].key){
           this.attendPeo[y].status = this.absent_cause[x].assess_id
          }
         }
        }
      },
      allAttend(){
        this.attendPeo.splice(0, this.attendPeo.length);
        this.isHas = false;
        if(this.ruleForm.people.length === this.allUsers.length){
          this.$message.success('确认成功！参会人员为全体成员，请继续填写表单');
          for(let i in this.allUsers){
            this.attendPeo.push({
              label: this.allUsers[i].label,
              key: this.allUsers[i].key,
              status: null
            })
          }
        } else if(this.ruleForm.people.length === 0){
            this.$message.warning('当前参会人员为空，请先选择参会人员！');
            return;
        }else{
            this.attendPeo.splice(0, this.attendPeo.length);
          this.$message.success('确认成功！已选参会人员共' + this.ruleForm.people.length + '人，请继续填写表单')
          for(let x = 0; x < this.ruleForm.people.length;x++){
            for(let y=0;y < this.allUsers.length;y++){
              if(this.ruleForm.people[x] === this.allUsers[y].key){
                this.attendPeo.push({
                  label: this.allUsers[y].label,
                  key: this.allUsers[y].key,
                  status: null
                })
              }
            }
          }
            if(this.attendPeo.length === 0){
                this.$message.warning('当前未选择参会人员，请先选择参会人员！');
                return;
            }
        }  
      },
      createTask (formName) {
        let tempPeple = '';
        this.$refs[formName].validate((valid) => {
          if (valid) {
            if(this.ruleForm.people.length === this.allUsers.length){
              tempPeple = 'all'
            } else {
              tempPeple = this.ruleForm.people.join(',')
            }
            this.$http.post('metting',{
                title: this.ruleForm.title,
                detail: this.ruleForm.detail,
                users: tempPeple,
                address: this.ruleForm.place,
                start_time: this.ruleForm.time,
                absent_cause:this.absent_cause
            }).then(res => {
              this.$message({
                message: '添加会议成功',
                type: 'success'
              })
              this.$router.push({name: 'cahier_lists'})
            }).catch(err => {
                            for(let i in err.response.data.message){
                                this.$message({
                                  type: 'error',
                                  message: err.response.data.message[i]
                              })  
                            }
                                                         
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
        for(let x in this.users){
            this.allUsers.push({
              key: this.users[x].id,
              label: (this.users[x].college.title || '学生处') + ' - ' + this.users[x].nickname
            });
          }
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
</style>
