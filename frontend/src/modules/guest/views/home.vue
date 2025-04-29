<script lang="ts" setup>
import CardDash from '@/modules/Auth/components/cardDash.vue';
import { onMounted } from 'vue';
import useFacturesUser from '@/modules/guest/composable/useFacturesUser';
import CardFactureUser from '../components/cardFactureUser.vue';
import PayFacture from '../components/payFacture.vue';
import AllFactures from '../components/AllFactures.vue';
import NoInfo from '@/components/noInfo.vue';

const {
    factures,
    counted,
    factureToPay,
    facturesPending,
    seeAllFactures,
    getFacturesPending,
    getFacturesCompleted,
    getCounted,
    cleanFacture,
    submitPay,
    loadScroll
} = useFacturesUser()

onMounted(() => {
    getFacturesPending()
    getFacturesCompleted()
    getCounted()
})

</script>


<template>
    <main>
        <div class="grid grid-cols-1 px-2 gap-5 mx-auto md:px-10 md:grid-cols-3 md:w-[90%] 2xl:w-[80%]">
            <CardDash :redirect="false" icon="triangle-exclamation" :value="String(counted.pending)"
                label="Facturas Pendientes" />
            <CardDash :redirect="false" icon="coins" :value="String(counted.payment)" label="Facturas Pagadas" />
            <CardDash :redirect="false" icon="receipt" :value="String(counted.total)" label="Facturas Totales" />
        </div>

        <AllFactures :loadScroll="loadScroll" :factures="factures" v-if="seeAllFactures" @close="seeAllFactures = false"/>

        <router-view v-slot="{ Component }">
            <Transition name="expandModal" :style="{ '--modal-top': `50%`, '--modal-left': `50%` }">
                <div v-if="$route.path.includes('/movements/')"
                    class="overlay w-full grid place-items-center bg-[#0808083a] z-[1000] !p-0 md:p-20 cursor-pointer"
                    @click="$router.push('/home')">
                    <component :is="Component" :key="$route.path" class="cursor-default" :facture="'sakjdaksdasj'" @click.stop/>
                </div>
            </Transition>
        </router-view>

        <section class="overlay w-full grid place-items-center bg-[#0808083a] fade-in !p-0 md:p-20 cursor-pointer" v-if="factureToPay.id" @click="cleanFacture">
            <PayFacture :facture="factureToPay" @paying="({data}) => submitPay(data) " @click.stop/>
        </section>
        

        <section class="bg-white border rounded-2xl my-10 mx-auto relative min-h-[60vh] md:w-[90%] md:min-h-[80vh] 2xl:w-[80%] 2xl:min-h-[60vh]">
            <div class="px-20 text-center mt-10">
                <h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl">Facturas
                    Pendientes</h2>
                <hr class="w-48 h-1 mx-auto my-4 bg-[#69555542] border-0 rounded-sm md:my-10 dark:bg-gray-700" />
            </div>
            <div class="my-4 flex flex-wrap justify-center gap-5 pb-10 mx-auto relative md:px-10" v-if="facturesPending.length > 0">
                <CardFactureUser v-for="facture in facturesPending"
                    @expenses="() => $router.push({ path: '/home/movements/expenses', query: { facture: facture.id } })"
                    @pay="() => factureToPay = facture"

                    :facture="facture" />
            </div>

            <div class="w-full absolute h-full top-[50%] translate-y-[-50%]" v-else>
                <NoInfo icon="receipt" title="No se han encontrado facturas"/>
            </div>

        </section>

        <section class="bg-white relative border rounded-2xl my-10 mx-auto pb-10 min-h-[60vh] md:w-[90%] md:min-h-[80vh] 2xl:w-[80%] 2xl:min-h-[60vh]">
            <div class="px-20 text-center mt-10">
                <h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl">Facturas
                    Pagadas</h2>
                <hr class="w-48 h-1 mx-auto my-4 bg-[#00000042] border-0 rounded-sm md:my-10 dark:bg-gray-700" />
            </div>

            <div class="my-4 flex flex-wrap justify-center gap-5 px-10 pb-10 mx-auto overflow-auto md:px-10 h-[50vh] md:h-auto" v-if="factures.rows.length > 0">
                <CardFactureUser v-for="facture in factures.rows.slice(0, 3)"
                    @expenses="() => $router.push({ path: '/home/movements/expenses', query: { facture: facture.id } })"
                    @pay="() => factureToPay = facture"
                    :facture="facture" />
            </div>

            <div class="w-full absolute h-full top-[50%] translate-y-[-50%]" v-else>
                <NoInfo icon="receipt" title="No se han encontrado facturas"/>
            </div>


            <button
                @click="seeAllFactures = true"
                class="border-[1px] left-0 right-0 block text-center absolute border-[#EC6173] bottom-4 rounded-2xl py-2 bg-[#FDEDEF] text-[#EC6173] font-semibold mx-auto w-[80%] md:w-[20%]">
                Ver más</button>
        </section>

    </main>
</template>