<script lang="ts" setup>
import CardFactureUser from './cardFactureUser.vue';

const props = defineProps<{
    factures: any,
    loadScroll: any
}>()

</script>

<template>
    <section class="overlay w-full bg-[#FFF] fade-in !p-0 md:p-20">
        <label @click="$emit('close')"
            class="absolute top-2 right-4 font-bold text-2xl cursor-pointer transition-all hover:scale-[1.2]">X</label>
        <h1 class="text-3xl font-semibold leading-loose text-gray-900 dark:text-white my-5 text-center">Tus facturas
        </h1>

        <div @scroll="loadScroll" class="my-4 flex flex-wrap justify-center gap-5 pb-10 px-10 mx-auto h-[80vh] overflow-auto md:px-10" v-if="factures.rows.length > 0">
            <CardFactureUser v-for="facture in factures.rows"
                @expenses="() => $router.push({ path: '/home/movements/expenses', query: { facture: facture.id } })"
                :facture="facture"
            />
        </div>
    </section>
</template>