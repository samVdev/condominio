<script setup lang="ts">
import { ref, computed} from "vue";
import { useAuthStore } from "@/modules/Auth/stores"
import { useSidebar } from "@/composables/useSidebar"
import Logout from "@/modules/Auth/components/Logout.vue"

const url = import.meta.env.VITE_APP_API_URL

const { isOpen, isClose } = useSidebar()
const dropdownOpen = ref(false)
const store = computed(() => useAuthStore())

</script>

<template>
  <header class="sticky w-[95%] top-[2vh] mx-auto rounded-2xl z-20 flex justify-between items-center p-5 border-b-1 bg-white text-[#EA5165] border border-gray-300 shadow-md">    
    <div class="flex items-center">
      <button
        @click="isClose = !isClose;"
        class="focus:outline-none block"
      >
        <svg
          class="h-6 w-6"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M4 6H20M4 12H20M4 18H11"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>
      </button>

    </div>

    <div class="flex items-center">
      <div class="relative">
        <button
          @click="dropdownOpen = !dropdownOpen"
          class="relative z-10 block h-8 w-8 rounded-full overflow-hidden focus:outline-none"
        >
          <img
            v-if="store.authUser && store.authUser.avatar"
            :src="`${url}/${store.authUser.avatar}`"
            class="w-10 h-10 rounded-full object-cover"
            alt=""
          />
          <svg v-else
            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
            aria-hidden="true" class="w-8 h-10 rounded-full"
          >
            <path
              d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z">
            </path>
          </svg>
        </button>

        <div
          v-show="dropdownOpen"
          @click="dropdownOpen = false"
          class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20 text-black"
        >

        

          <router-link
            to="/profile"
            class="block px-4 py-2 text-sm hover:bg-gray-400"
          >
            {{ store.authUser ? store.authUser.name : 'Profile' }}
          </router-link>

          <p
            class="block px-4 py-2 text-sm hover:bg-gray-400"
          >
            <Logout to="/login" text="Cerrar Sesión"/>
        </p> 
        </div>        
      </div>
    </div>    

  </header> 
</template>
