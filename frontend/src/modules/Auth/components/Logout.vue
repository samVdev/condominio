<script setup lang="ts">
import { computed } from "vue"
import { useAuthStore } from '@/modules/Auth/stores'

const props = defineProps<{
  to: string,
  text: string
}>()

const authStore = computed(() => useAuthStore())
const logout = async () => await authStore.value.logout(props.to)
</script>

<template>
  <button
    type="button"
    @click="logout"
    class="inline-flex items-center space-x-2"
  >
    <span class="inline">{{ text }}</span>
    <font-awesome-icon icon="arrow-right-from-bracket" />
  </button>
</template>

