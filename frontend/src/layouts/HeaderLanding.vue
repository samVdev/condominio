<script setup lang="ts">
import { ref } from 'vue';
import { menuLanding } from '@/utils/constantes/menuLanding';

const isMenuOpen = ref(false);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};
</script>

<template>
    <header class="fixed top-0 w-full bg-white gap-3 flex items-center justify-between h-[10vh] border-b border-gray-200 px-4 md:px-10 lg:px-20 2xl:h-[9vh]">
        <a href="#Inicio" class="text-[#EA5165] hover:text-[#D54A5C] transition-all block duration-200 font-bold text-2xl py-2">
            Logo
        </a>

        <nav class="hidden md:flex items-center justify-end w-[80%] gap-12">
            <a v-for="item in menuLanding" :key="item.name" :href="item.to" class="text-[#EA5165] hover:text-[#D54A5C] transition-all block duration-200 font-medium text-lg py-2">
                {{ item.name }}
            </a>
        </nav>

            <router-link to="/login" class="hidden md:grid bg-[#EA5165] hover:bg-[#D54A5C] transition-all text-white font-bold w-full md:w-[15%] text-center h-[70%] place-items-center rounded-3xl 2xl:w-[10%] 2xl:h-[50%]">
                <p>Iniciar Sesión</p>
            </router-link>

        <div class="md:hidden flex items-center">
            <button @click="toggleMenu" class="text-[#EA5165] focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </header>

    <!-- Menú móvil desplegable -->
    <nav v-if="isMenuOpen" class="fixed top-0 left-0 w-full h-full bg-white z-50 flex flex-col items-center justify-center">
        <button @click="toggleMenu" class="absolute top-4 right-4 text-[#EA5165]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="flex flex-col items-center">
            <a v-for="item in menuLanding" @click="toggleMenu" :key="item.name" :href="item.to" class="text-[#EA5165] hover:text-[#D54A5C] transition-all block duration-200 font-normal text-xl py-2">
                {{ item.name }}
            </a>
            <router-link to="/login" class="bg-[#EA5165] hover:bg-[#D54A5C] transition-all text-white font-bold w-full text-center mt-4 h-[40px] grid place-items-center rounded-3xl">
                <p>Iniciar Sesión</p>
            </router-link>
        </div>
    </nav>
</template>