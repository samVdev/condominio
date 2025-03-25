<script lang="ts" setup>
import type { serviceType } from '../types/serviceType';


const props = defineProps<{
    data: serviceType
}>()
</script>

<template>
    <div
        class="fixed bg-white left-[50%] top-[50%] z-50 p-10 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background shadow-lg duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 data-[state=open]:slide-in-from-top-[48%] sm:rounded-lg sm:max-w-[425px] overflow-hidden animate-fade-in">
        <label class="absolute top-3 right-5 cursor-pointer text-2xl" @click="$emit('closeModal')">x</label>
        <h5 class="font-semibold tracking-tight text-xl">Crear servicio</h5>
        <div class="">
            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm block my-4 font-medium"
                for="name">Nombre del servicio</label>
            <input
                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm transition-all-200"
                id="name" name="name" v-model="data.name" placeholder="Ingresa el nombre del servicio">
        </div>
        <div class="flex items-center justify-between">
            <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-medium"
                for="isToElevator">Es para un elevador</label>

            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" v-model="data.is_elevator" value="" class="sr-only peer">
                <div
                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                </div>
            </label>
        </div>

        <div class="items-center flex justify-end gap-2 my-3 capitalize">
           <button @click="$emit('closeModal')" class="inline-flex items-center justify-center gap-2  text-sm font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input h-10 rounded-xl px-4 transition-all hover:bg-blue-500 hover:text-white">
            <font-awesome-icon icon="xmark" />
            cancelar
        </button> 
           <button @click="$emit('submit')" class="inline-flex items-center bg-blue-500 text-white justify-center gap-2 text-sm font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input h-10 rounded-xl px-4 transition-all hover:bg-blue-700">
            <font-awesome-icon icon="check" />
            Registrar
        </button>
        </div>
    </div>
</template>