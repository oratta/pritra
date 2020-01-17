import './bootstrap'
import Vue from 'vue'
import router from './router'
import App from './App.vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    router,
    components: {App},
    template: '<App />'
})