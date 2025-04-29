<script lang="ts" setup>
import { useAuthStore } from '@/modules/Auth/stores';
import type { factureUserType } from '../types/factureUserType';


const props = defineProps<{
    facture: factureUserType,
}>()

const store = useAuthStore()

</script>

<template>

    <article class="bg-white relative border rounded-2xl overflow-hidden h-[580px] shadow-lg w-[100%] md:w-[360px]">

        <div class="absolute h-[20%] bg-[#e2384f] rounded-b-[40%] z-[1] w-full">
        </div>

        <div class="px-6 py-8 z-[10] relative">

            <h1 class="font-bold text-2xl mb-10 text-center text-white">Condominio Yutaje</h1>

            <div class="flex justify-between mb-6 pt-4">
                <h1 class="text-lg font-bold">Factura</h1>
                <div class="text-gray-700">
                    <div>Fecha: {{ facture.created }}</div>
                    <div>Code: #{{ facture.id }}</div>
                </div>
            </div>
            <div class="mb-8" v-if="store.authUser">
                <h2 class="text-lg font-bold mb-4">Para:</h2>
                <div class="text-gray-700 mb-2">{{ store.authUser.name }}</div>
                <div class="text-gray-700">{{ store.authUser.email }}</div>
            </div>
            <hr class="w-[80%] h-1 mx-auto my-4 bg-gray-100 border-0 rounded-sm dark:bg-gray-700" />

            <div class="mb-8" v-if="store.authUser">
                <div class="text-gray-700 mb-2 flex justify-between items-center">
                    <p>Total Condominio:</p>
                    <p>{{ facture.mount_dollars }}$</p>
                </div>
                <div class="text-gray-700 mb-2 flex justify-between items-center" v-if="facture.porcent">
                    <p>% Primeros dias:</p>
                    <p>{{ facture.porcent }}%</p>
                </div>

                <div class="text-red-700 mb-2 flex justify-between items-center" v-if="facture.isForMora">
                    <p>% Mora:</p>
                    <p>+5%</p>
                </div>

                <div class="text-gray-700 mb-2 flex justify-between items-center">
                    <p>% Alicuota:</p>
                    <p>{{ facture.alicuot }}%</p>
                </div>

                <h2 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 text-center md:text-3xl">{{ facture.total.toFixed(2) }}$</h2>
            </div>

            <div class="items-center flex gap-2 justify-between">
                <span v-if="facture.payment"  class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full" 
                :class="facture.payment == 'accepted' ? 'bg-green-100 text-green-800 ' : 'bg-orange-100 text-orange-800 '">
                <span class="w-2 h-2 me-1 rounded-full" :class="facture.payment == 'accepted' ? 'bg-green-500' : 'bg-orange-500'"></span>
                {{facture.payment == 'accepted' ? 'Aceptado' : 'Pendiente'}}
            </span>
                <button @click="$emit('expenses')"
                    class="inline-flex bg-[#b3b3b3] items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input h-12 rounded-xl px-8 transition-all-200 hover:bg-[#a3a3a3] text-white">
                    <font-awesome-icon icon="list-check" />
                    Movimientos
                </button>
                <button @click="$emit('pay')" v-if="!facture.payment"
                    class="inline-flex bg-[#e2384f] items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input h-12 rounded-xl px-8 transition-all-200 hover:bg-red-500 text-white">
                    <font-awesome-icon icon="trash-can" />
                    Pagar
                </button>
            </div>
        </div>
    </article>

</template>
