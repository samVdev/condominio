<script setup lang="ts">
import { useSidebar } from "@/composables/useSidebar";
import Header from "./Header.vue"
import Sidebar from "./Sidebar.vue"

const { isClose } = useSidebar()

</script>

<template>
  <div class="section bg-[#F1F5F9] w-full">
    <Sidebar />
      <main 
      :class="isClose ? 'md:pr-10' : ''"
      class="flex-1 overflow-x-hidden overflow-y-auto h-[100vh] transition duration-300">
          <Header />
          <div class="mt-[8vh]">
            <slot />
          </div>
      </main>
  </div>
</template>
