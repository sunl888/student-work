// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'


Vue.prototype.$http = axios.create({
    baseURL: '/api/',
    timeout: 5000,
    responseType: 'json',
    headers:{
        'X-Requested-With': 'XMLHttpRequest'
    }
});
Vue.prototype.$http.interceptors.response.use((response) => {
    return response;
}, (error) => {
    if(error.code === 'ECONNABORTED'){
        Vue.prototype.$message({
            showClose: true,
            message: "请求超时",
            type: 'error'
        })
    }else if(error.response.status !== 422){
        Vue.prototype.$message({
            showClose: true,
            message: error.response.data.message,
            type: 'error'
        })
        if(error.response.status === 401){
            router.push({name: 'login'});
        }
    }else{
        let errorsTemp = error.response.data.errors;
        for(let index in errorsTemp){
            errorsTemp[index] = errorsTemp[index].join(',')
        }
    }
    return Promise.reject(error);
});

Vue.config.productionTip = false
Vue.use(ElementUI)

Vue.prototype.$diff = require('./utils/diff');

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
