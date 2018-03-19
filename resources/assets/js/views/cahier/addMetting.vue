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
          <el-form-item label="会议时间" prop="time">
             <el-date-picker
              class="el-col-22"
              v-model="ruleForm.time"
              type="datetime"
              placeholder="选择日期时间">
            </el-date-picker>
          </el-form-item>
          <el-form-item v-if="$route.name === 'cahier_edit'">
            <span>请重新选择参会人员</span>
          </el-form-item>
          <!--完成时间-->
            <el-form-item style="margin-bottom:0px;" label="全体人员参会">
               <el-checkbox :disabled="restoreCheck" @change="theAllUsers()" style="margin-left:-25px;" class="el-col-pull-11" v-model="checked"></el-checkbox>
            </el-form-item> 
            <div v-if="!checked" >
              <el-form-item label="参会学院" prop="college">
                <el-col>
                  <el-select class="optionBox" v-model="ruleForm.college" @change="getAllUsers(ruleForm.college)">
                  <el-option
                          v-for="item in collegesList"
                          :key="item.id"
                          :label="item.title"
                          :value="item.id"></el-option>
                  </el-select>
                </el-col>
              </el-form-item>
              <el-form-item style="margin:22px 0;"  label="参会人员" prop="people">
                  <el-transfer @change="handleChange" filterable filter-placeholder="请输入老师姓名或学院名称" style="margin-left:15px;" class="el-col-pull-1 allUser" :titles="['所有老师','已选中老师']" v-model="ruleForm.people" :data="allUsers"></el-transfer>
              </el-form-item>
            </div>
            <el-form-item label="缺勤人员" prop="late">
            <el-checkbox-group v-model="late" v-if="attendPeo.length !== 0">
              <el-checkbox :disabled="value.status !== null" v-for="value in attendPeo" :label="value.key" :key="value.key">{{value.label}}</el-checkbox>
            </el-checkbox-group>
                <p v-else>{{tips}}</p>
          </el-form-item>
          <el-form-item label="缺勤情况" prop="late_id" >
            <el-col :pull="6">
              <el-radio-group v-model="ruleForm.late_id" @change="changeUser()">
                <el-radio-button v-for="item in lates" :key="item.id" :label="item.id">{{item.title}}</el-radio-button>
              </el-radio-group>
            </el-col>
          </el-form-item>
         
          <!--按钮组-->
          <el-form-item>
            <el-button v-if="$route.name === 'cahier_create'" type="primary" @click="createTask('ruleForm')">立即添加</el-button>
            <el-button v-else type="primary" @click="modifyTask()">修改</el-button>
            <!-- <el-button @click="resetForm('ruleForm')">重置</el-button> -->
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
        restoreCheck: false,
        absent_cause:[],
        item: [],
        attendPeo: [],
        isLate: false,
        late: [],
        checked: false,
        temp:[],
        tips: '当前参会人员为空, 请先选择参会人员',
        ruleForm: {
          title: '',
          place: '',
          detail: '',
          people: [],
          time: '',
          college: null,
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
          time: [
            { type: 'date', required: true, message: '请选择会议开始时间', trigger: 'change' }
          ]
        }
      };
    },
     watch:{
      '$route' () {
        if (this.$route.name === 'cahier_edit') {
          this.getMeetingItem();
        } else {
          this.ruleForm = {
            title: '',
            place: '',
            detail: '',
            people: [],
            time: '',
            college: null,
            late_id: null,
            late: []
          }
        }
      }
    },
    mounted () {
      this.getCollegesList();
      this.getLate();
      if (this.$route.name === 'cahier_edit') {
        this.getMeetingItem();
      } else {
        this.ruleForm = {
          title: '',
          place: '',
          detail: '',
          people: [],
          time: '',
          college: null,
          late_id: null,
          late: []
        }
      }
    },
    methods: {
      // 修改会议
      modifyTask () {
        let tempPeple = ''; 
         if(this.checked){
            tempPeple = 'all'
          } else {
            tempPeple = this.ruleForm.people.join(',')
          }
          if(this.ruleForm.title === '' || this.ruleForm.detail === '' || tempPeple === '' || this.ruleForm.place === '' || this.ruleForm.time === ''){
            this.$message.warning('请将表单补充完整！')
          } else {
        this.$http.post('metting/' + this.$route.params.id, {
          title: this.ruleForm.title,
          detail: this.ruleForm.detail,
          users: tempPeple,
          address: this.ruleForm.place,
          start_time: this.ruleForm.time,
          absent_cause:this.absent_cause
        }).then(res => {
          this.$message({
            message: '修改成功',
            type: 'success'
          });
          this.$router.push({name: 'cahier_lists'});
        })
          }

      },
      // 获取会议信息
      getMeetingItem () {
        this.$http.get('metting/' + this.$route.params.id).then(res => {
          this.ruleForm = {
            title: res.data.data.title,
            place: res.data.data.address,
            detail: res.data.data.detail,
            time: res.data.data.start_time,
            people: [],
            college: null,
            late_id: null,
            late: []
          };
        })
      },
      theAllUsers () {
        if(this.checked === true){
          this.restoreCheck = true;
          this.tips = '数据加载中...请稍侯';
          this.$http.get('all_users?include=roles,college').then(res => {
            this.restoreCheck = false;
            this.$message.success('选择成功！当前参会人员为全体人员')
            for(let x in res.data.data){
              this.attendPeo.push({
                label: (res.data.data[x].college.data.title || '学生处') + ' - ' + res.data.data[x].nickname,
                key: res.data.data[x].id,
                status: null
              })
            }
          })
        } else {
          this.attendPeo.splice(0, this.attendPeo.length);
          this.tips = '当前参会人员为空, 请先选择参会人员';
        }
      },
      handleChange(value, direction, movedKeys) {
        if(direction === 'right') {
          this.allAttend(movedKeys);
        }else{
          for(let x = 0; x < this.attendPeo.length; x++){
            for(let y = 0; y < movedKeys.length; y++){
              if(this.attendPeo[x].key === movedKeys[y]){
                this.attendPeo.splice(x, 1);
              }
            }
          }
        }
      },
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
      allAttend(value){
          this.$message.success('已选参会人员共' + this.ruleForm.people.length + '人，请继续填写表单')
          for(let x = 0; x < value.length;x++){
            for(let y=0;y < this.allUsers.length;y++){
              if(value[x] === this.allUsers[y].key){
                this.attendPeo.push({
                  label: this.allUsers[y].label,
                  key: this.allUsers[y].key,
                  status: null
                })
              }
            }
          }
      },
      createTask (formName) {
        let tempPeple = '';
        this.$refs[formName].validate((valid) => {
          if (valid) {
            if(this.checked){
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
      getAllUsers(college_id){
        this.allUsers.splice(0, this.allUsers.length);
        this.$http.get('users/' + (college_id)).then(res => {
          for(let x in this.collegesList){
            for(let y in res.data.users) {
              if(college_id == this.collegesList[x].id) {
                this.allUsers.push({
                  key:  res.data.users[y].id,
                  label:  (this.collegesList[x].title || '学生处') + ' - ' + res.data.users[y].nickname
                });
              }
            }
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
</style>
