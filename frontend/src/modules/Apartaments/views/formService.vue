<script lang="ts" setup>
import { onMounted } from 'vue';
import useFormCondominium from '../composables/useFormCondominium';
import useIndex from '../composables/useIndex';
import type { serviceType } from '../types/serviceType';
import { useRoute } from 'vue-router';

const {
    data,
    showApt,
    submit
} = useFormCondominium()


const {
    getTowers,
    towers
} = useIndex()

const route = useRoute()

const id = route.params.id as string || ''


const loadInfo = async () => {
    if (id) {
        await showApt(id)
        if (!data.value.id) return
    }
    await getTowers()
}


onMounted(() => {
    loadInfo()
})

</script>

<template>
    <form @submit.prevent="submit" class="relative bg-white p-20 rounded-xl w-full md:w-[40%]">
        <label class="absolute top-3 right-5 cursor-pointer text-2xl" @click="$router.push('/apartamentos')">x</label>
        <h5 class="col-span-2 font-semibold tracking-tight text-xl">Crear apartamento</h5>
        <div class="grid lg:grid-cols-2 gap-4">
            <div class="">
                <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm block my-4 font-medium"
                    for="name">Nombre</label>
                <input
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm transition-all-200"
                    id="name" name="name" v-model="data.name" placeholder="Ingresa el nombre del servicio">
            </div>

            <div class="">
                <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm block my-4 font-medium"
                    for="name">Tamaño</label>
                <input
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm transition-all-200"
                    id="name" name="name" v-model="data.sizes" placeholder="Ingresa el nombre del servicio">
            </div>

            <div class="mb-4">
                <label for="apartamento" class="block text-sm font-medium text-gray-700">Torre:</label>
                <select id="apartamento" required name="apartamento" v-model="data.tower" v-if="towers.length > 0"
                    class="mt-2 p-3 w-full">
                    <option value="-1" disabled selected>Selecciona una torre</option>
                    <option :value="tower.id" v-for="tower in towers">{{ tower.name }}</option>
                    <option value="0">Es una torre</option>
                </select>
            </div>


            <div class="mb-4 col-start-1 col-end-3">
                <label for="porcent" class="block text-sm font-medium text-gray-700">Porcentaje de alicuota:</label>

                <div class="flex justify-center items-center gap-2 mt-4 h-[8vh] !text-3xl 2xl:text-4xl">
                    <input type="text" id="porcent" max="10" placeholder="1.0" required name="porcent"
                        v-model="data.porcent"
                        class="mt-2 h-[100%!important] block text-center md:w-[15%!important] border !text-3xl 2xl:text-4xl">
                    %
                </div>
            </div>
        </div>
        <div class="items-center flex justify-end gap-2 my-3 capitalize">
            <button @click="$router.push('/apartamentos')" type="button"
                class="inline-flex items-center justify-center gap-2  text-sm font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input h-10 rounded-xl px-4 transition-all hover:bg-blue-500 hover:text-white">
                <font-awesome-icon icon="xmark" />
                cancelar
            </button>
            <button
                class="inline-flex items-center bg-blue-500 text-white justify-center gap-2 text-sm font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input h-10 rounded-xl px-4 transition-all hover:bg-blue-700">
                <font-awesome-icon icon="check" />
                Registrar
            </button>
        </div>
    </form>
</template>