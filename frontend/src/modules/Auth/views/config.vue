<script lang="ts" setup>
import { onMounted } from 'vue';
import useConfig from '../composables/useConfig';

const {
    dolar,
    account,
    actualizando,
    getDolar,
    getInfo,
    submit
} = useConfig()

onMounted(() => {
    getInfo()
})
</script>

<template>
    <div class="p-0 xl:px-0">
        <div class="w-full mx-auto py-5 sm:px-5 lg:px-5 md:w-[80%]">
            <div class="flex gap-2 items-center text-xl mb-4 text-gray-800">
                <font-awesome-icon icon="gear" />
                <h1 class="font-bold">Configuración</h1>
            </div>

            <form @submit.prevent="submit" class="bg-white pt-5 pb-20 px-20 w-full shadow-lg rounded-xl">
                <h4 class="my-5 text-gray-400 text-xl">Datos Bancarios</h4>
                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                    <div class="w-full">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Completo</label>
                        <input v-model="account.titu" type="text" name="titu" id="titu"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Ingresa el nombre del titular" required>
                    </div>
                    <div class="w-full">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del banco</label>
                        <input v-model="account.banco" type="text" name="banco" id="banco"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Ingresa el nombre del titular" required>
                    </div>
                    <div class="w-full">
                        <label for="brand"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cédula</label>
                        <input type="text" v-model="account.cedu" name="cedu" id="cedu"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Ingresa la cédula del titular" required>
                    </div>
                    <div class="w-full">
                        <label for="price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nº cuenta</label>
                        <input type="tel" v-model="account.cuenta" name="cuenta" id="cuenta"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Ingresa el número de cuenta" required>
                    </div>
                    <div class="w-full">
                        <label for="price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Celular</label>
                        <input type="tel" v-model="account.cel" name="cel" id="cel" maxlength="15" minlength="8"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Ingresa el número de celular" required>
                    </div>
                </div>
                <button type="submit"
                    class="text-white block bg-[#EA5165] hover:bg-[#f3455c] focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Actualizar información
                </button>
            </form>

            <form @submit.prevent="getDolar"
                class="bg-white pt-5 pb-20 px-20 w-full shadow-lg rounded-xl mt-10">
                <h4 class="my-5 text-gray-400 text-xl">Dolar</h4>
                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                    <input type="tel" :value="dolar" name="tel" id="tel"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        disabled>
                </div>
                <button type="submit"
                    :disabled="actualizando"
                    class="text-white block bg-[#EA5165] transition-all hover:bg-[#f3455c] focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    {{!actualizando ? 'Actualizar dolar' : '...'}}
                </button>
            </form>
        </div>
    </div>
</template>