<script setup lang="ts">
// @ts-nocheck
import useIndex from "../composables/useIndex";
import AppPaginationB from "@/components/AppPaginationB.vue";
import tablesHeader from "@/components/tablesHeader.vue"
import AppBtn from "@/components/AppBtn.vue"
//import AvatarIcon from "@/icons/AvatarIcon.vue"
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
  <div>
    <tablesHeader title="Usuarios" icon="users" :searchActive="true" 
    @setSearch="({e}) => setSearch(e)" :btnCreate="true" @create="router.push('/users/create')"/>
    <div class="overflow-hidden panel mt-6">       
      <div  class="w-full mx-auto md:w-[90%]">
        <table class="table-data">
          <thead>
            <tr class="">
              <th class="">
                Avatar
              </th>
              <th class="">
                <a to="#" class="cursor-pointer" @click.prevent="setSort('name')">Nombre</a>
              </th>
              <th class="">
                <a to="#" class="cursor-pointer" @click.prevent="setSort('email')">Correo</a>
              </th>
              <th class="">
                <a to="#" class="cursor-pointer" @click.prevent="setSort('email')">Celular</a>
              </th>
              <th class="">
                <a to="#" class="cursor-pointer" @click.prevent="setSort('Apartamento')">Apartamento</a>
              </th>
              <th class="">
                <a to="#" class="cursor-pointer" @click.prevent="setSort('role')">Rol</a>
              </th>
              <th class="">Acción</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in data.rows" :key="row.uuid" class="">
              <td>
              <div class="inline-flex items-center space-x-2">
            <img
              v-if="row.avatar"
              :src="row.avatar"
              class="w-10 h-10 rounded-full"
              alt=""
            />
            <p v-else >Sin avatar</p>    
          </div>
              </td>
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
                {{ row.rol }}
              </td>
              <td class="">
                <ActionsTable :deleteBtn="true" :editBtn="true" 
                @edit="router.push({ path: '/users/edit/'+row.uuid })" 
                @remove="deleteRow(row.uuid)" />
              </td>
            </tr>
            <tr class="FadeTR" v-if="data.rows.length === 0">
              <td class="" colspan="8">Usuarios no encontrados.</td>
            </tr>
          </tbody>
        </table>
      </div>
      <span v-if="Object.keys(errors).length > 0" class="text-red-500">{{ errors }}</span>
      <AppPaginationB v-if="data.links" :links="data.links" />      
    </div>
  </div>
</template>
