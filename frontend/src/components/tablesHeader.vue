<script lang="ts" setup>
const props = defineProps<{
  title: string,
  icon: string,
  searchActive: boolean,
  btnCreate: boolean
}>()
</script>

<template>
  <div class="flex flex-col md:flex-row gap-5 items-center justify-between px-10">
    <div class="font-bold text-2xl text-gray-700 flex gap-4 items-center justify-normal w-full md:w-auto">
      <font-awesome-icon :icon="icon" />
      <h1>
        {{ title }}
      </h1>
    </div>

  <div class="flex items-center justify-start w-full md:w-[80%]">
    <div class="bg-white shadow rounded-3xl py-2 px-4 justify-self-start overflow-hidden w-full md:w-[30%]">
      <input class="w-full block outline-none" type="text" @input="(e: any) => $emit('setSearch', { e: e })" placeholder="Buscar" />
    </div>
  </div>

    <button v-if="btnCreate" @click="$emit('create')"
      class="bg-blue-600 text-white font-bold w-[50vw] md:w-[90px] h-[50px] rounded-3xl block">
      Crear
    </button>
  </div>
</template>
