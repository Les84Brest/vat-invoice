import { createRouter, createWebHistory } from "vue-router";
import { getAuthStatus } from "./utils/auth";

const routes = [
    {
        path: "/vat",
        name: "vat.dashboard",
        component: () => import("@pages/VatDashboard.vue"),
        meta: { requiresAuth: true, title: "Дашборд" },
    },
    {
        path: "/vat/create",
        name: "vat.newInvoice",
        component: () => import("@pages/CreateInvoice.vue"),
        meta: { requiresAuth: true, title: "Новый счет" },
    },
    {
        path: "/vat/current",
        name: "vat.currentIncoices",
        component: () => import("@pages/CurrentInvoices.vue"),
        meta: { requiresAuth: true, title: "Текущие счета (черновики)" },
    },
    {
        path: "/vat/invoice/:id",
        name: "vat.invoicePreview",
        component: () => import("@pages/InvoicePreview.vue"),
        meta: { requiresAuth: true, title: "Просмотр ЭСЧФ" },
    },
    {
        path: "/vat/invoice-income/:id",
        name: "vat.invoiceIncomePreview",
        component: () => import("@pages/InvoicePreviewIn.vue"),
        meta: { requiresAuth: true, title: "Просмотр входящего ЭСЧФ" },
    },


    {
        path: "/vat/invoice/:id/edit",
        name: "vat.invoiceEdit",
        component: () => import("@pages/InvoiceEdit.vue"),
        meta: { requiresAuth: true, title: "Редактирование ЭСЧФ" },
    },
    {
        path: "/vat/income/unsigned",
        name: "vat.incomeUnsigned",
        component: () => import("@pages/IncomeUnsignedInvoices.vue"),
        meta: { requiresAuth: true, title: "Входящие неподписанные" },
    },
    {
        path: "/vat/income/signed",
        name: "vat.incomeSigned",
        component: () => import("@pages/IncomeSignedInvoices.vue"),
        meta: { requiresAuth: true, title: "Входящие подписанные" },
    },
    {
        path: "/vat/send/signed",
        name: "vat.sendUnsigned",
        component: () => import("@pages/SendSignedInvoices.vue"),
        meta: { requiresAuth: true, title: "Отправленные неподписанные" },
    },
    {
        path: "/vat/send/canseled",
        name: "vat.sendCanseled",
        component: () => import("@pages/SendCanseledInvoices.vue"),
        meta: { requiresAuth: true, title: "Отправленные аннулированные" },
    },
    {
        path: "/user",
        name: "user.dashboard",
        component: () => import("@pages/UserDashboard.vue"),
    },
    {
        path: "/welcome",
        name: "welcome",
        component: () => import("@pages/WelcomePage.vue"),
    },
    {
        path: "/register",
        name: "register",
        component: () => import("@pages/RegisterPage.vue"),
        meta: { requiresGuest: true, title: "Регистрация" },
    },
    {
        path: "/login",
        name: "login",
        component: () => import("@pages/LoginPage.vue"),
        meta: { requiresGuest: true, title: "Вход" },
    },
    {
        path: "/welcome/test",
        name: "welcome.test",
        component: () => import("@pages/Test.vue"),
    },

    {
        path: "/welcome/personal",
        name: "welcome.personal",
        component: () => import("@pages/WelcomePersonalPage.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const authStatus = getAuthStatus();

    const pageTitle = to.meta.title as string;
    document.title = pageTitle || "Работа с ЭСЧФ";

    if (to.meta.requiresGuest && authStatus) {
        // If the user is logged in and tries to access a guest-only route, redirect to dashboard
        next({ name: "vat.dashboard" });
    } else if (to.meta.requiresAuth && !authStatus) {
        // If the user is not logged in and tries to access a protected route, redirect to login
        next({ name: "login" });
    } else {
        // Otherwise, allow access
        next();
    }

    return next();
});

export default router;
