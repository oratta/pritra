import './bootstrap'
import Vue from 'vue'
import router from './router'
import store from './store'
import App from './App.vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    router,
    store,
    components: {App},
    template: '<App />'
})