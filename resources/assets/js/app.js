import './bootstrap'
import Vue from 'vue'
import router from './router'
import store from './store'
import App from './App.vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import './plugins/dashboard'
import './plugins/chartist'
Vue.use(Vuetify)

const createApp = async () =>{
    await store.dispatch('auth/currentUser')

    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        router,
        store,
        components: {App},
        template: '<App />'
    })
}

createApp();