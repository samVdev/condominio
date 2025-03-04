<script setup lang="ts">
import HeaderLanding from '@/layouts/HeaderLanding.vue';
import Benefits from '@/layouts/landing/benefits.vue';
import Characteristics from '@/layouts/landing/characteristics.vue';
import Footer from '@/layouts/landing/footer.vue';

// Secciones
import Index from '@/layouts/landing/index.vue';

</script>

<template>
   <section class="w-full">
      <HeaderLanding />
      <main class="pt-[10vh] 2xl:pt-[9vh]">
         <Index />

         <section class="bg-[#ea5165] min-h-[30vh] px-2 py-10 pt-14 text-center">
            <h3 class="font-extrabold text-3xl md:text-5xl text-white">Bienvenido a Condominio Yutaje</h3>
            <p class="mt-4 font-medium text-lg md:text-xl md:font-semibold text-white">Simplifica la administración del condominio con una plataforma que conecta residentes y administradores.</p>
            <router-link to="/login" class="bg-white text-[#ea5165] mt-10 block w-[80%] font-bold py-4 px-6 rounded-2xl transition duration-200 mx-auto  md:hover:w-[25%] md:w-[30%]">Iniciar Sesión</router-link>
         </section>

         <Characteristics/>
         <Benefits/>
      </main>
      <Footer/>
   </section>
</template>