<script setup lang="ts">
import { computed } from "vue"
import { useRouter } from "vue-router"

const defaultLayout = "empty"
const { currentRoute } = useRouter()
const layout = computed(
  () => `${currentRoute.value.meta.layout || defaultLayout}-layout`
)

//:key="$route.path.includes('/dashboard') ? '/dashboard' : $route.path"

</script>

<template>
  <component :is="layout">
    <router-view v-slot="{Component}">
        <component :is="Component" ></component>
      </router-view>

  </component>
</template>

