/*jshint esversion: 6 */
import Vue from 'vue';
import Router from 'vue-router';
import Profesorcomponent from './components/Profesores/ProfesorComponent.vue';
import Profesornotacomponent from './components/Profesores/Notas/NotaComponent.vue';
import Profesornotasagregarcomponent from './components/Profesores/Notas/NotasAgregarComponent.vue';
import Profesorpromediocomponent from './components/Profesores/Promedios/PromedioComponent.vue';
import Profesortareacomponent from './components/Profesores/Tareas/TareaComponent.vue';
import Estudiantecomponent from './components/Administradores/Estudiantes/EstudianteComponent.vue';
import Estudiantecursoscomponent from './components/Estudiantes/CursosComponent.vue';
import Horariocomponent from './components/Administradores/Horario/HorarioComponent.vue';
import Seccioncomponent from './components/Administradores/Seccion/SeccionComponent.vue';
import Asignaturacomponent from './components/Administradores/Asignatura/AsignaturaComponent.vue';
import Credencialcomponent from './components/Administradores/Asignaciones/Credencial.vue';
import Cursocomponent from './components/Administradores/Curso/CursoComponent.vue';
import Admincomponent from './components/Administradores/AdministracionDefault.vue';
import AsigSeccionAlumnoscomponent from './components/Administradores/Asignaciones/SeccionAlumnos.vue';
import AsigCursoLeccionescomponent from './components/Administradores/Asignaciones/CursoLecciones.vue';
import Administradornoticiascomponent from './components/Administradores/Noticias/NewsComponent.vue';
import Profesornoticiascomponent from './components/Profesores/Noticias/NewsComponent.vue';
import Estudiantenoticiascomponent from './components/Estudiantes/Noticias/NewsComponent.vue';

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
        {
            path: '/seccion_alumnos',
            name: 'asigseccionalumnoscomponent',
            component: AsigSeccionAlumnoscomponent
        },
        {
            path: '/curso',
            name: 'cursocomponent',
            component: Cursocomponent
        },
        {
            path: '/curso_leccion',
            name: 'asigcursoleccionescomponent',
            component: AsigCursoLeccionescomponent
        },
        {
            path: '/pnoticias',
            name: 'pnoticias',
            component: Profesornoticiascomponent
        },
        {
            path: '/enoticias',
            name: 'enoticias',
            component: Estudiantenoticiascomponent
        },
        {
            path: '/anoticias',
            name: 'anoticias',
            component: Administradornoticiascomponent
        },
        {
            path: '/pnotas',
            name: 'pnotas',
            component: Profesornotacomponent
        },
        {
            path: '/pnotasagregar',
            name: 'pnotasagregar',
            component: Profesornotasagregarcomponent
        },
        {
            path: '/screenteacher',
            name: 'screenteacher',
            component: Profesornoticiascomponent
        },
        {
            path: '/home',
            name: 'homestudents',
            component: Estudiantecursoscomponent
        },
        {
            path: '/ppromedios',
            name: 'ppromedios',
            component: Profesorpromediocomponent
        },
        {
            path: '/ptareas',
            name: 'ptareas',
            component: Profesortareacomponent
        },
    ],
});