<script setup lang="ts">
import { computed } from "vue"
import { useRouter } from "vue-router"
import AOS from 'aos'
import { onMounted } from 'vue';

import 'aos/dist/aos.css'

const defaultLayout = "empty"
const { currentRoute } = useRouter()
const layout = computed(
  () => `${currentRoute.value.meta.layout || defaultLayout}-layout`
)

//:key="$route.path.includes('/dashboard') ? '/dashboard' : $route.path"

onMounted(() => {
  AOS.init({
    duration: 800,
    once: true,
  })
})

</script>

<template>
  <component :is="layout">
    <router-view v-slot="{Component}">
        <component :is="Component" ></component>
      </router-view>

  </component>
</template>

