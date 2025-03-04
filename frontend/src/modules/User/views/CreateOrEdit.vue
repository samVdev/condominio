<script setup lang="ts">
import FormCreateOrEdit from "../components/FormCreateOrEdit.vue";
import useCreateOrEdit from "../composables/useCreateOrEdit";

const props = defineProps<{ uuid?: string }>()

const {
  user,
  errors,
  roles,
  sending,
  loading,
  router,

  submit    
} = useCreateOrEdit(props.uuid)
</script>

<template>
  <div>
    <transition name="fade" mode="out-in">
      <tablesHeader
        message="loading..."
        v-if="loading && !user"
        key="loading"
      />
      <div v-else class="panel mt-6 p-4">           
        <div  class="flex space-x-2">
          <button
            class="btn btn-primary mb-4"
            @click="router.push({ path: '/users' })"
          >
            Ver todos
          </button>
        </div>
        <div class="panel mt-6">
          <FormCreateOrEdit
            class="p-5 border rounded shadow"
            @submit='submit'
            :id="props.uuid"
            :user='user'
            :sending='sending'
            :errors='errors'
            :roles="roles"            
          />
        </div>
      </div>
    </transition>
  </div>
</template>
