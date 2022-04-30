import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../views/master/index.vue';
import store from '../store';

Vue.use(VueRouter);

const routes = [
    // Page not Found
    {
        path: '*',
        name: 'error404',
        component: () => import(/* webpackChunkName: "pages-error404" */ '../views/master/error/404.vue'),
        meta: { layout: 'auth' }
    },
    //Dashboard
    { 
        path: '/',
        name: 'Home',
        component: Home,
        meta: {requiresAuth: true}
    
    },

    // Admin - Instructor Routes
    {
        path: '/admin/instructor',
        name: 'adminInstructor',
        component: () => import(/* webpackChunkName: "components-tabs" */ '../views/master/admin/instructor/index.vue'),
        meta: {requiresAuth: true}
    },
    // Admin - Section Routes
    {
        path: '/admin/section',
        name: 'adminSection',
        component: () => import(/* webpackChunkName: "components-tabs" */ '../views/master/admin/section/index.vue'),
        meta: {requiresAuth: true}
    },

    // Admin - Subject Routes
    {
        path: '/admin/subject',
        name: 'adminSubject',
        component: () => import(/* webpackChunkName: "components-tabs" */ '../views/master/admin/subject/index.vue'),
        meta: {requiresAuth: true}
    },


     // Public Routes with Authorization
    {
        // Temporary Routes for Admin Creation
        // Disable this route once Admin account created
        path: '/register',
        component: () => import(/* webpackChunkName: "auth-register-boxed" */ '../views/master/auth/register.vue'),
        meta: { layout: 'auth',guest:true }
    },
    {
        path: '/login',
        name: 'login',
        component: () => import(/* webpackChunkName: "auth-login-boxed" */ '../views/master/auth/login.vue'),
        meta: { layout: 'auth',guest:true }
    },

];

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { x: 0, y: 0 };
        }
    }
});

router.beforeEach((to, from, next) => {
    if (to.meta && to.meta.layout && to.meta.layout == 'auth') {
        store.commit('setLayout', 'auth');
    } else {
        store.commit('setLayout', 'app');
    }
    next(true);
});

export default router;