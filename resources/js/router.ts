import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: "/welcome",
        name: "welcome",
        component: () => import('@pages/WelcomePage.vue'),
    },
    {
        path: "/welcome/login",
        name: "welcome.login",
        component: () => import('@pages/WelcomeLoginPage.vue'),
    },
    {
        path: '/welcome/test',
        name: 'welcome.test',
        component: () => import('@pages/Test.vue'),
    },
    {
        path: '/welcome/register',
        name: 'welcome.register',
        component: () => import('@pages/WelcomeRegisterPage.vue'),
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
    console.log('%chere in before each', 'padding: 5px; background: hotpink; color: black;');

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