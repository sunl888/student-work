import Vue from 'vue'
import VueResource from 'vue-resource'
Vue.use(VueResource)
Vue.http.options.root = 'api'
export default{
    getToken () {
        return window.localStorage.token
    },
    login (user, psw, cb) {
        Vue.http.post('login',{
            name: user,
            password: psw
        }).then(res => {
            window.localStorage.token = res.token
            if (cb) {
                cb (res.status)
            }
        },res => {
            if (cb) {
                cb (res.status, res.data !== null ? res.data.message : '未知错误')
            }
        })
    }
}
