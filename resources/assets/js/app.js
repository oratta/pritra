import Vue from 'vue'
import VueRouter from 'vue-router'

require('./bootstrap')

Vue.use(VueRouter)

Vue.component('navbar', require('./components/Layouts/Navbar.vue'))

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: require('./components/Articles/Index.vue') },
        { path: '/about', component: require('./components/About.vue') },
    ]
})

const app = new Vue({
    router,
    el: '#app'
})