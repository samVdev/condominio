<script setup lang="ts">
// @ts-nocheck
import { onMounted, reactive } from "vue";
import { onBeforeRouteUpdate } from 'vue-router' 
import AppPaginationB from "@/components/AppPaginationB.vue";
import tablesHeader from "@/components/tablesHeader.vue"
import * as RoleService from "@/modules/Authorization/services/RoleService";
import useTableGrid from "@/composables/useTableGrid";
import useRole from "./useRole";
import ActionsTable from "@/components/actionsTable.vue";

const {
  deleteRole,
  errors,
  sending,     
} = useRole()

const data = reactive({
  rows: [],// as User[],
  links: [],
  search: "",
  sort: "",
  direction: ""
});

const load = (newParams: object) => {
  const params = {
    search: data.search || "",
    sort: data.sort || "",
    direction: data.direction || "",
    ...newParams,
  };

  router.push({
    path:'/roles',
    query: {
      ...route.query,
      ...params
    }
  });
};

const { 
    route,
    router,

    setSearch,
    setSort,
} = useTableGrid(data, "/roles")

const getRoles = (routeQuery: string) => {
  return RoleService.getRoles(routeQuery)
    .then((response) => {
      data.rows = response.data.rows.data;
      data.links = response.data.rows.links;
      data.search = response.data.search;
      data.sort = response.data.sort;
      data.direction = response.data.direction;
    })
    .catch((error) => {
      console.log(error);
    });
};
    
onBeforeRouteUpdate(async (to, from) => {      
  if (to.query !== from.query) {     
    // @ts-ignore   
    await getRoles(new URLSearchParams(to.query).toString());        
  }
});

onMounted(() => {
  // @ts-ignore
  getRoles(new URLSearchParams(route.query).toString());  
});

const deleteRow = (rowId?: string) => {
  if (rowId === undefined) return;
  if (confirm(`¿Estás seguro de que quieres eliminar el registro ${rowId}?`)) {
    deleteRole(rowId)
  }
};
</script>

<template>
  <div>
    <tablesHeader title="Roles" icon="user-secret" :searchActive="true" :btnCreate="true" @setSearch="({e}) => setSearch(e)" @create="router.push('/roles/create')"/>
    <div class="overflow-hidden panel mt-6">

      <div class="w-full mx-auto md:w-[90%]">
        <table class="table-data">
          <thead>
            <tr class="">
              <th class="">
                <a class="cursor-pointer" to="#" @click.prevent="setSort('name')">Name</a>
              </th>
              <th class="">
                <a class="cursor-pointer" to="#" @click.prevent="setSort('description')">Description</a>
              </th>
              <th class="">Acción</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="role in data.rows" :key="role.id" class="">
              <td class="">
                <a
                  class="text-indigo-600 hover:text-indigo-800 underline"
                  :to="{ name: 'roleEdit', params: { id: role.id }}"                  
                >
                  {{ role.name }}
                </a>
              </td>
              <td class="">
                {{ role.description }}
              </td>
              <td class="">
                <ActionsTable :deleteBtn="true" :editBtn="true" @edit="router.push({ path: '/roles/edit/'+role.id })" @remove="deleteRow(row.id)" />
              </td>
            </tr>
            <tr v-if="data.rows.length === 0">
              <td class="" colspan="4">Roles no encontrados.</td>
            </tr>
          </tbody>
        </table>
      </div>
      <AppPaginationB v-if="data.links" :links="data.links" />
    </div>
  </div>
</template>
