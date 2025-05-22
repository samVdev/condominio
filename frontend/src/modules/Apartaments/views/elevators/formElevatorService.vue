<script lang="ts" setup>
import { onMounted } from 'vue';
import useIndex from '../../composables/apt/useIndex';
import { useRoute } from 'vue-router';
import useFormElevator from '../../composables/elevators/useFormElevator';

const {
    data,
    showElevator,
    submit
} = useFormElevator()

const {
    getTowers,
    towers
} = useIndex()

const route = useRoute()

const id = route.params.id as string || ''

const loadInfo = async () => {
    if (id) {
        await showElevator(id)
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
        <slot/>
        <h5 class="col-span-2 font-semibold tracking-tight text-xl">{{ id ? 'Editar' : 'Crear' }} ascensor</h5>
        <div class="grid mb-8 gap-4 lg:grid-cols-2">

            <div class="">
                <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm block my-4 font-medium"
                    for="number">Número</label>
                <input
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm transition-all-200"
                    id="number" name="number" v-model="data.number" placeholder="Ingresa el nombre del servicio">
            </div>

            <div class="">
                <label for="ascensor" class="block my-4 text-sm font-medium text-gray-700">Torre:</label>
                <select id="ascensor" required name="ascensor" v-model="data.tower" v-if="towers.length > 0"
                    class="p-3 w-full">
                    <option value="-1" disabled selected>Selecciona una torre</option>
                    <option :value="tower.id" v-for="tower in towers">{{ tower.name }}</option>
                </select>
            </div>
        </div>
        <div class="items-center flex justify-end gap-2 my-3 capitalize">
            <button
                class="inline-flex items-center bg-blue-500 text-white justify-center gap-2 text-sm font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input h-10 rounded-xl px-4 transition-all hover:bg-blue-700">
                <font-awesome-icon icon="check" />
                Registrar
            </button>
        </div>
    </form>
</template>