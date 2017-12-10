import 'babel-polyfill';
import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const state = {
    me: null,
    menus: null,
    users: null
};
export default new Vuex.Store({
    state,
    mutations: {
        UPDATE_ME (state, me) {
            state.me = me;
        },
        UPDATE_MENUS (state, menus) {
            state.menus = menus;
        },
        allUser(state, users){
            state.users = users;
        }
    }
});