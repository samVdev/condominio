<script lang="ts" setup>
defineProps<{
  name: string
  connectedText: string
  connected: boolean
}>()
</script>

<template>
  <div
    class="rounded-xl p-4 w-40 text-center border transition"
    :class="connected
      ? 'bg-green-50 border-green-300 text-green-900'
      : 'bg-white border-gray-200 text-gray-400'"
  >
    <p class="font-semibold">{{ name }}</p>
    <p class="text-sm mt-1">
      {{ connectedText  }}
    </p>
  </div>
</template>
