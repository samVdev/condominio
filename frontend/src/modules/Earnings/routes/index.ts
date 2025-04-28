import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [{
    path: "/earnings",
    name: "earnings",
    meta: { middleware: [auth, admin], layout: "default" },
    props: true,
    component: () => import("@/modules/Earnings/views/Index.vue").then(m => m.default),
    children: [{
        path: "form/:id?",
        name: "earningsForm",
        meta: { middleware: [auth, admin]},
        component: () => import("@/modules/Earnings/views/formEarning.vue").then(m => m.default),
    }]
},
]
