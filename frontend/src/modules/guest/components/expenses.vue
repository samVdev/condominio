<script lang="ts" setup>
import { parsePrices } from '@/utils/parsePrices';
import { onMounted, ref } from 'vue';
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

const url = import.meta.env.VITE_APP_API_URL
const viewImage = ref('')

</script>


<template>
    <article class="bg-white relative mx-auto overflow-hidden animate-fade-in w-full h-[100vh] md:px-10">

        <div v-if="viewImage" class="overlay w-full grid place-items-center bg-[#000000ab] cursor-pointer"
            @click="viewImage = ''">
            <img class="w-[100%] md:h-[50%] md:w-auto cursor-default" :src="`${viewImage}`" alt="imagen" @click.stop>
        </div>

        <div class="overflow-auto w-full h-[80%] md:h-[60%]">
            <div class="fakeTable h-full" @scroll="loadScroll">
                <article class="fakeTable-head grid-cols-5">
                    <p>Fecha</p>
                    <p>Gasto</p>
                    <p>Monto ($)</p>
                    <p>Monto (Bs.)</p>
                    <p>Factura</p>
                </article>

                <section v-if="data.rows.length > 0">
                    <div v-for="row in data.rows" :key="row.id" class="fakeTable-body grid-cols-5">
                        <p>{{ row.created }}</p>
                        <p>{{ row.name }}</p>
                        <p>{{ parsePrices(row.mount_dollars).dol }}</p>
                        <p>{{ parsePrices(row.mount_bs).bs }}</p>
                        <p>
                            <img class="h-16 transition-all cursor-pointer hover:scale-[.8]"
                                :src="`${url}/${row.image}`" alt="factura"
                                @click="() => viewImage = `${url}/${row.image}`" v-if="row.image">
                        </p>
                    </div>
                </section>

                <div class="FadeTR" v-else>
                    <Loader v-if="!loaded" class="mx-auto mt-5" />
                    <NotRecords v-else />
                </div>

            </div>
        </div>

    </article>
</template>