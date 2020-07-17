import Vue from 'vue';
import VueRouter from 'vue-router';
import SetMenu from '../pages/SetMenu.vue';
import Login from '../pages/Login.vue';
import Run from '../pages/Run.vue';
import Finish from '../pages/Finish.vue';
import Dashboard from '../pages/Dashboard.vue';
import ErrorBadRequest from '../pages/error/BadRequest.vue';
import ErrorSystem from '../pages/error/System.vue';

Vue.use(VueRouter)

const routes = [
    {
        path: '/training/plan',
        name: 'set_menu',
        component: SetMenu,
    },
    {
        path: '/',
        redirect: {name: 'set_menu'}
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
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/400',
        name: '400',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: ErrorBadRequest,
    },
    {
        path: '/500',
        name: '500',
        component: ErrorSystem,
    }
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router