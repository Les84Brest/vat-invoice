import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: "/vat",
        name: "vat.dashboard",
        component: () => import('@pages/VatDashboard.vue')
    },
    {
        path: "/user",
        name: "user.dashboard",
        component: () => import('@pages/UserDashboard.vue')
    },
    {
        path: "/welcome",
        name: "welcome",
        component: () => import('@pages/WelcomePage.vue'),
    },
    {
        path: "/register",
        name: "register",
        component: () => import('@pages/RegisterPage.vue'),
    },
    {
        path: "/login",
        name: "login",
        component: () => import('@pages/LoginPage.vue'),
    },
    {
        path: '/welcome/test',
        name: 'welcome.test',
        component: () => import('@pages/Test.vue'),
    },

    {
        path: '/welcome/personal',
        name: 'welcome.personal',
        component: () => import('@pages/WelcomePersonalPage.vue'),
    },

];

const router = createRouter(
    {
        history: createWebHistory(),
        routes

    }
);

router.beforeEach((to, from, next) => {
    const authStatus = localStorage.getItem('auth');

    if (!authStatus) {
        if (to.name === 'welcome.personal') {
            return next({name: 'welcome'});
        } else {
            return next();
        }
    }

    //     // if (!authStatus) {
    //     //     if (to.name === 'welcome.login' || to.name === 'welcome.register') {
    //     //         return next();
    //     //     }
    //     // } else {
    //     //     return next({ name: 'welcome.login' });
    //     // }

    //     // if (to.name === 'welcome.login' || to.name === 'welcome.register' && authStatus) {
    //     //     next({ name: 'welcome' });
    //     // }

    return next();
})

export default router;