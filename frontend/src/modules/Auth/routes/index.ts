import auth from "@/middleware/auth"
import guest from "@/middleware/guest"
import admin from "@/middleware/admin"

export default [
    {
        path: "/",
        name: "index",
        meta: { middleware: [guest], },
        component: () => import("@/modules/Auth/views/index.vue").then(m => m.default)
    },
    {
        path: "/login",
        name: "Login",
        meta: { middleware: [guest], },
        component: () => import("@/modules/Auth/views/Login.vue").then(m => m.default)
    },
    {
        path: "/profile",
        name: "profile",
        meta: { middleware: [auth], layout: "default" },
        component: () => import("@/modules/Auth/views/Profile.vue").then(m => m.default),
    }, 
    {
        path: "/config",
        name: "config",
        meta: { middleware: [auth, admin], layout: "default" },
        component: () => import("@/modules/Auth/views/config.vue").then(m => m.default),
    },
    {
        path: "/dashboard",
        name: "dashboard",
        meta: { middleware: [auth, admin], layout: "default" },
        component: () => import("@/modules/Auth/views/Dashboard.vue").then(m => m.default),
        children: [
            {
                path: "expenses/view/",
                name: "expensesDash",
                meta: { middleware: [auth, admin] },
                props: true,
                component: () => import("@/modules/Expenses/views/IndexView.vue").then(m => m.default),
            },
            {
                path: "users/pendings",
                name: "usersPendingReceipts",
                meta: { middleware: [auth, admin]},
                props: true,
                component: () => import("@/modules/Receipts/views/usersPending.vue").then(m => m.default)
            },

            {
                path: "factures/pendings",
                name: "facturesPending",
                meta: { middleware: [auth, admin]},
                props: true,
                component: () => import("@/modules/Factures/views/Index.vue").then(m => m.default)
            },
        ]
    },

    {
        path: "/:catchAll(.*)",
        name: "NotFound",
        meta: { middleware: [guest] },
        component: () => import("@/modules/Auth/components/NotFound.vue").then(m => m.default),
    }
]
