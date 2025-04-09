<script setup lang="ts">
import useIndex from "../composables/useIndex";
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";

const {
  data,
  loaded,
  route,
  setSearch,
  setSort,
  loadScroll
} = useIndex()

</script>

<template>
  <div class="mt-10 w-full ">

    <h1 class="text-3xl font-semibold leading-loose text-gray-900 dark:text-white my-5 text-center">Usuarios pendientes de pago</h1>

    <label class="fixed top-3 right-5 cursor-pointer text-black text-3xl"
      @click="$router.push(route.query.back as string || '/dashboard')">x</label>

    <tablesHeader title="Usuarios" icon="users" :searchActive="true" @setSearch="({ e }) => setSearch(e)"
      :btnCreate="false" />

    <section className="relative mx-auto my-4 overflow-auto animate-fade-in">

      <div class="fakeTable md:w-[90%] mx-auto h-[80vh]" @scroll="loadScroll">
        <article class="fakeTable-head grid-cols-6">
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
          <a to="#" class="cursor-pointer" @click.prevent="setSort('rol')">
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
            <!--p>
              <ActionsTable :deleteBtn="false" :editBtn="false" :recibesBtn="true"
                @recives="() => $router.push({ path: '/receipts/expenses-user', query: { user: row.uuid, nameUser: row.nombre, back: '/expenses'} })" />
            </p-->
          </div>
        </section>
        <div class="FadeTR" v-if="data.rows.length === 0">
            <Loader v-if="loaded" />
            <p v-else>Usuarios no encontrados.</p>
        </div>
      </div>

    </section>

  </div>
</template>
