<script lang="ts" setup>

</script>

<template>
    <section class="bg-white relative mx-auto overflow-hidden animate-fade-in w-full h-[100vh] md:px-10">
        <label class="absolute top-3 right-5 cursor-pointer text-black text-3xl z-[100]"
            @click="$router.push('/home')">x</label>

        <div class="px-20 text-center mt-10">
            <h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-3xl">Factura
                #{{ $route.query.facture }}</h2>
            <hr class="w-48 h-1 mx-auto my-4 bg-[#00000042] border-0 rounded-sm md:my-10 dark:bg-gray-700" />
        </div>

        <nav class="w-full flex items-center justify-center gap-10">
            <router-link :to="{path: '/home/movements/expenses', query: {facture: $route.query.facture}}" active-class="bg-blue-600 text-white hover:bg-blue-500"
                class="font-bold w-full my-5 gap-2 h-[50px] rounded-2xl px-4 flex place-items-center transition-all border-[1px] text-blue-600 border-blue-600 hover:bg-blue-600 hover:text-white">
                <p class="mx-auto">Gastos</p>
            </router-link>
            <router-link :to="{path: '/home/movements/earnings', query: {facture: $route.query.facture}}" active-class="bg-blue-600 text-white hover:bg-blue-500"
                class="font-bold w-full my-5 gap-2 h-[50px] rounded-2xl px-4 flex place-items-center transition-all border-[1px] text-blue-600 border-blue-600 hover:bg-blue-600 hover:text-white">
                <p class="mx-auto">Ingresos</p>
            </router-link>
            <router-link :to="{path: '/home/movements/provisions', query: {facture: $route.query.facture}}" active-class="bg-blue-600 text-white hover:bg-blue-500"
                class="font-bold w-full my-5 gap-2 h-[50px] rounded-2xl px-4 flex place-items-center transition-all border-[1px] text-blue-600 border-blue-600 hover:bg-blue-600 hover:text-white">
                <p class="mx-auto">Provisiones</p>
            </router-link>
            
        </nav>

        <router-view></router-view>

    </section>
</template>