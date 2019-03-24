/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import store from './store'
//import router from './router'
import '@fortawesome/fontawesome-free/css/all.css'; // Ensure you are using css-loader
import Vue from 'vue';
require('./bootstrap');
import Vuetify from 'vuetify';
import Home from './views/Home.vue'
import RegisterStudents from './views/RegisterStudents.vue'
import Login from './views/Login.vue'
import RegisterProfesor from './views/RegisterProfesor.vue'
import RememberComponent from './components/Login/RememberComponent.vue'
import Administrador from './views/Administrador.vue'
import Credencial from './views/Credencial.vue'
import ProfesorMostrarComponent from './components/Profesores/MostrarComponent.vue'
import ProfesorEditarComponent from './components/Profesores/EditarComponent.vue'
import ProfesorBorrarComponent from './components/Profesores/BorrarComponent.vue'
import EstudianteMostrarComponent from './components/Estudiantes/MostrarComponent.vue'
import EstudianteEditarComponent from './components/Estudiantes/EditarComponent.vue'
import EstudianteBorrarComponent from './components/Estudiantes/BorrarComponent.vue'
import HorarioComponent from './components/Horario/HorarioComponent.vue'
import CursoComponent from './components/Curso/CursoComponent.vue'

window.Vue = require('vue');
Vue.use(Vuetify, {
    iconfont: 'fa'
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('App', require('./views/App.vue').default);
Vue.component('Homeview', Home);
Vue.component('registerstudents', RegisterStudents);
Vue.component('registerprofesor', RegisterProfesor);
Vue.component('remembercomponent', RememberComponent);
Vue.component('pmostrarcomponent', ProfesorMostrarComponent);
Vue.component('peditarcomponent', ProfesorEditarComponent);
Vue.component('pborrarcomponent', ProfesorBorrarComponent);
Vue.component('emostrarcomponent', EstudianteMostrarComponent);
Vue.component('eeditarcomponent', EstudianteEditarComponent);
Vue.component('eborrarcomponent', EstudianteBorrarComponent);
Vue.component('horariocomponent', HorarioComponent);
Vue.component('cursocomponent', CursoComponent);
Vue.component('administrador', Administrador);
Vue.component('credencial', Credencial);
Vue.component('login', Login);

const app = new Vue({
    el: '#app',
    data() {
        return {

        }
    },
    //router,
    store,
});