import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '*',
      redirect: {name: 'home'}
    },
    {
      path: '/home',
      name: 'home',
      component: require('../views/Home.vue'),
      redirect: {name: 'taskManage'},
      children: [
        {
          path: 'taskManage',
          name: 'taskManage',
          component: require('../views/task/taskManage.vue')
        },
        {
          path: 'add_task',
          name: 'add_task',
          component: require('../views/task/addTask.vue')
        },
        {
          path: 'edit_task/:id',
          name: 'edit_task',
          component: require('../views/task/addTask.vue')
        },
        {
          path: 'going_finish',
          name: 'going_finish',
          component: require('../views/task/goingFinish.vue')
        },
        {
          path: 'unfinished',
          name: 'unfinished',
          component: require('../views/task/unfinishedWork.vue')
        },
        {
          path: 'task_detail',
          name: 'task_detail',
          component: require('../views/task/taskDetail.vue')
        },
        {
          path: 'task_score',
          name: 'task_score',
          component: require('../views/task/taskScore.vue')
        },
        {
          path: 'colleges',
          name: 'colleges',
          component: require('../views/precut/Colleges.vue')
        },
        {
          path: 'work_type',
          name: 'work_type',
          component: require('../views/precut/WorkType.vue')
        },
        {
            path: 'department',
            name: 'department',
            component: require('../views/precut/Department.vue')
        },
        {
            path: 'access',
            name: 'access',
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
