<script lang="ts" setup>
import IndexExpense from '../components/Index.vue'
</script>

<template>
  <main class="w-full py-10 relative">
  <label class="fixed top-3 right-5 cursor-pointer text-black text-3xl" @click="$router.push('/dashboard')">x</label>
  <IndexExpense :activeCreate="false" :toUserExpenses="true"></IndexExpense>
</main>
</template>