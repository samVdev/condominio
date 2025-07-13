// @ts-nocheck

import {createRouter, createWebHistory} from 'vue-router'
import type {RouteRecordRaw} from 'vue-router'
import { computed } from "vue"
import { useAuthStore } from '@/modules/Auth/stores'
import middlewarePipeline from "@/router/middlewarePipeline"

// routes
import AuthRoutes from "@/modules/Auth/routes"
import AuthorizationRoutes from "@/modules/Authorization/routes"
import UserRoutes from "@/modules/User/routes"
import ServicesRoutes from "@/modules/Services/routes"
import ExpensesRoutes from "@/modules/Expenses/routes"
import EarningsRoutes from "@/modules/Earnings/routes"
import ReceiptsRoutes from "@/modules/Receipts/routes"
import ProvisionsRoutes from "@/modules/Provisions/routes"
import facturesRoutes from "@/modules/Factures/routes"
import guestRoutes from "@/modules/guest/routes"
import TypeEarningRoutes from "@/modules/TypeEarning/routes"
import ApartamentsRoutes from "@/modules/Apartaments/routes"
import NewsRoutes from "@/modules/News/routes"
import BoardsRoutes from "@/modules/boards/routes"

const storeAuth = computed(() => useAuthStore())

const routes: Array<RouteRecordRaw> = [
  ...AuthRoutes.map(route => route),
  ...AuthorizationRoutes.map(route => route),
  ...UserRoutes.map(route => route),
  ...ServicesRoutes.map(route => route),
  ...ExpensesRoutes.map(route => route),
  ...EarningsRoutes.map(route => route),
  ...ReceiptsRoutes.map(route => route),
  ...facturesRoutes.map(route => route),
  ...guestRoutes.map(route => route),
  ...TypeEarningRoutes.map(route => route),
  ...ProvisionsRoutes.map(route => route),
  ...NewsRoutes.map(route => route),
  ...ApartamentsRoutes.map(route => route),
  ...BoardsRoutes.map(route => route) 
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),  
  routes,
});

router.beforeEach((to, from, next) => {
  const middleware = to.meta.middleware;
  const context = { to, from, next, storeAuth };

  if (!middleware) {
    return next();
  }

  middleware[0]({
    ...context,
    next: middlewarePipeline(context, middleware, 1),
  });
});

export default router