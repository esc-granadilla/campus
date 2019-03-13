import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@fortawesome/fontawesome-free/css/all.css'


Vue.use(Vuetify, {
    iconfont: 'fa'
})

Vue.config.productionTip = false

//router.replace('/login')

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')