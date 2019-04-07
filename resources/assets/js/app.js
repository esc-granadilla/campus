
import Vue from 'vue';
import Vuetify from 'vuetify';
import store from './store';

Vue.use(Vuetify);

window.Vue = require('vue');
require('./components');
require('./bootstrap');

const app = new Vue({
    el: '#app',
    store,    
});