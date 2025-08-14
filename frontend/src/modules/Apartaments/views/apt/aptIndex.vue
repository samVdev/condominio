<script setup lang="ts">
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";
import useIndex from "../../composables/apt/useIndex";
import { onMounted } from "vue";
import type { Params } from "@/types/params";
import NotRecords from "@/components/notRecords.vue";
import ActionsTable from "@/components/actionsTable.vue";
import { onBeforeRouteUpdate } from "vue-router";
import CardDash from "@/modules/Auth/components/cardDash.vue";

const {
  data,
  route,
  loaded,
  resumeData,
  getApt,
  setSort,
  loadScroll,
  setSearch,
  deleteApt
} = useIndex()

onMounted(() => getApt(new URLSearchParams(route.query as Params).toString()))

onBeforeRouteUpdate(async (to, from) => {
  if (to.query !== from.query && (from.path == '/condominium/apt' && to.path == '/condominium/apt')) {
    await getApt(
      new URLSearchParams(to.query as Params).toString()
    )
  }
})


</script>

<template>
  <main>

    <section class="grid grid-cols-1 gap-5 px-2 py-5 mx-auto md:w-[90%] md:px-5 md:grid-cols-2">
      <CardDash :redirect="false" icon="building" :value="`${resumeData.count}`" label="Total apartamentos" />
      <CardDash :redirect="false" icon="percent" :value="`${resumeData.porcent}%`" label="Alicuota usada" />
    </section>

    <tablesHeader title="Apartamentos" icon="building" :searchActive="true" @setSearch="({ e }) => setSearch(e)"
      :btnCreate="true" @create="() => $router.push('apt/form')" />


    <router-view v-slot="{ Component }">
      <Transition name="expandModal" :style="{ '--modal-top': `50%`, '--modal-left': `50%` }">
        <div v-if="$route.path.includes('/apt/form')" class="overlay w-full grid place-items-center bg-[#000000ab]">
          <component :is="Component" :key="$route.path" />
        </div>
      </Transition>
    </router-view>

    <section class="relative my-4 overflow-auto animate-fade-in mx-auto md:w-[90%]">

      <div class="fakeTable overflow-hidden table-animation h-[70vh]" @scroll="loadScroll">
        <article class="fakeTable-head grid-cols-6">
          <a to="#" class="cursor-pointer" @click.prevent="setSort('tower')">
            Torre
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <a to="#" class="cursor-pointer" @click.prevent="setSort('name')">
            Nombre
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <a to="#" class="cursor-pointer" @click.prevent="setSort('sizes')">
            Tamaño
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <a to="#" class="cursor-pointer" @click.prevent="setSort('porcent')">
            Porcentaje
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <a to="#" class="cursor-pointer" @click.prevent="setSort('persona')">
            Propietario
            <font-awesome-icon icon="sort" class="ml-2" />
          </a>
          <p>Acción</p>
        </article>

        <section v-if="data.rows.length > 0">
          <div v-for="row in data.rows" :key="row.id" class="fakeTable-body grid-cols-6">
            <p>{{ row.tower }}</p>
            <p>{{ row.name }}</p>
            <p>{{ row.sizes }}</p>
            <p>{{ row.porcent }}%</p>
            <p>{{ row.persona || 'Sin propietario' }}</p>
            <p>
              <ActionsTable :recibesBtn="false" :editBtn="true" :deleteBtn="true" @remove="deleteApt(row.id)"
                @edit="() => $router.push({ name: 'aptForm', params: { id: row.id } })" />
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
