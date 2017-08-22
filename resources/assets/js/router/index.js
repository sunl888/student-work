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
      path: '/home:addr?',
      name: 'home',
      meta: {title: '首页'},
      component: require('../views/Home.vue'),
        redirect: to => {
          const {params} = to
          if(params.addr){
              return '/:params.addr'
          }
        },
      children: [
        {
          path: 'task_manage',
          name: 'task_manage',
          meta: {title: '任务管理'},
          children: [
            {
              path: '',
              name: 'taskManage',
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
          ]
        },
        {
          path: 'task_item/:id',
          name: 'task_item',
          meta: {title: '任务详情'},
          component: require('../views/task/taskItem.vue')
        },
        {
          path: 'going_finish/:id',
          name: 'going_finish',
          meta: {title: '任务完成'},
          component: require('../views/task/goingFinish.vue')
        },
        {
          path: 'tasks_of_college',
          name: 'tasks_of_college',
          meta: {title: '任务显示'},
          component: require('../views/task/unfinishedWork.vue')
        },
        {
          path: 'task_score/:id',
          name: 'task_score',
          meta: {title: '任务评分'},
          component: require('../views/task/taskScore.vue')
        },
        {
          path: 'user_lists',
          name: 'user_lists',
          meta: {title: '用户列表'},
          component: require('../views/user/userLists.vue')
        },
        {
            path: 'add_user',
            name: 'add_user',
            meta: {title: '添加用户'},
            component: require('../views/user/addUser.vue')
        },
        {
          path: 'colleges',
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
    },
    {
      path: '/login',
      name: 'login',
      component: require('../views/login.vue')
    }
  ]
})
