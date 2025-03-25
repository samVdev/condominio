<script setup lang="ts">
// @ts-nocheck
import useIndex from "../composables/useIndex";
import AppPaginationB from "@/components/AppPaginationB.vue";
import tablesHeader from "@/components/tablesHeader.vue"
import ActionsTable from "@/components/actionsTable.vue";
import Loader from "@/components/Loader.vue";

const {
  errors,
  data,
  router,
  loaded,
  deleteRow,
  setSearch,
  setSort,
  loadScroll
} = useIndex()

</script>

<template>
  <div class="relative overflow-auto md:h-[70%] md:px-4">
    <div class="fakeTable mx-auto h-full" @scroll="loadScroll">
      <article class="fakeTable-head h-[15%] grid-cols-6">
        <a to="#" class="cursor-pointer" @click.prevent="setSort('name')">
          Nombre
          <font-awesome-icon icon="sort" class="ml-2" />
        </a>
        <a to="#" class="cursor-pointer" @click.prevent="setSort('email')">
          Correo
          <font-awesome-icon icon="sort" class="ml-2" />
        </a>
        <a to="#" class="cursor-pointer" @click.prevent="setSort('phone')">
          Celular
          <font-awesome-icon icon="sort" class="ml-2" />
        </a>
        <a to="#" class="cursor-pointer" @click.prevent="setSort('tower')">
          Torre
          <font-awesome-icon icon="sort" class="ml-2" />
        </a>
        <a to="#" class="cursor-pointer" @click.prevent="setSort('apt')">
          Apartamento
          <font-awesome-icon icon="sort" class="ml-2" />
        </a>
        <a to="#" class="cursor-pointer" @click.prevent="setSort('recibos')">
          Recibos pendientes
          <font-awesome-icon icon="sort" class="ml-2" />
        </a>
      </article>


      <section v-if="data.rows.length > 0">
        <div v-for="row in data.rows" :key="row.uuid" class="grid-cols-6 fakeTable-body">
          <p>{{ row.nombre }}</p>
          <p>{{ row.email }}</p>
          <p>{{ row.phone }}</p>
          <p>{{ row.tower }}</p>
          <p>{{ row.apt }}</p>
          <p>{{ row.pending_receipts }}</p>
        </div>
      </section>

      <div class="FadeTR" v-if="data.rows.length === 0">
        <Loader v-if="loaded" />
        <p v-else>Usuarios no encontrados.</p>
      </div>
    </div>

  </div>
</template>
