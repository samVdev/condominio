<script setup lang="ts">
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";
import useIndex from "../composables/useIndex";
import { onMounted } from "vue";
import type { Params } from "@/types/params";
import NotRecords from "@/components/notRecords.vue";
import ActionsTable from "@/components/actionsTable.vue";
import { parseDate } from "@/utils/parseDate";

const {
  boards,
  route,
  loaded,
  getServices,
  deleteService,
  setSearch,
  loadScroll,
  setSort
} = useIndex()

onMounted(() => getServices(new URLSearchParams(route.query as Params).toString()))

</script>

<template>
  <main>
    <tablesHeader title="Juntas" icon="arrows-down-to-people" :searchActive="true" @setSearch="({ e }) => setSearch(e)"
      :btnCreate="true" @create="() => $router.push('boards/form')" />

    <router-view v-slot="{ Component }">
      <Transition name="expandModal" :style="{ '--modal-top': `50%`, '--modal-left': `50%` }">
        <div v-if="$route.path.includes('boards/form')" class="overlay grid place-items-center w-full bg-[#000000ab]">
          <component :is="Component" :key="$route.path" />
        </div>
      </Transition>
    </router-view>

    <Loader v-if="!loaded" class="mx-auto mt-[20%] translate-y-[-50%]" />

    <div class="relative w-[90%] mx-auto mt-10 overflow-auto md:h-[70%] md:px-4" v-else-if="boards.rows.length > 0">
      <div class="fakeTable mx-auto h-full" @scroll="loadScroll">
        <article class="fakeTable-head h-[15%] grid-cols-6">
          <a to="#" class="cursor-pointer" @click.prevent="setSort('name')">
            Nombre
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <a to="#" class="cursor-pointer" @click.prevent="setSort('description')">
            Descripción
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <a to="#" class="cursor-pointer" @click.prevent="setSort('date')">
            Fecha de la junta
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <a to="#" class="cursor-pointer" @click.prevent="setSort('active')">
            Activa
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <a to="#" class="cursor-pointer" @click.prevent="setSort('ended')">
            Finalizada
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <p>Acción</p>
        </article>

        <section v-if="boards.rows.length > 0">
          <div v-for="row in boards.rows" :key="row.uuid" class="grid-cols-6 fakeTable-body">
            <p>{{ row.nombre }}</p>
            <p>{{ row.descripcion }}</p>
            <p>{{ parseDate(row.fecha) }}</p>
            <p>
              <font-awesome-icon :icon="row.activa ? 'circle-check' : 'circle-xmark'" class="scale-[1.5]"
                :title="row.activa ? 'Activa' : 'Inactiva'"
                :class="row.activa ? 'text-green-600' : 'text-red-500'" />
            </p>
            <p>
              <font-awesome-icon :icon="row.statusEnd ? 'circle-check' : 'circle-xmark'" class="scale-[1.5]"
                :title="row.statusEnd ? 'Finalizada' : 'No ha finalizado'"
                :class="row.statusEnd ? 'text-green-600' : 'text-red-500'" />
            </p>
            <p>
              <ActionsTable :deleteBtn="!row.statusEnd" @remove="() => deleteService(row.uuid)" 
                :entryBtn="true" @entry="$router.push({name: 'board-live', params: {uuid: row.uuid}})"
                />
            </p>
          </div>
        </section>
      </div>
    </div>

    <section v-else-if="boards.rows.length == 0" class="h-[60vh]">
      <NotRecords />
    </section>
  </main>
</template>
