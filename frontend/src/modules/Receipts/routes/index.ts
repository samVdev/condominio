import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [{
    path: "/receipts",
    name: "usersReceipts",
    meta: { middleware: [auth, admin]},
    props: true,
    component: () => import("@/modules/Receipts/views/usersPending.vue").then(m => m.default),
    children: [
        {
            path: "expenses-user",
            name: "expensesUser",
            meta: { middleware: [auth, admin]},
            props: true,
            component: () => import("@/modules/Expenses/views/expensesUser.vue").then(m => m.default),
        }
    ]
},

{
    path: "/payments",
    name: "payments",
    meta: { middleware: [auth, admin], layout: "default" },
    props: true,
    component: () => import("@/modules/Receipts/views/index.vue").then(m => m.default),
}

]
