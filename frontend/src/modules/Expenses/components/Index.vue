<script setup lang="ts">
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";
import useIndex from "../composables/useIndex";
import { onMounted } from "vue";
import type { Params } from "@/types/params";
import ActionsTable from "@/components/actionsTable.vue";
import { parsePrices } from "@/utils/parsePrices";
import NotRecords from "@/components/notRecords.vue";

const url = import.meta.env.VITE_APP_API_URL

const props = defineProps<{
  activeCreate?: boolean,
  toUserExpenses?: boolean
}>()

const {
  expenses,
  route,
  loaded,
  viewImage,
  getExpenses,
  deleteExpense,
  setSearch,
  setSort,
  loadScroll
} = useIndex()


onMounted(() => getExpenses(`?offset=${expenses.offset}&${new URLSearchParams(route.query as Params).toString()}`))

</script>

<template>
  <main>

    <tablesHeader  title="Gastos" icon="money-bill-transfer" :searchActive="true" @setSearch="({ e }) => setSearch(e)"
      :btnCreate="activeCreate" @create="$emit('form')" />

      <div v-if="viewImage" class="overlay w-full grid place-items-center bg-[#000000ab] cursor-pointer" @click="viewImage = ''">
        <img class="w-[100%] md:h-[50%] md:w-auto cursor-default" :src="`${viewImage}`" alt="imagen" @click.stop>
      </div>

    <section className="relative mx-auto my-4 overflow-auto animate-fade-in">

      <div class="fakeTable overflow-hidden" :class="route.fullPath.includes('dashboard') ? 'h-[50vh] md:h-[70vh] 2xl:h-[90vh]' : 'table-animation h-[70vh]'" @scroll="loadScroll">
          <article class="fakeTable-head" :class="toUserExpenses ? 'grid-cols-7' : 'grid-cols-8'">
            <a to="#" class="cursor-pointer" @click.prevent="setSort('created')">
                Fecha
                <font-awesome-icon icon="sort" class="ml-2" />
              </a>
              <a to="#" class="cursor-pointer" @click.prevent="setSort('name')">
                Servicio
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
              <p>Factura</p>
              <p v-if="!toUserExpenses">Acción</p>
          </article>

          <section v-if="expenses.rows.length > 0">
          <div v-for="row in expenses.rows" :key="row.id" class="fakeTable-body" :class="toUserExpenses ? 'grid-cols-7' : 'grid-cols-8'">
            <p>{{ row.created }}</p>
            <p>{{ row.name }}</p>
            <p>{{ row.tower }}</p>
            <p>{{ parsePrices(row.mount_dollars).dol }}</p>
            <p>{{ parsePrices(row.mount_bs).bs}}</p>
            <p>{{ row.dollarBefore }} bs.</p>
            <p>
              <img class="h-16 transition-all cursor-pointer hover:scale-[.8]" :src="`${url}/${row.image}`" alt="factura" @click="() => viewImage = `${url}/${row.image}`" v-if="row.image">
            </p>
            <p v-if="!toUserExpenses">
              <ActionsTable :recibesBtn="false" :editBtn="activeCreate" :deleteBtn="activeCreate"
                @remove="deleteExpense(row.id)" @edit="$emit('form', { id: row.id })"/>
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
