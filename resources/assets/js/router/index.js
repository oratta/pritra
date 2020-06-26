import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../pages/Home.vue';
import About from '../pages/About.vue';
import Enterprise from '../pages/Enterprise.vue';
import SetMenu from '../pages/SetMenu.vue';
import Sample from '../pages/Sample.vue';
import Login from '../pages/Login.vue';
import Run from '../pages/Run.vue';
import Finish from '../pages/Finish.vue';


Vue.use(VueRouter)

const routes = [
    {
        path: '/training/plan',
        name: 'set_menu',
        component: SetMenu,
    },
    {
        path: '/training/run',
        name: 'run',
        component: Run,
    },
    {
        path: '/training/finish',
        name: 'finish',
        component: Finish,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/sample',
        name: 'sample',
        component: Sample,
    },
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/about',
        name: 'about',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: About,
    },
    {
        path: '/enterprise',
        name: 'enterprise',
        component: Enterprise,
    }
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router