<script lang="ts" setup>
import IndexProvision from '../components/Index.vue'
</script>

<template>
  <main class="w-full py-10 relative">
  <label class="fixed top-3 right-5 cursor-pointer text-black text-3xl" @click="$router.push('/dashboard')">x</label>
  <IndexProvision :activeCreate="false" :toUserProvisions="true"></IndexProvision>
</main>
</template>