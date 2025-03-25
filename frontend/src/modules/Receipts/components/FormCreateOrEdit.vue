<script setup lang="ts">
import { onMounted, reactive, ref } from "vue"
import type User from "../types/User"
import type Role from "../types/Role"
import Loader from "@/components/Loader.vue";
import InputPassword from "@/components/inputPassword.vue";

const props = defineProps<{
  uuid?: string
  user: User
  sending: boolean
  errors: any
  roles: Role[]
}>()

const emit = defineEmits<{
  (e: 'submit', user: User, userId?: string): void
}>()

const form: User = reactive(props.user)

const activeInputPassword = ref(true)

const submit = async () => {
  emit('submit', {
    name: form.name,
    email: form.email,
    phone: form.phone,
    password: form.password,
    role_id: form.role_id,
    apt_id: form.apt_id,
    suspend: form.suspend
  }, props.uuid)
}


onMounted(() => {
  if (props.uuid) activeInputPassword.value = false
})

</script>

<template>
  <form @submit.prevent="submit" class="p-4">

    <div class="grid lg:grid-cols-2 gap-4">
      <div class="mb-4">
        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre Completo:</label>
        <input type="text" id="nombre" required name="nombre" v-model="form.name"
          class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div class="mb-4">
        <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
        <input type="email" id="correo" required name="correo" v-model="form.email"
          class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div class="mb-4">
        <label for="celular" class="block text-sm font-medium text-gray-700">Celular:</label>
        <input type="tel" id="celular" required name="celular" v-model="form.phone" maxlength="11"
          placeholder="Ej: 0412000000"
          class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div class="mb-4">
        <label for="apartamento" class="block text-sm font-medium text-gray-700">Apartamento:</label>
        <select id="apartamento" required name="apartamento" v-model="form.apt_id"
          class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
          <option value="" disabled selected>Selecciona un apartamento</option>
          <option value="1">Apartamento 1</option>
          <option value="12">Apartamento 2</option>
          <option value="23">Apartamento 3</option>
        </select>
      </div>

      <div class="mb-6" v-if="activeInputPassword">
        <label for="contraseña" class="block text-sm font-medium text-gray-700">Contraseña:</label>
        <InputPassword v-model="form.password" name="password" placeholder="Ingresa la contraseña"
          class="mt-2 p-3 mb-2 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />

        <button v-if="uuid" @click="activeInputPassword = false"
          class="bg-[#EA5165] hover:bg-[#D54A5C] transition-all text-white font-bold w-full text-center mt-4 h-[40px] mx-auto grid place-items-center rounded-3xl md:w-[50%]">
          Quitar contraseña
        </button>
      </div>

      <div class="mb-6" v-else>
        <label for="contraseña" class="block text-sm font-medium text-gray-700">Contraseña:</label>
        <button @click="activeInputPassword = true"
          class="bg-[#EA5165] hover:bg-[#D54A5C] transition-all text-white font-bold w-full text-center mt-4 h-[40px] mx-auto grid place-items-center rounded-3xl md:w-[50%]">
          Cambiar contraseña
        </button>
      </div>

      <div class="mb-4">
        <label for="rol" class="block text-sm font-medium text-gray-700">Rol:</label>
        <select id="rol" required name="rol" v-model="form.role_id"
          class="capitalize mt-2 p-3 w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
          <option value="" disabled selected>Selecciona un Rol</option>
          <option v-for="rol in roles" :value="rol.id">{{ rol.name }}</option>
        </select>

        <label for="suspender" class="inline-flex items-center mt-5 text-sm font-medium text-gray-700">
          <input type="checkbox" id="suspender" v-model="form.suspend" class="mr-2">
          Suspender a la persona
        </label>

      </div>
    </div>

    <div class="mt-4 px-2 border-gray-100 flex text-center justify-end space-x-2">
      <button v-if='!sending'
        class="bg-[#EA5165] hover:bg-[#D54A5C] transition-all text-white font-bold w-full text-center mt-4 h-[40px] mx-auto grid place-items-center rounded-3xl md:w-[50%]">
        Guardar
      </button>

      <Loader v-else class="mx-auto" />
    </div>
  </form>
</template>
