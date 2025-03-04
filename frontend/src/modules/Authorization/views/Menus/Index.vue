<script lang="ts" setup>
 // @ts-nocheck 
import { ref, onMounted } from 'vue';
import * as MenuService from "@/modules/Authorization/services/MenuService";
import AppPaginationB from "@/components/AppPaginationB.vue";
import tablesHeader from "@/components/tablesHeader.vue";
import Create from './Create.vue';
import Edit from './Edit.vue';
import ActionsTable from '@/components/actionsTable.vue';
import { questionSweet } from '@/utils/question';

const isOpenCreate = ref(false);
const isOpen = ref(false);
const menu = ref({});
const menus = ref([]);

const openModalCreate = () => {
  isOpenCreate.value = true;
};

const openModal = () => {
  isOpen.value = true;
};

const closeModalCreate = () => {
  isOpenCreate.value = false;
};

const closeModal = () => {
  isOpen.value = false;
};

const edit = (data: any) => {
  menu.value = data;
  openModal();
};

const get = async () => {
  menus.value = [];
  const response = await MenuService.getMenus();
  menus.value = response.data.data;
};

const saved = async () => {
  closeModalCreate();
  closeModal();
  await get();
};

const remove = async (id: number | undefined) => {
  if (id === undefined) return;
  const confirm = await questionSweet('Atención', `¿Estás seguro de que quieres eliminar el registro?`, 'question');
  if (!confirm) return;
  await MenuService.deleteMenu(id);
  await get();
};

onMounted(async () => {
  await get();
});
</script>

<template>
  <div>
    <tablesHeader icon="list" title="Menús" :searchActive="false" :btnCreate="true" @create="openModalCreate()" />

    <div class="overflow-hidden mt-6 mx-auto md:w-[90%]">
      <table class="table-data">
        <thead>
          <tr class="">
            <th class="">Menu</th>
            <th class="">URL</th>
            <th class="">Icon</th>
            <th class="">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="menu in menus" :key="menu.id">
            <td class="">{{ menu.title }}</td>
            <td class="">{{ menu.path }}</td>
            <td class="">
              <font-awesome-icon :icon="menu.icon" />
            </td>
            <td class="">
              <ActionsTable :deleteBtn="true" :editBtn="true" @edit="edit(menu)" @remove="remove(menu.id)" />
            </td>
          </tr>
        </tbody>
      </table>

      <div class="fixed z-[1000] inset-0 overflow-y-auto ease-out duration-400" v-if="isOpenCreate">
        <Create @closeModal0="closeModalCreate" @saved="saved" />
      </div>
      <div class="fixed z-[1000] inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
        <Edit :menu="menu" @closeModal1="closeModal" @updated="saved"/>
      </div>

    </div>
  </div>
</template>
