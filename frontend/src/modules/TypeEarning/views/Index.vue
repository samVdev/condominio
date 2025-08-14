<script setup lang="ts">
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";
import useIndex from "../composables/useIndex";
import { onMounted } from "vue";
import CardTypeEarnings from "../components/cardType.vue";
import formTypeEarning from "../components/formType.vue";
import type { Params } from "@/types/params";
import NotRecords from "@/components/notRecords.vue";

const {
  isOpenCreate,
  typeEarnings,
  data,
  sending,
  route,
  loaded,
  getTypeEarnings,
  showTypeEarning,
  deleteTypeEarning,
  setSearch,
  submit,
  loadScroll
} = useIndex()

onMounted(() => getTypeEarnings(new URLSearchParams(route.query as Params).toString()))

</script>

<template>
<main>
  <tablesHeader title="Tipos" icon="money-bill-trend-up" :searchActive="true" @setSearch="({e}) => setSearch(e)" :btnCreate="true" @create="isOpenCreate = true"/>

    <Loader v-if="!loaded" class="mx-auto mt-[20%] translate-y-[-50%]"/>
    
    <section @scroll="loadScroll" className="max-w-[1200px] h-[80vh] content-start overflow-auto mx-auto mt-5 grid grid-cols-1 gap-4 p-4 animate-fade-in md:h-[70vh] md:grid-cols-2 lg:grid-cols-3" v-else-if="typeEarnings.rows.length > 0">
      <CardTypeEarnings :created="typeEarning.created" :name="typeEarning.name" @edit="showTypeEarning(typeEarning.id)" @delete="deleteTypeEarning(typeEarning.id)" v-for="typeEarning in typeEarnings.rows"/>
    </section>

    <section v-else-if="typeEarnings.rows.length == 0" class="h-[60vh]">      
      <NotRecords/>
    </section>

    <div class="fixed z-[1000] inset-0 overflow-y-auto ease-out duration-400 bg-black/80 grid place-items-center" v-if="isOpenCreate">
        <formTypeEarning :data="data" @closeModal="isOpenCreate = false" @submit="submit" v-if="!sending"/>
        <Loader v-else/>        
    </div>
</main>
</template>
