import Vue from 'vue'
import Router from 'vue-router'
import Login from './views/login.vue'
import Home from './views/Home.vue'
import RegisterEstudents from './views/RegisterEstudents.vue'

Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        { path: '/', name: 'home', component: Home },
        { path: '/login', name: 'login', component: Login },
        { path: '/registerestudents', name: 'registerestudents', component: RegisterEstudents },
    ],
})