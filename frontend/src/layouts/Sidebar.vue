<script setup lang="ts">
import { useAuthStore } from "@/modules/Auth/stores/index"
import { useSidebar } from "@/composables/useSidebar";
import Menu from "@/layouts/menu.vue";

const { isOpen, isClose } = useSidebar()
const store = useAuthStore()


</script>

<template>
  <aside class="flex" v-if="store.authUser">
    <!-- Backdrop -->
    <div
      :class="!isClose ? 'block' : 'hidden'"
      @click="isClose = true"
      class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"
    >
  </div>
    <!-- End Backdrop -->

    <!-- on Mobile -->

    <div
      :class="!isClose ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
      class="w-[40vw] fixed z-30 inset-y-0 left-0 transition duration-300 transform overflow-y-auto lg:static lg:inset-0 block lg:hidden"
    >
      <Menu @closeMenuAuto="(value) => isClose = value"/> 
    </div>

    <!-- on PC -->

    <div
      :class="!isClose ? 'translate-x-0 ease-out w-[30vw] md:w-[15vw] 2xl:w-[10vw]' : '-translate-x-1 ease-in w-full md:w-[5vw] 2xl:w-[4vw]'"
      class="fixed z-30 inset-y-0 left-0 transition duration-300 transform overflow-y-auto lg:static lg:inset-x-0 hidden md:block"
    >
      <Menu @closeMenuAuto="() => null"/> 
    </div>
  </aside>
</template>

