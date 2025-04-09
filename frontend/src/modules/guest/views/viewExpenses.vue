<script lang="ts" setup>
import { parsePrices } from '@/utils/parsePrices';
import { onMounted } from 'vue';
import useExpensesFacture from '../composable/useExpensesFacture';
import Loader from "@/components/Loader.vue";
import NotRecords from "@/components/notRecords.vue";


const {
    data,
    loaded,
    getExpenses,
    loadScroll
} = useExpensesFacture()


onMounted(() => {
    getExpenses()
})

</script>


<template>
    <article
        class="bg-white relative mx-auto overflow-hidden animate-fade-in rounded-2xl w-full h-[100vh] md:px-10 md:my-4 md:w-[90%] md:h-[80vh] 2xl:w-[50%] 2xl:h-[60vh]">
        <label class="absolute top-3 right-5 cursor-pointer text-black text-3xl z-[100]" @click="$router.push('/home')">x</label>

        <div class="px-20 text-center mt-10">
            <h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-3xl">Factura
                #{{ $route.query.facture }}</h2>
            <hr class="w-48 h-1 mx-auto my-4 bg-[#00000042] border-0 rounded-sm md:my-10 dark:bg-gray-700" />
        </div>

      <div class="overflow-auto w-full h-[80%] md:h-[60%]">
        <div class="fakeTable h-full" @scroll="loadScroll">
            <article class="fakeTable-head grid-cols-4">
                <a to="#" class="cursor-pointer">Fecha</a>
                <a to="#" class="cursor-pointer">Gasto</a>
                <a to="#" class="cursor-pointer">Monto ($)</a>
                <a to="#" class="cursor-pointer">Monto (Bs.)</a>
            </article>

            <section v-if="data.rows.length > 0">
                <div v-for="row in data.rows" :key="row.id" class="fakeTable-body grid-cols-4">
                    <p>{{ row.created }}</p>
                    <p>{{ row.name }}</p>
                    <p>{{ parsePrices(row.mount_dollars).dol }}</p>
                    <p>{{ parsePrices(row.mount_bs).bs }}</p>
                </div>
            </section>

            <div class="FadeTR" v-else>
                <Loader v-if="!loaded" class="mx-auto mt-5" />
                <NotRecords v-else/>
            </div>

        </div>
      </div>

    </article>
</template>