import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const state = {
    menus: null,
    me: null
};
export default new Vuex.Store({
    state,
    mutations: {
        UPDATE_MENUS (state, menus) {
            state.menus = menus;
        },
        UPDATE_ME (state, me) {
            state.me = me;
        }
    }
});