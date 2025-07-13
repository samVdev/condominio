import auth from "@/middleware/auth"

export default [
    {
        path: "/home",
        name: "home",
        meta: { middleware: [auth], layout: "default" },
        component: () => import("@/modules/guest/views/home.vue").then(m => m.default),
        children: [
            {
                path: "movements",
                name: "movementsGuest",
                meta: { middleware: [auth] },
                component: () => import("@/modules/guest/views/movements.vue").then(m => m.default),
                children: [
                    {
                        path: "expenses",
                        name: "expensesGuest",
                        meta: { middleware: [auth] },
                        props: true,
                        component: () => import("@/modules/guest/components/expenses.vue").then(m => m.default),
                    },

                    {
                        path: "earnings",
                        name: "earningsGuest",
                        meta: { middleware: [auth] },
                        props: true,
                        component: () => import("@/modules/guest/components/earnings.vue").then(m => m.default),
                    },

                    {
                        path: "provisions",
                        name: "provisionsGuest",
                        meta: { middleware: [auth] },
                        props: true,
                        component: () => import("@/modules/guest/components/provisions.vue").then(m => m.default),
                    },
                ]
            },
        ],
    },

    {
        path: "/guest/elevators",
        name: "elevators-guest",
        meta: { middleware: [auth], layout: "default" },
        component: () => import("@/modules/guest/views/elevators.vue").then(m => m.default),
        children: [
            {
                path: "history",
                name: "elevatorHistoryGuest",
                meta: { middleware: [auth], layout: "default" },
                component: () => import("@/modules/Apartaments/views/elevators/history/index.vue").then(m => m.default),
            }
        ]
    },

    {
        path: "/guest/boards",
        name: "boards-guest",
        meta: { middleware: [auth], layout: "default" },
        component: () => import("@/modules/guest/views/boards.vue").then(m => m.default),
    },

    {
        path: "/guest/board/live/:uuid",
        name: "liveBoardGuest",
        meta: { middleware: [auth], layout: "default" },
        component: () => import("@/modules/guest/views/liveBoardGuest.vue").then(m => m.default),
    }

]
