import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [{
    path: "/apartamentos",
    name: "apartamentos",
    meta: { middleware: [auth, admin], layout: "default" },
    component: () => import("@/modules/Apartaments/views/Index.vue").then(m => m.default),
    children: [{
        path: "form/:id?",
        name: "apartamentosForm",
        meta: { middleware: [auth, admin], layout: "default" },
        component: () => import("@/modules/Apartaments/views/formService.vue").then(m => m.default),
    }]
},
]
