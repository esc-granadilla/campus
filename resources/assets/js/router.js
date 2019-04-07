import Vue from 'vue'
import Router from 'vue-router';

Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    linkExactActiveClass: 'list__title--active,',
    routes: [
        // {
        //     path: '/noticias/mostrar',
        //     name: 'noticias',
        //     component: () => import('./components/Noticias/index.vue')
        // }
    ],
})