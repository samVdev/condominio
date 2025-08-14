<script lang="ts" setup>
const props = defineProps<{
  id: any,
  question: string
  options: { label: string; votes: number }[]
  totalPresentes: number,
  isAdmin?: boolean,
  response: boolean,
  activeSurvey: boolean
}>()

const totalVotos = props.options.reduce((sum, opt) => sum + opt.votes, 0)

function estadoClase() {
  if (props.response) return 'bg-green-100 text-green-700'
  else return 'bg-yellow-100 text-yellow-700'
}

</script>

<template>
  <div class="bg-white p-6 rounded-xl shadow-md w-full md:w-96 relative">

    <div class="flex justify-between items-start mb-2">

      <div class="flex items-center justify-center gap-3">
        <p class="font-bold text-lg capitalize">📊 {{ question }}</p>
        <div :title="activeSurvey ? 'En progreso' : 'Cerrada'">
          <span class="relative flex h-4 w-4">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75"
            :class="activeSurvey ? 'bg-green-400' : 'bg-red-400'"
            ></span>
            <span class="relative inline-flex rounded-full h-4 w-4" :class="activeSurvey ? 'bg-green-500' : 'bg-red-500'"></span>
          </span>
        </div>
      </div>

      <span :class="estadoClase()" class="text-xs font-medium px-2 py-1 rounded-full">
        {{ response ? 'Completada' : 'Activa' }}
      </span>
    </div>

    <div class="space-y-2">
      <div v-for="option in options" :key="option.label" class="flex items-center justify-between gap-2">
        <span class="w-24">{{ option.label }}</span>
        <span class="text-sm font-semibold w-4">{{ option.votes }}</span>
        <div class="bg-gray-200 h-2 rounded w-full">
          <div class="bg-gray-800 h-2 rounded transition-all"
            :style="{ width: `${Math.round((option.votes / totalPresentes) * 100) || 0}%` }" />
        </div>
      </div>
    </div>
    <div class="text-xs text-gray-500 mt-4">
      {{ totalVotos }} votos · {{ totalPresentes }} presentes
    </div>

    <nav class="flex items-center gap-5 mt-2" :class="isAdmin ? 'justify-left' : 'justify-center'">
      <button v-if="!response && activeSurvey"
        class="block bg-gradient-to-r from-red-300 to-red-500  text-white hover:opacity-90 font-medium py-2 px-6 rounded-full transition"
        @click="$emit('reply')">
        Participar
      </button>
      <button class="block" @click="$emit('status', id)" v-if="isAdmin">
        <font-awesome-icon icon="rotate-right" />
      </button>
      <button class="block" @click="$emit('delete', id)" v-if="isAdmin">
        <font-awesome-icon icon="trash" />
      </button>
    </nav>
  </div>
</template>