<script lang="ts" setup>
import { onMounted } from 'vue';
import useFormReport from '../../composables/elevators/useFormReport';
import { useRoute, useRouter } from "vue-router"
import { alertWithToast } from '@/utils/toast';
import UploadImg from '@/components/uploadImg.vue';


const route = useRoute()
const router = useRouter()
const idRoute = route.params.id
const type = route.query.type

const {
    reportElevator,
    form,
    id
} = useFormReport()


onMounted(() => {
    if (idRoute && type && (type == 'dañado' || type == 'operativo')) {
        id.value = idRoute as string
    } else {
        router.push('/condominium/elevators').then(() => {
            alertWithToast('Reporte incopatible', 'info')
        })
    }
})

</script>

<template>
    <form @submit.prevent="reportElevator" class="relative bg-white p-20 rounded-xl w-full md:w-[40%]">
        <label class="absolute top-3 right-5 cursor-pointer text-2xl"
            @click="$router.push('/condominium/elevators')">x</label>
        <h5 class="col-span-2 font-semibold tracking-tight text-xl">Reportar como ({{ type }})</h5>
        <div class="grid gap-4">

            <div class="">
                <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm block my-4 font-medium"
                    for="description">Descripción</label>
                <input
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm transition-all-200"
                    id="name" name="description" v-model="form.description" placeholder="Ingresa una descripción">
            </div>

            <div class="mb-4">
                <UploadImg :img="form.image" @setImg="({ imgURL }) => form.image = imgURL" />
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