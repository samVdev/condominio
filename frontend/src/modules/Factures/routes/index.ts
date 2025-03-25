import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [{
    path: "/factures",
    name: "factures",
    meta: { middleware: [auth, admin], layout: "default" },
    props: true,
    component: () => import("@/modules/Factures/views/Index.vue").then(m => m.default),
    children: [{
        path: "form",
        name: "facturesForm",
        meta: { middleware: [auth, admin] },
        component: () => import("@/modules/Factures/views/formExpense.vue").then(m => m.default),
    }]
},
]
