<script lang="ts" setup>
import Loader from '@/components/Loader.vue';
import useFormExpense from '../composables/useFormFactures';
import { meses } from '@/utils/constantes/months';

const {
    data,
    sending,
    submit,
} = useFormExpense()

</script>


<template>
    <section class="relative h-full w-full grid place-items-center">
        <form @submit.prevent="submit" class="relative bg-white p-20 rounded-xl w-full md:w-[40%]">
            <label class="absolute top-3 right-5 cursor-pointer text-3xl" @click="$router.push('/factures')">x</label>

            <h3 class="text-2xl font-bold text-gray-600 mb-10">Nueva Factura</h3>

            <div class="grid lg:grid-cols-2 gap-4">

                <div class="mb-4">
                    <label for="created" class="block text-sm font-medium text-gray-700">Fecha:</label>
                    <input type="text" id="created" required name="created" disabled v-model="data.created"
                        class="mt-2 p-3 w-full">
                </div>

                <div class="mb-4">
                    <label for="month" class="block text-sm font-medium text-gray-700">Mes:</label>
                    <select id="month" required name="month" v-model="data.month"
                        class="mt-2 p-3 w-full">
                        <option value="" disabled selected>Selecciona un mes</option>
                        <option :value="index + 1" v-for="(mes, index) in meses">{{mes}}</option>
                    </select>
                </div>

                <div class="mb-4 col-start-1 col-end-3">
                    <label for="porcent" class="block text-sm font-medium text-gray-700">Porcentaje de descuento (primeros 5 dias):</label>
                  
                    <div class="flex justify-center items-center gap-2 mt-4 h-[8vh] !text-3xl 2xl:text-4xl">
                        <input type="text" id="porcent" max="10" placeholder="1.0" required name="porcent" v-model="data.porcent"
                        class="mt-2 h-[100%!important] block text-center md:w-[15%!important] border !text-3xl 2xl:text-4xl">
                        %
                    </div>
                </div>

            </div>

            <div class="mt-4 px-2 border-gray-100 flex text-center justify-end space-x-2">
                <button v-if='!sending'
                    class="bg-[#EA5165] hover:bg-[#D54A5C] transition-all text-white font-bold w-full text-center mt-4 h-[40px] mx-auto grid place-items-center rounded-3xl md:w-[50%]">
                    Crear factura del mes
                </button>

                <Loader v-else class="mx-auto" />
            </div>
        </form>
    </section>
</template>