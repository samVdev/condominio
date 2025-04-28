<script setup lang="ts">
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";
import useIndex from "../composables/useIndex";
import { onMounted } from "vue";
import CardServices from "../components/cardServices.vue";
import formService from "../components/formService.vue";
import type { Params } from "@/types/params";
import NotRecords from "@/components/notRecords.vue";

const {
  isOpenCreate,
  services,
  data,
  sending,
  route,
  loaded,
  getServices,
  showService,
  deleteService,
  setSearch,
  submit,
  loadScroll
} = useIndex()

onMounted(() => getServices(new URLSearchParams(route.query as Params).toString()))

</script>

<template>
<main>
  <tablesHeader title="Servicios" icon="hand-holding-droplet" :searchActive="true" @setSearch="({e}) => setSearch(e)" :btnCreate="true" @create="isOpenCreate = true"/>

    <Loader v-if="!loaded" class="mx-auto mt-[20%] translate-y-[-50%]"/>
    
    <section @scroll="loadScroll"
     className="max-w-[1200px] h-[100vh] content-start mx-auto mt-5 grid grid-cols-1 gap-4 p-4 animate-fade-in md:h-[80vh] md:grid-cols-2 lg:grid-cols-3" v-else-if="services.rows.length > 0">
      <CardServices :created="service.created" :is_elevator="service.is_elevator" :name="service.name" @edit="showService(service.id)" @delete="deleteService(service.id)" v-for="service in services.rows"/>
    </section>

    <section v-else-if="services.rows.length == 0" class="h-[60vh]">      
      <NotRecords/>
    </section>

    <div class="fixed z-[1000] inset-0 overflow-y-auto ease-out duration-400 bg-black/80 grid place-items-center" v-if="isOpenCreate">
        <formService :data="data" @closeModal="isOpenCreate = false" @submit="submit" v-if="!sending"/>
        <Loader v-else/>        
    </div>
</main>
</template>
