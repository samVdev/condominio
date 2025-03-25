import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [{
    path: "/services",
    name: "services",
    meta: { middleware: [auth, admin], layout: "default" },
    component: () => import("@/modules/Services/views/Index.vue").then(m => m.default)
},
]
