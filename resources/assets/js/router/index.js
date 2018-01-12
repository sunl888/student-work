import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
const parentComponent = {template: '<router-view></router-view>'}
export default new Router({
  routes: [
    {
      path: '*',
      redirect: {name: 'home'}
    },
    {
      path: '/home',
      name: 'home',
      meta: {title: '首页'},
      component: require('../views/Home.vue'),
      children: [
        {
          path: 'task_manage',
          meta: {title: '任务管理'},
          component: parentComponent,
          children: [
            {
              path: '',
              name: 'task_manage',
              component: require('../views/task/taskManage.vue')
            },
            {
              path: 'query_task/:state',
              name: 'query_task',
              meta: {
                  title: '查询任务'
              },
              component: require('../views/task/queryTask.vue')
            },
            {
              path: 'add_task',
              name: 'add_task',
              meta: {title: '添加任务'},
              component: require('../views/task/addTask.vue')
            },
            {
              path: 'edit_task/:id',
              name: 'edit_task',
              meta: {title: '修改任务'},
              component: require('../views/task/addTask.vue')
            },
            {
                //管理员
                path: 'task_item/:id/:college?',
                name: 'task_item',
                meta: {title: '任务详情'},
                component: require('../views/task/taskItem.vue')
            },             
            {
                path: 'task_score/:id/:college_id?',
                name: 'task_score',
                meta: {title: '任务评分'},
                component: require('../views/task/taskScore.vue')
            },
            {
                path: 'browse_score/:id/:college_id?',
                name: 'browse_score',
                meta: {title: '查看评分结果'},
                component: require('../views/task/taskScore.vue')
            }
          ]
        },
        {
          path: 'tasks_of_college',
          meta: {title: '任务管理'},
          component: parentComponent,
          children: [
            {
                  //各学院首页
                path: '',
                name: 'tasks_of_college',
                meta: {title: '任务列表'},
                component: require('../views/task/unfinishedWork.vue')
            },
            {
                //各学院
                path: 'task_detail/:id/:college?',
                name: 'task_detail',
                meta: {title: '任务详情'},
                component: require('../views/task/taskDetail.vue')
            },
          ]
        },
        {
          path: 'tasks_of_teacher',
          meta: {title: '任务管理'},
          component: parentComponent,
          children: [
            {
                  //各学院老师首页
                  path: '',
                  name: 'tasks_of_teacher',
                  meta: {title: '任务列表'},
                  component: require('../views/task/tasksOfTeacher.vue')
            },
            {
                //各学院老师
                path: 'task_information/:id/:college?',
                name: 'task_information',
                meta: {title: '任务详情'},
                component: require('../views/task/taskInformation.vue')
            }
          ]
        },
        {
          path: 'user_lists',
          meta: {title: '用户管理'},
          component: parentComponent,
          children: [
            {
                path: '',
                name: 'user_lists',
                meta: {title: '用户列表'},
                component: require('../views/user/userLists.vue')
            },
            {
                path: 'add_user',
                name: 'add_user',
                meta: {title: '创建用户'},
                component: require('../views/user/addUser.vue')
            },
            {
                path: 'role_manager',
                name: 'role_manager',
                meta: {title: '角色管理'},
                component: require('../views/user/roles.vue')
            },
            {
                path: 'browser_roles/:id',
                name: 'browser_roles',
                meta: {title: '查看角色'},
                component: require('../views/user/roleItem.vue')
            },
            {
                path: 'edit_roles/:id',
                name: 'edit_roles',
                meta: {title: '修改角色'},
                component: require('../views/user/roleItem.vue')
            },
            {
                path: 'edit_user/:id',
                name: 'edit_user',
                meta: {title: '用户更新'},
                component: require('../views/user/addUser.vue')
            },
            {
                path: 'user_update',
                name: 'user_update',
                meta: {title: '用户信息修改'},
                component: require('../views/user/userUpdate.vue')
            }
          ]
        },
        {
            path: 'notify',
            meta: {title: '工作通知'},
            component: parentComponent,
            children: [
                {
                    path: '',
                    name: 'notify',
                    meta: {title: '工作通知'},
                    component: require('../views/workNotify.vue')
                }
            ]
        },
        {
            path: 'colleges',
            meta: {title: '预置数据'},
            component: parentComponent,
            children: [
                {
                    path: '',
                    name: 'colleges',
                    meta: {title: '学院名称设置'},
                    component: require('../views/precut/Colleges.vue')
                },
                {
                    path: 'work_type',
                    name: 'work_type',
                    meta: {title: '工作类型设置'},
                    component: require('../views/precut/WorkType.vue')
                },
                {
                    path: 'department',
                    name: 'department',
                    meta: {title: '对口科室设置'},
                    component: require('../views/precut/Department.vue')
                },
                {
                    path: 'access',
                    name: 'access',
                    meta: {title: '考核等级设置'},
                    component: require('../views/precut/gradeExam.vue')
                },
                {
                    path: 'absence',
                    name: 'absence',
                    meta: {title: '缺勤原因设置'},
                    component: require('../views/precut/absence.vue')
                },
                {
                    path: 'semester',
                    name: 'semester',
                    meta: {title: '学期学年设置'},
                    component: require('../views/precut/semester.vue')
                }
            ]
        },
        {
          path: 'cahier_lists/:id',
          meta: {title: '会议管理'},
          component: parentComponent,
          children: [
            {
              path: '',
              name: 'cahier_lists',
              meta: {title: '会议记录'},
              component: require('../views/cahier/cahierCreate.vue')
            },
            {
              path: 'cahier_detail/:id/:user?',
              name: 'cahier_detail',
              meta: {title: '会议详情'},
              component: require('../views/cahier/cahierDetail.vue')
            },
            {
              path: 'cahier_create',
              name: 'cahier_create',
              meta: {title: '添加会议'},
              component: require('../views/cahier/addMetting.vue')
            },
            {
                path: 'task_attendance/:id',
                name: 'task_attendance',
                meta: {
                    title: '会议考核'
                },
                component: require('../views/cahier/taskAttendance.vue')
            },
            {
                path: 'cahier_list/:id',
                name: 'cahier_list',
                meta: {
                    title: '会议考核'
                },
                component: require('../views/cahier/cahierList.vue')
            }
          ]
        },
        {
          path: 'task_summary',
          meta: {title: '任务汇总'},
          component: parentComponent,
          children: [
            {
                //各学院老师
                path: '',
                name: 'task_summary',
                meta: {title: '任务汇总'},
                component: require('../views/summary/table.vue')
            },
            {
                //各学院老师
                path: 'echart',
                name: 'echart',
                meta: {title: '图表显示'},
                component: require('../views/summary/echarts.vue')
            },
            {
                //各学院老师
                path: 'char_table/:id',
                name: 'char_table',
                meta: {title: '表格显示'},
                component: require('../views/summary/charTable.vue')
            }
          ]
        }
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: require('../views/login.vue')
    }
  ]
})

