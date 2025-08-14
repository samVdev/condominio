import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [{
    path: "/boards",
    name: "boards",
    meta: { middleware: [auth, admin], layout: "default" },
    component: () => import("@/modules/boards/views/Index.vue").then(m => m.default),
    children: [
        {
            path: "form/:id?",
            name: "formBoards",
            meta: { middleware: [auth, admin], layout: "default" },
            component: () => import("@/modules/boards/views/formBoards.vue").then(m => m.default)
        }
    ]
},

{
    path: "/board/live/:uuid",
    name: "board-live",
    meta: { middleware: [auth, admin], layout: "default" },
    component: () => import("@/modules/boards/views/viewBoardLive.vue").then(m => m.default),
}
]
