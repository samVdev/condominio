<script lang="ts" setup>
import { ref } from 'vue'
import { useRoute, onBeforeRouteUpdate } from 'vue-router'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css' // importante para los estilos
import { meses } from '@/utils/constantes/months';

const props = defineProps<{
  title: string,
  icon: string,
  searchActive: boolean,
  btnCreate: boolean,
  filterMonth?: boolean,
  year?: boolean
}>()

const route = useRoute()
const params = new URLSearchParams(route.query as any)

const search = ref(decodeURIComponent(params.get('search') || ''))

let fakeEvent: any = {
  target: {
    value: ''
  }
}

onBeforeRouteUpdate(async (to, from) => {
  if (to.query !== from.query) {
    const params = new URLSearchParams(to.query as any)
    search.value = decodeURIComponent(params.get('search') || '')
  }
})

const selectedDate = ref<Date | null>(null)
</script>

<template>
  <div class="flex flex-col md:flex-row gap-5 items-center justify-between px-10">
    <div class="font-bold text-2xl text-gray-700 flex gap-4 items-center justify-normal w-full md:w-auto">
      <font-awesome-icon :icon="icon" />
      <h1>{{ title }}</h1>
    </div>

    <div class="grid place-items-center gap-5 md:flex md:items-center md:justify-start w-full md:w-[90%]"
      v-if="searchActive">
      <div class="bg-white shadow rounded-3xl justify-self-start w-full md:w-[30%]">
        <input class="w-full block outline-none" :value="decodeURIComponent(search)" type="text"
          @keyup.enter="(e: any) => $emit('setSearch', { e: e })" placeholder="Buscar" />
      </div>

      <button title="Limpiar búsqueda" v-if="search"
        class="ml-1 bg-[#e2384f83] text-white px-2 py-1 rounded-full scale-[.8] cursor-pointer"
        @click="() => $emit('setSearch', { e: fakeEvent })">
        <font-awesome-icon icon="xmark" />
      </button>

      <div class="flex items-center md:w-[50%]" v-if="filterMonth">
        <Datepicker v-model="selectedDate" :year-range="[2025, new Date().getFullYear() + 5]" :locale="'es'"
          :month-picker="!year" :year-picker="year" placeholder="Seleccionar fecha" @update:model-value="(e: any) => {
            if (!e) return $router.push($route.path)
            if (year) {
              $emit('changedYear', {year: e})
            } else {

              const month = e.month < 12 ? e.month + 1 : e.month
              const findedMonth = meses.find(e => e.number == month)
              if (!findedMonth) return

              const data = {
                ...e,
                month
              }
              $emit('setMonth', data)
            }
          }" />
      </div>
    </div>

    <button v-if="btnCreate" @click="$emit('create')"
      class="bg-blue-600 text-white font-bold w-[50vw] md:w-[10%] h-[50px] rounded-3xl block transition-all hover:bg-blue-500">
      Crear
    </button>
  </div>
</template>
