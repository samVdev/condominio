<script setup lang="ts">
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";
import useIndex from "../composables/useIndex";
import { onMounted } from "vue";
import cardNews from "../components/cardNews.vue";
import type { Params } from "@/types/params";
import NotRecords from "@/components/notRecords.vue";
import ActionsTable from "@/components/actionsTable.vue";

const {
  posts,
  route,
  loaded,
  getServices,
  deleteService,
  setSearch,
  loadScroll,
  sendEmail,
} = useIndex()

onMounted(() => getServices(new URLSearchParams(route.query as Params).toString()))

</script>

<template>
  <main>
    <tablesHeader title="Noticias" icon="newspaper" :searchActive="true" @setSearch="({ e }) => setSearch(e)"
      :btnCreate="true" @create="() => $router.push('news/form')" />

    <router-view v-slot="{ Component }">
      <Transition name="expandModal" :style="{ '--modal-top': `50%`, '--modal-left': `50%` }">
        <div v-if="$route.path.includes('news/form')" class="overlay grid place-items-center w-full bg-[#000000ab]">
          <component :is="Component" :key="$route.path" />
        </div>
      </Transition>
    </router-view>

    <Loader v-if="!loaded" class="mx-auto mt-[20%] translate-y-[-50%]" />
    <section @scroll="loadScroll"
      className="max-w-[1300px] mx-auto h-[100vh] md:h-[80vh] mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4 p-4 animate-fade-in"
      v-else-if="posts.rows.length > 0">
      <cardNews :titulo="row.titulo" :subtitulo="row.subtitulo" :imagen="row.imagen" v-for="row in posts.rows">

        <div class="absolute bottom-2 w-[90%] mx-auto">
          <ActionsTable :emailBtn="true" :editBtn="true"  :deleteBtn="true" 
            @remove="deleteService(row.id)"
            @email="sendEmail(row.id)"
            @edit="$router.push({ name: 'formNews', params: { id: row.id } })" 
            />


        </div>
      </cardNews>
    </section>

    <section v-else-if="posts.rows.length == 0" class="h-[60vh]">
      <NotRecords />
    </section>
  </main>
</template>
