<script setup lang="ts">
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";
import usePayments from "../composables/usePayments";
import { parseDate } from "@/utils/parseDate";

const {
    data,
    loaded,
    seeAllData,
    loading,
    setSearch,
    loadScroll,
    setSort,
    clearData,
    acceptOrDecline
} = usePayments()

</script>

<template>
    <div class="mt-10 w-full ">

        <tablesHeader title="Pagos" icon="file-invoice-dollar" :searchActive="true" @setSearch="({ e }) => setSearch(e)"
            :btnCreate="false" />

        <nav class="w-full grid grid-cols-2 px-10 gap-2 md:gap-20 md:px-[20vh]">
            <router-link :to="{ path: '/payments', query: { status: 'n' } }"
                class="font-bold w-full my-5 gap-2 h-[50px] rounded-2xl px-4 flex place-items-center transition-all border-[1px]"
                :class="$route.query.status == 'n' ? 'bg-blue-600 text-white hover:bg-blue-500' : 'text-blue-600 border-blue-600 hover:bg-blue-600 hover:text-white'">
                <p class="mx-auto">Pendientes</p>
            </router-link>
            <router-link :to="{ path: '/payments', query: { status: 'a' } }"
                class="font-bold w-full my-5 gap-2 h-[50px] rounded-2xl px-4 flex place-items-center transition-all border-[1px]"
                :class="$route.query.status == 'a' ? 'bg-blue-600 text-white hover:bg-blue-500' : 'text-blue-600 border-blue-600 hover:bg-blue-600 hover:text-white'">
                <p class="mx-auto">Aceptados</p>
            </router-link>
        </nav>

        <section class="overlay w-full grid place-items-center bg-[#0808083a] fade-in !p-0 md:p-20 cursor-pointer"
            v-if="seeAllData.factura" @click="clearData">
            <article
                class="relative w-full bg-white p-20 rounded-2xl shadow-2xl h-full cursor-default md:w-auto md:h-auto"
                @click.stop>

                <p class="absolute top-5 right-5 cursor-pointer text-xl font-bold" @click="clearData">X</p>
                <h4 class="font-bold text-xl mb-5">Recibo de la factura -
                    <router-link class="transition-all text-[#E2384F] hover:text-black"
                        :to="{ path: '/expenses', query: { facture: seeAllData.factura, back: '/factures' } }">
                        #{{ seeAllData.factura }}
                        <font-awesome-icon icon="fa-regular fa-eye" />
                    </router-link>
                </h4>
                <ul class="text-gray-700 capitalize">
                    <li class="my-5">{{ parseDate(seeAllData.date) }}</li>
                    <hr class="h-[1vh] ">
                    <li class="flex gap-2 justify-between items-center my-5 px-2 ">
                        <p>{{ seeAllData.nombre }} </p>
                        <p>{{ seeAllData.phone }}</p>
                    </li>
                    <hr class="h-[1vh] ">
                    <li class="flex gap-2 justify-between items-center my-5 px-2 ">
                        <p>C.I: {{ seeAllData.cedula }} </p>
                        <p>Ref (6): {{ seeAllData.referencia }}</p>
                    </li>
                    <hr class="h-[1vh] ">

                    <li class="flex gap-2 justify-between items-center my-5 px-2">
                        <p class="text-2xl font-bold">Bs. {{ seeAllData.dolarBCV.toFixed(2) }}</p>
                        <p class="text-2xl font-bold">${{ seeAllData.payment }}</p>
                    </li>
                </ul>

                <hr class="h-[1vh] ">

                <ul class="text-gray-700 capitalize">
                    <li class="my-2 flex gap-2 items-center justify-center">
                        <p>con Mora (+5%)</p>
                        <font-awesome-icon :icon="seeAllData.mora ? 'check' : 'xmark'" class="ml-2"
                            :class="seeAllData.mora ? 'text-green-500' : 'text-red-500'" />
                    </li>
                    <li class="my-2 flex gap-2 items-center justify-center">
                        <p>Pagado los primeros dias {{ seeAllData.days && `(-${seeAllData.porcent}%)` }}</p>
                        <font-awesome-icon :icon="seeAllData.days ? 'check' : 'xmark'" class="ml-2"
                            :class="seeAllData.days ? 'text-green-500' : 'text-red-500'" />
                    </li>
                </ul>

                <div v-if="!seeAllData.accepted">
                    <div class="flex items-center justify-center gap-5 mt-5" v-if="!loading">
                        <button @click="() => acceptOrDecline(false)"
                            class="inline-flex capitalize border-[#e2384f] items-center justify-center whitespace-nowrap text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input h-12 rounded-xl px-8 transition-all hover:bg-[#e2384f] hover:text-white text-[#e2384f]">
                            rechazar
                        </button>
                        <button @click="() => acceptOrDecline(true)"
                            class="inline-flex capitalize bg-[#e2384f] items-center justify-center whitespace-nowrap text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input h-12 rounded-xl px-8 transition-all hover:bg-red-500 text-white">
                            Aceptar
                        </button>
                    </div>
                    <Loader v-else />
                </div>

                <p v-else class="text-[#e2384f] text-center mt-5">
                    Ya fue aceptado este recibo por {{ seeAllData.user }}
                    <font-awesome-icon icon="check" class="ml-2" />
                </p>
            </article>
        </section>

        <section class="relative mx-auto w-full md:w-[90%] my-4 overflow-auto animate-fade-in">

            <div class="fakeTable md:w-[100%] md:px-10 mx-auto h-[65vh]" @scroll="loadScroll">
                <article class="fakeTable-head grid-cols-7">
                    <a to="#" class="cursor-pointer" @click.prevent="setSort('user')">
                        Propietario
                        <font-awesome-icon icon="sort" class="ml-2" />
                    </a>
                    <a to="#" class="cursor-pointer" @click.prevent="setSort('mora')">
                        Mora
                        <font-awesome-icon icon="sort" class="ml-2" />
                    </a>
                    <a to="#" class="cursor-pointer" @click.prevent="setSort('porcent')">
                        % primero dias
                        <font-awesome-icon icon="sort" class="ml-2" />
                    </a>
                    <a to="#" class="cursor-pointer" @click.prevent="setSort('cedu')">
                        Cédula
                        <font-awesome-icon icon="sort" class="ml-2" />
                    </a>
                    <a to="#" class="cursor-pointer" @click.prevent="setSort('ref')">
                        Referencia
                        <font-awesome-icon icon="sort" class="ml-2" />
                    </a>
                    <a to="#" class="cursor-pointer" @click.prevent="setSort('pay')">
                        Pagado
                        <font-awesome-icon icon="sort" class="ml-2" />
                    </a>
                    <p>Acción</p>
                </article>
                <section v-if="data.rows.length > 0">
                    <div v-for="row in data.rows" :key="row.recibe_id" class="grid-cols-7 fakeTable-body">
                        <p>{{ row.nombre }}</p>
                        <p>{{ row.mora ? 'Pagado con mora (+5%)' : 'No aplica' }}</p>
                        <p>{{ row.days ? `Pagado con un -${row.porcent > 0 ? row.porcent : row.porcent.toFixed(0)}%` :
                            'No aplica' }}</p>
                        <p>{{ row.cedula }}</p>
                        <p>{{ row.referencia }}</p>
                        <p>Bs. {{ row.dolarBCV.toFixed(2) }}</p>
                        <p>
                            <button @click="seeAllData = row"
                                class="inline-flex capitalize bg-[#e2384f] items-center justify-center whitespace-nowrap text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input h-12 rounded-xl px-4 transition-all hover:bg-red-500 text-white">
                                <font-awesome-icon icon="fa-regular fa-eye" />
                            </button>
                        </p>
                    </div>
                </section>
                <div class="FadeTR" v-if="data.rows.length === 0">
                    <Loader v-if="loaded" />
                    <p v-else>Usuarios no encontrados.</p>
                </div>
            </div>

        </section>

    </div>
</template>