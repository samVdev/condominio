<script setup lang="ts">
// @ts-nocheck
import useIndex from "../composables/useIndex";
import AppPaginationB from "@/components/AppPaginationB.vue";
import tablesHeader from "@/components/tablesHeader.vue"
import AppBtn from "@/components/AppBtn.vue"
import AvatarIcon from "@/icons/AvatarIcon.vue"
import ActionsTable from "@/components/actionsTable.vue";

const {
  errors,
  data,
  router,

  deleteRow,
  setSearch,
  setSort  
} = useIndex()

</script>

<template>
      <div class="w-full">
        <table class="rounded-none rounded-b-none">
          <thead class="bg-[#EC6476] text-white border-b-[1px] border-gray-300">
            <tr class="">
              <th class="py-3">
                <a to="#" class="cursor-pointer" @click.prevent="setSort('name')">Nombre</a>
              </th>
              <th class="py-3">
                <a to="#" class="cursor-pointer" @click.prevent="setSort('email')">Correo</a>
              </th>
              <th class="py-3">
                <a to="#" class="cursor-pointer" @click.prevent="setSort('email')">Celular</a>
              </th>
              <th class="py-3">
                <a to="#" class="cursor-pointer" @click.prevent="setSort('Apartamento')">Apartamento</a>
              </th>
              <th class="py-3">
                <a to="#" class="cursor-pointer" @click.prevent="setSort('recibos')">Recibos Pendientes</a>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in data.rows" :key="row.uuid" class="">
              <td class="">
                {{ row.nombre }}
              </td>
              <td class="">
                {{ row.email }}
              </td>
              <td class="">
                {{ row.phone }}
              </td>
              <td class="">
                {{ row.apt }}
              </td>
              <td class="">
                {{ row.pending_receipts }}
              </td>
            </tr>
            <tr class="FadeTR" v-if="data.rows.length === 0">
              <td class="" colspan="8">Usuarios no encontrados.</td>
            </tr>
          </tbody>
        </table>
      </div>
</template>
