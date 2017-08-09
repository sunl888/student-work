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
      path: '/home',
      name: 'home',
      component: require('../views/Home.vue'),
      children: [
        {
          path: '/',
          component: require('../views/taskManage.vue')
        },
        {
          path: 'addTask',
          name: 'addTask',
          component: require('../views/addTask.vue')
        },
        {
          path: 'goingFinish',
          name: 'goingFinish',
          component: require('../views/goingFinish.vue')
        },
        {
          path: 'unfinished',
          name: 'unfinished',
          component: require('../views/unfinishedWork.vue')
        },
        {
          path: 'taskDetail',
          name: 'taskDetail',
          component: require('../views/taskDetail.vue')
        },
        {
          path: 'taskScore',
          name: 'taskScore',
          component: require('../views/taskScore.vue')
        }
      ]
    },
    {
      path: '/login',
      name: 'Login',
      component: require('../views/login.vue')
    }
  ]
})
