import auth from "@/middleware/auth"
import guest from "@/middleware/guest"
import admin from "@/middleware/admin"

export default [
    {
        path: "/home",
        name: "home",
        meta: { middleware: [auth], layout: "default" },
        component: () => import("@/modules/guest/views/home.vue").then(m => m.default),
        children: [
            {
                path: "expenses/facture",
                name: "expensesGuest",
                meta: { middleware: [auth] },
                props: true,
                component: () => import("@/modules/guest/views/viewExpenses.vue").then(m => m.default),
            },
        ]
    }

]
