/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

/*jshint esversion: 6 */

import store from './store';
//import router from './router'
import './components';
import '@fortawesome/fontawesome-free/css/all.css'; // Ensure you are using css-loader
import Vue from 'vue';
require('./bootstrap');
import Vuetify from 'vuetify';
//import es from 'vuetify/src/locale/es';
import Vuebar from 'vuebar';
import VuetifyToast from 'vuetify-toast-snackbar';
const $ = require('jquery');
// Lo declaramos globalmente
window.$ = $;
Vue.use(Vuebar);
window.Vue = require('vue');
Vue.use(Vuetify, {
    iconfont: 'fa',
});
Vue.use(VuetifyToast, {
    x: 'right', // default
    y: 'bottom', // default bottom
    color: 'info', // default
    icon: 'info',
    timeout: 3000, // default
    dismissable: true, // default
    autoHeight: false, // default
    multiLine: false, // default
    vertical: false, // default
    shorts: {
        custom: {
            color: 'purple'
        }
    },
    property: '$toast' // default
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    data() {
        return {

        }
    },
    //router,
    store,
});