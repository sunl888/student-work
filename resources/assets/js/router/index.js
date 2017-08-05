import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '*',
      redirect: {name: 'Login'}
    },
    {
      path: '/login',
      name: 'Login',
      component: require('../views/login.vue')
    },
    {
      path: '/taskManage',
      name: 'TaskManage',
      component: require('../views/taskManage.vue')
    },
    {
      path: '/addTask',
      name: 'AddTask',
      component: require('../views/addTask.vue')
    },
    {
      path: '/unfinished',
      name: 'Unfinished',
      component: require('../views/unfinishedWork.vue')
    },
    {
      path: '/goingFinish',
      name: 'GoingFinish',
      component: require('../views/goingFinish.vue')
    },
    {
      path: '/taskDetail',
      name: 'TaskDetail',
      component: require('../views/taskDetail.vue')
    }
  ]
})
