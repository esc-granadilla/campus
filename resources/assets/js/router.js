/*jshint esversion: 6 */
import Vue from 'vue';
import Router from 'vue-router';
import Profesorcomponent from './components/Profesores/ProfesorComponent.vue';
import Estudiantecomponent from './components/Estudiantes/EstudianteComponent.vue';
import Horariocomponent from './components/Horario/HorarioComponent.vue';
import Seccioncomponent from './components/Seccion/SeccionComponent.vue';
import Asignaturacomponent from './components/Asignatura/AsignaturaComponent.vue';
import Credencialcomponent from './components/Asignaciones/Credencial.vue';
import Admincomponent from './components/Administrador/AdministracionDefault.vue';

Vue.use(Router);

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    linkExactActiveClass: 'list__title--active,',
    routes: [{
            path: '/admin',
            name: 'admin',
            component: Admincomponent
        },
        {
            path: '/credencial',
            name: 'credencial',
            component: Credencialcomponent
        },
        {
            path: '/profesor',
            name: 'profesorcomponent',
            component: Profesorcomponent
        },
        {
            path: '/estudiante',
            name: 'estudiantecomponent',
            component: Estudiantecomponent
        },
        {
            path: '/asignatura',
            name: 'asignaturacomponent',
            component: Asignaturacomponent
        },
        {
            path: '/horario',
            name: 'horariocomponent',
            component: Horariocomponent
        },
        {
            path: '/seccion',
            name: 'seccioncomponent',
            component: Seccioncomponent
        },
    ],
});