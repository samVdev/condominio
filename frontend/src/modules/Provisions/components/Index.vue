<script setup lang="ts">
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";
import useIndex from "../composables/useIndex";
import { onMounted } from "vue";
import type { Params } from "@/types/params";
import ActionsTable from "@/components/actionsTable.vue";
import { parsePrices } from "@/utils/parsePrices";
import NotRecords from "@/components/notRecords.vue";
import { meses } from "@/utils/constantes/months";

const url = import.meta.env.VITE_APP_API_URL

const props = defineProps<{
  activeCreate?: boolean,
  toUserProvisions?: boolean
}>()

const emit = defineEmits(['getFunds', 'form'])

const {
  provisions,
  route,
  loaded,
  viewImage,
  getProvisions,
  deleteProvision,
  setSearch,
  setSort,
  loadScroll,
  setMonth
} = useIndex(emit)


onMounted(() => getProvisions(`?offset=${provisions.offset}&${new URLSearchParams(route.query as Params).toString()}`))

</script>

<template>
  <main>

    <tablesHeader title="Provisiones" icon="sack-dollar" :searchActive="true" @setSearch="({ e }) => setSearch(e)"
      :btnCreate="activeCreate" @create="$emit('form')" @setMonth="setMonth" :filterMonth="true"/>

    <div v-if="viewImage" class="overlay w-full grid place-items-center bg-[#000000ab] cursor-pointer"
      @click="viewImage = ''">
      <img class="w-[100%] md:h-[50%] md:w-auto cursor-default" :src="`${viewImage}`" alt="imagen" @click.stop>
    </div>

    <section className="relative mx-auto my-4 overflow-auto animate-fade-in">

      <div class="fakeTable overflow-hidden"
        :class="route.fullPath.includes('dashboard') ? 'h-[50vh] md:h-[70vh] 2xl:h-[90vh]' : 'table-animation h-[70vh]'"
        @scroll="loadScroll">
        <article class="fakeTable-head" :class="toUserProvisions ? 'grid-cols-7' : 'grid-cols-8'">
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
          <a to="#" class="cursor-pointer" @click.prevent="setSort('month')">
            Mes
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <a to="#" class="cursor-pointer" @click.prevent="setSort('pay')">
            Pagado
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <p v-if="!toUserProvisions">Acción</p>
        </article>

        <section v-if="provisions.rows.length > 0">
          <section>
            <div v-for="row in provisions.rows" :key="row.id" class="fakeTable-body capitalize"
              :class="toUserProvisions ? 'grid-cols-7' : 'grid-cols-8'">
              <p>{{ row.created }}</p>
              <p>{{ row.name }}</p>
              <p>{{ row.tower }}</p>
              <p>{{ parsePrices(row.mount_dollars).dol }}</p>
              <p>{{ parsePrices(row.mount_bs).bs }}</p>
              <p>{{ meses.find(e => e.number == row.month).name || 'No especificado'}}</p>
              <p>
                <font-awesome-icon :icon="row.pay ? 'circle-check' : 'circle-exclamation'" class="scale-[1.5]" 
                :title="row.pay ? 'Pagado totalmente' : 'Pendiente por pagar'"
                :class="row.pay ? 'text-green-600' : 'text-orange-500'"/>
              </p>
              <p v-if="!toUserProvisions">
                <ActionsTable v-if="!row.facture" :recibesBtn="false" :editBtn="true" :deleteBtn="true" 
                  @remove="deleteProvision(row.id)" @edit="$emit('form', { id: row.id })" />
              </p>
            </div>
          </section>
          <div class="fakeTable-body" v-if="provisions.Facture && provisions.Facture.USD > 0" :class="toUserProvisions ? 'grid-cols-7' : 'grid-cols-8'">
            <p></p>
            <p></p>
            <p></p>
            <p>{{parsePrices(provisions.Facture.USD).dol }}</p>
            <p>{{parsePrices(provisions.Facture.BS).bs }}</p>
            <p></p>
            <p></p>
            <p></p>
            <p v-if="!toUserProvisions">
            </p>
          </div>
        </section>
        <div class="FadeTR" v-else>
          <Loader v-if="!loaded" class="mx-auto mt-5" />
          <NotRecords v-else />
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
