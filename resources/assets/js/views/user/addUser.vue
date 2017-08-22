<template>
    <div class="addTask">
        <div class="item_add">
            <div class="left el-col-18 el-col-offset-1">
                <!--表单-->
                <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm">
                    <!--用户名-->
                    <el-form-item label="用户名" prop="name">
                        <el-input v-model="ruleForm.name" placeholder="请输入内容"></el-input>
                    </el-form-item>
                    <!--密码-->
                    <el-form-item label="密码" prop="password">
                        <el-input v-model="ruleForm.password" type="password" placeholder="请输入内容"></el-input>
                    </el-form-item>
                    <!--性别-->
                    <el-form-item label="性别" prop="gender">
                        <el-radio v-for="item in genders" :key=item.id class="radio" v-model="ruleForm.gender" :label=item.value>{{item.gender}}</el-radio>
                    </el-form-item>
                    <!--邮箱-->
                    <el-form-item label="邮箱" prop="email">
                        <el-input v-model="ruleForm.email" type="email" placeholder="请输入内容"></el-input>
                    </el-form-item>
                    <!--所属学院-->
                    <el-form-item label="所属学院" prop="college_id">
                        <el-select v-model="ruleForm.college_id" class="optionBox">
                            <el-option
                                    v-for="item in collegesList"
                                    :key="item.id"
                                    :label="item.title"
                                    :value="item.id"></el-option>
                        </el-select>
                    </el-form-item>
                    <!--用户角色-->
                    <el-form-item label="用户角色" prop="role_id">
                        <el-select v-model="ruleForm.role_id" class="optionBox">
                            <el-option
                                    v-for="item in rolesList"
                                    :key="item.id"
                                    :label="item.description"
                                    :value="item.id"></el-option>
                        </el-select>
                    </el-form-item>
                    <!--按钮组-->
                    <el-form-item>
                        <el-button v-if="isEdit" type="primary" @click="editUser('ruleForm')">立即修改</el-button>
                        <el-button v-else type="primary" @click="createUser('ruleForm')">立即创建</el-button>
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
                // 学院列表
                collegesList: [],
                // 角色列表
                rolesList: [],
                // 性别
                genders: [
                    {gender: '男', value: false, id: 0},
                    {gender: '女', value: true, id: 1}
                ],
                ruleForm: {
                    name: '',
                    email: '',
                    college_id: '',
                    picture: '',
                    gender: '',
                    password: '',
                    role_id: ''
                },
                rules: {
                    name: [
                        { type: 'string', required: true, message: '请填写用户名', trigger: 'change' }
                    ],
                    email: [
                        { type: 'string', required: true, message: '请填写邮箱', trigger: 'change' }
                    ],
                    college_id: [
                        { type: 'number', required: true, message: '请选择所属学院', trigger: 'change' }
                    ],
                    picture: [
                        { required: true, message: '请上传图片', trigger: 'change' }
                    ],
                    gender: [
                        { type: 'Boolean', required: true, message: '请选择性别', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请输入密码', trigger: 'blur' }
                    ],
                    role_id: [
                        { required: true, message: '请选择用户角色', trigger: 'blur' }
                    ]
                }
            }
        },
        watch: {
            '$route' () {
                this.ruleForm =  {
                    name: '',
                    email: '',
                    college_id: '',
                    picture: '',
                    gender: '',
                    password: '',
                    role_id: ''
                }
                this.$route.name === 'editUser' ? this.isEdit = true : this.isEdit = false
            }
        },
        mounted () {
            this.getRolesList()
            this.getCollegesList()
            // 修改任务
            if(this.$route.name === 'edit_user'){
                this.isEdit = true
                this.$http.get('user/' + this.$route.params.id).then(res => {
                    res.data.data.end_time = new Date(res.data.data.end_time);
                    this.ruleForm = res.data.data
                    this.$diff.save(this.ruleForm);
                })
            }else{
                this.isEdit = false
            }
        },
        methods: {
            // 创建任务
            createUser (formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$http.post('user',this.ruleForm).then(res => {
                            this.$message({
                                message: '添加任务成功',
                                type: 'success'
                            })
                            this.$router.push({name: 'user_lists'})
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
            editUser (formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$http.post('update_user/' + this.$route.params.id, this.$diff.diff(this.ruleForm)).then(res => {
                            this.$message({
                                message: '修改任务成功',
                                type: 'success'
                            })
                            this.$router.push({name: 'user_lists'})
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
            getRolesList () {
                this.$http.get('roles').then(res => {
                    this.rolesList = res.data.data
                })
            },
            // 获取学院
            getCollegesList () {
                this.$http.get('colleges').then(res => {
                    this.collegesList = res.data.data
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
