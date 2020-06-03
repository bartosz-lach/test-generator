require('./bootstrap');
import Vue from 'vue'
import App from './App.vue'
import VueRouter from "vue-router";
import { routes } from "./routes";
// import 'bootstrap/dist/css/bootstrap.css';
import User from './User';
import vuetify from './vuetify';
// import 'bootstrap-vue/dist/bootstrap-vue.css';
// import { FormInputPlugin } from 'bootstrap-vue'
// Vue.use(FormInputPlugin);
// axios.defaults.headers.common['Authorization'] =
//     'Bearer ' + localStorage.getItem('token');
window.Vue = require('vue');
Vue.config.productionTip = false;
Vue.use(VueRouter);
window.User = User;
window.console.log('TOKEN: ', User.hasToken());
const router = new VueRouter({
    mode: 'history',
    routes
});
export const eventBus = new Vue();

new Vue({
    vuetify,
    router,
    render: h => h(App),
}).$mount('#app');
