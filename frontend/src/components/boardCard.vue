<script setup lang="ts">
const props = defineProps<{
    nombre: string
    fecha: string
    descripcion: string
    participantes: Array<any>
}>()

function formatDate(fecha: string) {
  const date = new Date(fecha)
  return date.toLocaleDateString('es-VE', {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
}
</script>



<template>
    <div class="bg-white shadow-md rounded-xl p-4 w-full max-w-md border border-gray-200 h-[200px] flex flex-col justify-between">
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-800">{{ nombre }}</h2>
            <p class="text-gray-500 text-sm mt-2">{{ descripcion }}</p>
        </div>

        <div class="flex items-center justify-between text-gray-700 mb-4">
            <span class="text-sm">
                <font-awesome-icon icon="users" />
                {{ participantes }} personas
            </span>
            <span class="text-sm">
                <font-awesome-icon icon="calendar-days" />
                {{ formatDate(fecha) }}
            </span>
        </div>

        <button class="w-full bg-[#E2384F] hover:bg-[#EA5165] text-white py-2 px-4 rounded-xl transition duration-200"
            @click="$emit('entryBoard')">
            Entrar
        </button>
    </div>
</template>