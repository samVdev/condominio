import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [{
    path: "/news",
    name: "news",
    meta: { middleware: [auth, admin], layout: "default" },
    component: () => import("@/modules/News/views/Index.vue").then(m => m.default),
    children: [
        {
            path: "form/:id?",
            name: "formNews",
            meta: { middleware: [auth, admin], layout: "default" },
            component: () => import("@/modules/News/views/formNews.vue").then(m => m.default)
        }
    ]

},
]
