<script setup lang="ts">
import TablesHeader from "@/components/tablesHeader.vue";
import FormCreateOrEdit from "../components/FormCreateOrEdit.vue";
import useCreateOrEdit from "../composables/useCreateOrEdit";

const props = defineProps<{ uuid?: string }>()

const {
  user,
  errors,
  roles,
  sending,
  loading,
  submit    
} = useCreateOrEdit(props.uuid)
</script>

<template>
  <div>
    <TablesHeader :title="uuid ? 'Modificación de usuario' : 'Usuarios'" icon="users" :searchActive="false" :btnCreate="false"/>
      <div class="w-full md:w-[80%] mx-auto mt-6 p-4">           
          <FormCreateOrEdit
            class="p-5 rounded"
            @submit='submit'
            :uuid="props.uuid"
            :user='user'
            :sending='sending'
            :errors='errors'
            :roles="roles"            
          />
      </div>
  </div>
</template>
