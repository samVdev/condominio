import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [{
    path: "/users",
    name: "users",
    meta: { middleware: [auth, admin], layout: "default" },
    component: () => import("@/modules/User/views/Index.vue").then(m => m.default)
}, {
    path: "/users/create",
    name: "userCreate",
    meta: { middleware: [auth, admin], layout: "default" },
    component: () => import("@/modules/User/views/CreateOrEdit.vue").then(m => m.default),
    props: true
}, {
    path: "/users/edit/:uuid",
    name: "userEdit",
    meta: { middleware: [auth, admin], layout: "default" },
    component: () => import("@/modules/User/views/CreateOrEdit.vue").then(m => m.default),
    props: true
}]
