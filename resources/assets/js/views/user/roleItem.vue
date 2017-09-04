<template>
    <div class="addTask">
        <div class="item_add">
            <div class="left el-col-13 el-col-offset-1">
                <!--表单-->
                <el-form v-if="isEdit" :rules="rules" label-width="150px" class="demo-ruleForm">
                    <!--用户角色-->
                    <el-form-item label="角色名（后台）" prop="name">
                        <el-input v-model="role.name"></el-input>
                    </el-form-item>
                    <!--用户角色-->
                    <el-form-item label="角色名（显示）">
                        <el-input v-model="role.display_name"></el-input>
                    </el-form-item>
                    <!--用户角色-->
                    <el-form-item label="角色描述">
                        <el-input v-model="role.description"></el-input>
                    </el-form-item>
                    <!--权限选择-->
                     <el-form-item label="权限选择">
                         <template>
                             <el-checkbox-group v-model="rolePer_id">
                                 <el-checkbox v-for="value in permissions" :label="value.id" :key="value.id">{{value.display_name}}</el-checkbox>
                             </el-checkbox-group>
                         </template>
                    </el-form-item>
                    <!--按钮组-->
                    <el-form-item class="btnGroup">
                        <el-button type="primary" @click="editRole()">立即修改</el-button>
                    </el-form-item>
                </el-form>

                <el-form v-else :rules="rules" label-width="150px" class="demo-ruleForm el-col-20">
                    <!--用户角色-->
                    <el-form-item label="角色名（后台）" prop="name">
                        <p style="text-align:left;padding-left:20px">{{role.name}}</p>
                    </el-form-item>
                    <!--用户角色-->
                    <el-form-item label="角色名（显示）">
                        <p style="text-align:left;padding-left:20px">{{role.display_name}}</p>
                    </el-form-item>
                    <!--用户角色-->
                    <el-form-item label="角色描述">
                        <p style="text-align:left;padding-left:20px">{{role.description}}</p>
                    </el-form-item>
                    <!--权限选择-->
                    <el-form-item label="角色所有权限">
                        <el-tag  style="text-align:left;margin-right:20px;" :type=color[index] v-for="(value, index) in rolePer" :key="value.id">{{value.display_name}}</el-tag>
                    </el-form-item>
                    <!--按钮组-->
                    <el-form-item class="btnGroup">
                        <el-button @click="goEdit()" type="primary">去修改</el-button>
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
                //所有权限
                permissions: [],
                //当前角色所有的权限
                rolePer_id: [],
                //当前角色信息
                role: {
                    name: '',
                    display_name: '',
                    description: ''
                },
                //标签颜色
                color: [],
                isEdit: false,
                rules: {
                }
            }
        },
        watch: {
            '$route': 'isBrowser'
        },
        mounted () {
            this.getRole()
            this.getRolePer()
            this.getPermissions()
            this.isColor()
            // 修改任务
            if(this.$route.name === 'edit_roles'){
                this.isEdit = true
                this.rules = {
                    name: [
                        { type: 'string', required: true, message: '请填写角色名', trigger: 'blur'}
                    ]
                }
            }else if(this.$route.name === 'browser_roles'){
                this.isEdit = false
            }
        },
        methods: {
            //随机生成颜色
            isColor () {
                var color = ['success','warning', 'primary', 'danger', 'gray', 'success','warning', 'primary', 'danger', 'gray']
                for(var i = 0; i < color.length; i++){
                    this.color[i] = color[Math.floor(Math.random()*10)]
                }
            },
            //判断当前页面
            isBrowser(){
                if(this.$route.name === 'edit_roles'){
                    this.isEdit = true
                    this.rules = {
                        name: [
                            { type: 'string', required: true, message: '请填写角色名', trigger: 'blur'}
                        ]
                    }
                }else if(this.$route.name === 'browser_roles'){
                    this.isEdit = false
                    this.rules = null
                }
            },
            //获取角色信息
            getRole () {
                this.$http.get('role/' + this.$route.params.id).then(res => {
                    this.role = res.data.data
                })
            },
            //获取角色所有权限
            getRolePer () {
                this.$http.get('role/' + this.$route.params.id + '/permissions').then(res => {
                    for(let x in res.data.data){
                        this.rolePer_id = res.data.data.map(item => {
                            return item.id;
                        })
                    }
                })
            },
            goEdit(){
                this.$router.push({name: 'edit_roles'})
            },
            //修改角色
            editRole () {
                this.$http.post('update_role/' + this.$route.params.id, {
                    name: this.role.name,
                    display_name: this.role.display_name,
                    description: this.role.description,
                    permission_ids: this.rolePer
                }).then(res => {

                })
            },
            //获取所有权限
            getPermissions () {
                this.$http.get('permissions/all').then(res => {
                    this.permissions = res.data.data
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
    .radio{
        margin-left:-280px;
    }
    .el-upload>.el-button{
        margin-left:-280px;
    }
    .btnGroup{
        margin-top:20px;
        margin-left:-100px;
    }
    .btnGroup>button{
        margin-right:30px;
    }
    .isPass{
        width:200px;
        cursor:pointer;
        height:30px;
        border:1px solid #1D8CE0;
        background:transparent;
        border-radius:3px;
        color:#1D8CE0;

    }
    .el-checkbox{
        text-align:left;
    }
</style>
