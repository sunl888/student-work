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
                  path: 'task_item/:id',
                  name: 'task_item',
                  meta: {title: '任务详情'},
                  component: require('../views/task/taskItem.vue')
              },
              {
                  //各学院
                  path: 'task_detail/:id',
                  name: 'task_detail',
                  meta: {title: '任务详情'},
                  component: require('../views/task/taskDetail.vue')
              },
              {
                  //各学院老师
                  path: 'task_information/:id',
                  name: 'task_information',
                  meta: {title: '任务详情'},
                  component: require('../views/task/taskInformation.vue')
              },
              {
                  //各学院老师
                  path: 'task_collect',
                  name: 'task_collect',
                  meta: {title: '任务考核汇总'},
                  component: require('../views/task/taskCollect.vue')
              },
              {
                  path: 'going_finish/:id',
                  name: 'going_finish',
                  meta: {title: '任务完成'},
                  component: require('../views/task/goingFinish.vue')
              },
              {
                  //各学院首页
                  path: 'tasks_of_college',
                  name: 'tasks_of_college',
                  meta: {title: '任务显示'},
                  component: require('../views/task/unfinishedWork.vue')
              },
              {
                  //各学院老师首页
                  path: 'tasks_of_teacher',
                  name: 'tasks_of_teacher',
                  meta: {title: '任务显示'},
                  component: require('../views/task/tasksOfTeacher.vue')
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
          path: 'cahier_create',
          meta: {title: '会议管理'},
          component: parentComponent,
          children: [
          {
            path: 'cahier_create',
            name: 'cahier_create',
            meta: {title: '会议记录'},
            component: require('../views/cahier/cahierCreate.vue')
          }]
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
                      meta: {title: '修改用户信息'},
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

