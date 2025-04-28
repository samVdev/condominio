import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [{
    path: "/provisions",
    name: "provisions",
    meta: { middleware: [auth, admin], layout: "default" },
    props: true,
    component: () => import("@/modules/Provisions/views/Index.vue").then(m => m.default),
    children: [{
        path: "form/:id?",
        name: "provisionsForm",
        meta: { middleware: [auth, admin]},
        component: () => import("@/modules/Provisions/views/formProvision.vue").then(m => m.default),
    }]
},
]
