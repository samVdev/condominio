<script setup lang="ts">
// @ts-ignore
import useIndex from "../composables/useIndex";
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";
import { onMounted } from "vue";
import type { Params } from "@/types/params";
import ActionsTable from "@/components/actionsTable.vue";
import { parsePrices } from "@/utils/parsePrices";
import NotRecords from "@/components/notRecords.vue";

const props = defineProps<{
  activeCreate?: boolean,
  toUserExpenses?: boolean
}>()

const {
  factures,
  route,
  loaded,
  getFactures,
  deleteFacture,
  setSort,
  loadScroll
} = useIndex()


onMounted(() => getFactures(`?offset=${factures.offset}&${new URLSearchParams(route.query as Params).toString()}`))

</script>

<template>
  <main>

    <tablesHeader  title="Facturas" icon="receipt" :searchActive="false" 
      :btnCreate="activeCreate" @create="$emit('form')" />

    <section className="relative mx-auto my-4 overflow-auto animate-fade-in">

      <div class="fakeTable overflow-hidden" :class="route.fullPath.includes('dashboard') ? 'h-[50vh] md:h-[70vh] 2xl:h-[90vh]' : 'table-animation h-[70vh]'" @scroll="loadScroll">
          <article class="fakeTable-head" :class="toUserExpenses ? 'grid-cols-5' : 'grid-cols-6'">
            <a to="#" class="cursor-pointer" @click.prevent="setSort('created')">
                Fecha
                <font-awesome-icon icon="sort" class="ml-2" />
              </a>
              <a to="#" class="cursor-pointer" @click.prevent="setSort('tower')">
                Torre
                <font-awesome-icon icon="sort" class="ml-2" />
              </a>
              <a to="#" class="cursor-pointer" @click.prevent="setSort('mount')">
                Monto ($)
                <font-awesome-icon icon="sort" class="ml-2" />
              </a>
              <a to="#" class="cursor-pointer" @click.prevent="setSort('mount')">
                Monto (Bs.)
                <font-awesome-icon icon="sort" class="ml-2" />
              </a>
              <a to="#" class="cursor-pointer" @click.prevent="setSort('dollarBefore')">
                Dolar BCV
                <font-awesome-icon icon="sort" class="ml-2" />
              </a>
              <p v-if="!toUserExpenses">Acción</p>
          </article>

          <section v-if="factures.rows.length > 0">
          <div v-for="row in factures.rows" :key="row.id" class="fakeTable-body" :class="toUserExpenses ? 'grid-cols-5' : 'grid-cols-6'">
            <p>{{ row.created }}</p>
            <p>{{ row.tower }}</p>
            <p>{{ parsePrices(row.mount_dollars).dol }}</p>
            <p>{{ parsePrices(row.mount_bs).bs }}</p>
            <p>{{ row.dollar_bcv }} bs.</p>
            <p v-if="!toUserExpenses">
              <ActionsTable :editBtn="false" :recibesBtn="true" :expensesBtn="true" :deleteBtn="activeCreate"
               @recives="() => $router.push({path: '/receipts', query: {facture: row.id, back: '/factures'}})"
               @expenses="() => $router.push({path: '/expenses', query: {facture: row.id}})"
                @remove="deleteFacture(row.id)"/>
            </p>
          </div>
        </section>

        <div class="FadeTR" v-else>
          <Loader v-if="!loaded" class="mx-auto mt-5" />
          <NotRecords v-else/>
        </div>

      </div>

    </section>
  </main>
</template>


<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 2s ease, transform 2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(0px);
}
</style>
