<script setup lang="ts">
import MiniTitle from '@/components/miniTitle.vue';



</script>

<template>
    <section id="benefits" class="bg-[#FFF] py-20 w-full justify-center items-center p-10 md:flex md:h-screen">

        <img src="/images/lan_benef.jfif" data-aos="fade-right" class="h-[100%] md:w-[50%] 2xl:w-[30%] rounded-3xl"
            alt="image of habi">

        <div class="my-2 mt-4 md:px-10 w-full md:w-[50%] 2xl:w-[40%]" data-aos="fade-left">
            <MiniTitle text="Beneficios para todos" class="text-center mx-auto md:mx-0 md:px-4 md:min-w-[40%]" />
            <h2 class="font-extrabold w-[100%] text-[#333C4A] mx-auto mt-5 text-2xl md:font-bold md:text-4xl 2xl:text-5xl">Mejorando
                la experiencia de vida en comunidad</h2>
            <p class="font-medium mt-4 text-md text-[#444a55] md:text-lg">Nuestro sistema no solo facilita la gestión
                para administradores, sino que mejora significativamente la calidad de vida de todos los residentes.</p>

            <ul class="mt-10">
                <li class="flex items-center gap-1 mt-4">
                    <div class="rounded-full p-2 px-3 scale-[.6] bg-[#FDEDEF] text-[#EC6173] font-semibold">
                        <font-awesome-icon icon="check" />
                    </div>
                    <p class="text-gray-700 text-lg">Reducción de hasta un 40% en tareas administrativas</p>
                </li>
                <li class="flex items-center gap-1 mt-4">
                    <div class="rounded-full p-2 px-3 scale-[.6] bg-[#FDEDEF] text-[#EC6173] font-semibold">
                        <font-awesome-icon icon="check" />
                    </div>
                    <p class="text-gray-700 text-lg">Transparencia total en la gestión de recursos comunitarios</p>
                </li>

                <li class="flex items-center gap-1 mt-4">
                    <div class="rounded-full p-2 px-3 scale-[.6] bg-[#FDEDEF] text-[#EC6173] font-semibold">
                        <font-awesome-icon icon="check" />
                    </div>
                    <p class="text-gray-700 text-lg">Acceso 24/7 a toda la información desde cualquier dispositivo</p>
                </li>

                <li class="flex items-center gap-1 mt-4">
                    <div class="rounded-full p-2 px-3 scale-[.6] bg-[#FDEDEF] text-[#EC6173] font-semibold">
                        <font-awesome-icon icon="check" />
                    </div>
                    <p class="text-gray-700 text-lg">Mejor resolución de incidencias y mantenimiento preventivo</p>
                </li>
            </ul>

            <router-link to="/login" class="bg-[#EA5165] hover:bg-[#D54A5C] transition-all text-white font-bold w-[70%] mx-auto md:mx-0 text-center h-[50px] mt-10 grid place-items-center rounded-3xl md:w-[40%]">
            <p>Iniciar Sesión</p>
        </router-link>
        </div>
    </section>
</template>