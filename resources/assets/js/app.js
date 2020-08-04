import './bootstrap'
import Vue from 'vue'
import router from './router'
import store from './store'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import './plugins/dashboard'
import './plugins/chartist'

const createApp = async () =>{
    await store.dispatch('auth/currentUser')

    new Vue({
        el: '#app',
        vuetify,
        router,
        store,
        components: {App},
        template: '<App />'
    })
}

createApp();