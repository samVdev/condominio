import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [{
    path: "/expenses",
    name: "expenses",
    meta: { middleware: [auth, admin], layout: "default" },
    props: true,
    component: () => import("@/modules/Expenses/views/Index.vue").then(m => m.default),
    children: [{
        path: "form/:id?",
        name: "expensesForm",
        meta: { middleware: [auth, admin]},
        component: () => import("@/modules/Expenses/views/formExpense.vue").then(m => m.default),
    }]
},
]
