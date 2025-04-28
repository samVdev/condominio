import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [{
    path: "/typeEarnings",
    name: "typeEarnings",
    meta: { middleware: [auth, admin], layout: "default" },
    component: () => import("@/modules/TypeEarning/views/Index.vue").then(m => m.default)
},
]
