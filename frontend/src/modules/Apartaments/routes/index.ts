import auth from "@/middleware/auth"
import admin from "@/middleware/admin"

export default [
    {
        path: "/condominium",
        name: "condominium",
        meta: { middleware: [auth, admin], layout: "default" },
        component: () => import("@/modules/Apartaments/views/index.vue").then(m => m.default),
        children: [{
            path: "apt",
            name: "apt",
            meta: { middleware: [auth, admin], layout: "default" },
            component: () => import("@/modules/Apartaments/views/apt/aptIndex.vue").then(m => m.default),
            children: [{
                path: "form/:id?",
                name: "aptForm",
                meta: { middleware: [auth, admin], layout: "default" },
                component: () => import("@/modules/Apartaments/views/apt/formAptService.vue").then(m => m.default),
            }]
        },
        {
            path: "elevators",
            name: "elevators",
            meta: { middleware: [auth, admin], layout: "default" },
            component: () => import("@/modules/Apartaments/views/elevators/elevatorsIndex.vue").then(m => m.default),
            children: [{
                path: "form/:id?",
                name: "elevatorForm",
                meta: { middleware: [auth, admin], layout: "default" },
                component: () => import("@/modules/Apartaments/views/elevators/formElevatorService.vue").then(m => m.default),
            },
            {
                path: "history",
                name: "elevatorHistory",
                meta: { middleware: [auth, admin], layout: "default" },
                component: () => import("@/modules/Apartaments/views/elevators/history/index.vue").then(m => m.default),
            },

            {
                path: "report-form/:id",
                name: "reportForm",
                meta: { middleware: [auth, admin], layout: "default" },
                component: () => import("@/modules/Apartaments/views/elevators/formReport.vue").then(m => m.default),
            }
            ]
        }
        ]
    }
]
