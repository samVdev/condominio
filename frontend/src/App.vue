<script setup lang="ts">
import { computed } from "vue"
import { useRouter } from "vue-router"

const defaultLayout = "empty"
const { currentRoute } = useRouter()
const layout = computed(
  () => `${currentRoute.value.meta.layout || defaultLayout}-layout`
)
</script>

<template>
  <component :is="layout">
    <router-view v-slot="{Component}">
    <component :is="Component" :key="$route.path"></component>
    </router-view>
  </component>
</template>

