<script setup lang="ts">
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";
import { onMounted } from "vue";
import type { Params } from "@/types/params";
import NotRecords from "@/components/notRecords.vue";
import { onBeforeRouteUpdate } from "vue-router";
import useIndex from '../../../composables/elevators/history/history'
import { parseDate } from "@/utils/parseDate";


const url = import.meta.env.VITE_APP_API_URL

const {
  data,
  route,
  loaded,
  viewImage,
  getHistory,
  setSort,
  loadScroll,
  setSearch,
} = useIndex()

onMounted(() => getHistory(new URLSearchParams(route.query as Params).toString()))

onBeforeRouteUpdate(async (to, from) => {
  if (to.query !== from.query) {
    await getHistory(
      new URLSearchParams(to.query as Params).toString()
    )
  }
})
</script>

<template>
  <main class="h-full w-full p-10 relative">
    <tablesHeader title="Historial de reparación" icon="timeline" :searchActive="true"
      @setSearch="({ e }) => setSearch(e)" :btnCreate="false" />
    <slot/>
    <div v-if="viewImage" class="overlay w-full grid place-items-center bg-[#000000ab] cursor-pointer"
      @click="viewImage = ''">
      <img class="w-[100%] md:h-[50%] md:w-auto cursor-default" :src="`${viewImage}`" alt="imagen" @click.stop>
    </div>

    <section class="relative my-4 overflow-auto animate-fade-in mx-auto md:w-[90%]">

      <div class="fakeTable overflow-hidden table-animation h-[80vh]" @scroll="loadScroll">
        <article class="fakeTable-head grid-cols-7">
          <a to="#" class="cursor-pointer" @click.prevent="setSort('number')">
            Número de ascensor
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <a to="#" class="cursor-pointer" @click.prevent="setSort('tower')">
            Torre
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <p>Fecha</p>
          <p>Descripción</p>
          <p>Estado</p>
          <p>Gasto</p>
          <p>Imagen</p>
        </article>

        <section v-if="data.rows.length > 0">
          <div v-for="row in data.rows" :key="row.id" class="fakeTable-body grid-cols-7">
            <p>{{ row.elevator }}</p>
            <p>{{ row.tower }}</p>
            <p>{{ parseDate(row.date) }}</p>
            <p>{{ row.description }}</p>
            <p class="flex justify-center items-center gap-4" :class="row.status ? 'text-green-700' : 'text-red-500'">
            <label class="font-bold">{{ row.status ? 'Operativo' : 'Dañado' }}</label>
            <font-awesome-icon :icon="row.status ? 'circle-check' : 'circle-xmark'" class="scale-[1.5]"
              :title="row.status ? 'Operativo' : 'Dañado'" />
            </p>
            <p>
              <img class="h-16 transition-all cursor-pointer hover:scale-[.8]" :src="`${url}/${row.image}`"
                alt="gasto" @click="() => viewImage = `${url}/${row.image}`" v-if="row.image">
            </p>
            <p>
              <img class="h-16 transition-all cursor-pointer hover:scale-[.8]" :src="`${url}/${row.historyElevator}`"
                alt="imagen" @click="() => viewImage = `${url}/${row.historyElevator}`" v-if="row.historyElevator">
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
