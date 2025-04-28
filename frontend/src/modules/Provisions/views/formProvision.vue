<script lang="ts" setup>
import Loader from '@/components/Loader.vue';
import useFormProvision from '../composables/useFormProvision';
import useIndex from "@/modules/Apartaments/composables/useIndex"
import indexService from "@/modules/Services/composables/useIndex"
import { onMounted } from 'vue';
import { useRoute } from 'vue-router';
import UploadImg from '@/components/uploadImg.vue';
import { meses } from '@/utils/constantes/months';

const {
    dolar,
    data,
    sending,
    submit,
    showProvision,
    getDollarBcv
} = useFormProvision()

const {
    getTowers,
    towers
} = useIndex()

const {
    loaded: loadedService,
    servicesMinium,
    getServicesToSelect
} = indexService()

const route = useRoute()

const id = route.params.id as string || ''


const loadInfo = async () => {
    if (id) {
        await showProvision(id)
        if (!data.value.id) return
    }

    await getTowers()
    await getServicesToSelect()
    await getDollarBcv()
}


const calcValue = (e: InputEvent) => {
    const inputValue = (e.target as HTMLInputElement);
    const name = inputValue.getAttribute('name')
    const value = parseFloat(inputValue.value)

    if (name == 'mount_bs') {
        if (!value) return data.value.mount_dollars = 0
        data.value.mount_dollars = parseFloat((value / dolar.value).toFixed(2))
    } else if (name == 'mount_dollars') {
        if (!value) return data.value.mount_bs = 0
        data.value.mount_bs = parseFloat((value * dolar.value).toFixed(2))
    }

};

const month = new Date().getMonth() + 1

onMounted(() => {
    loadInfo()
})

</script>


<template>
    <section class="relative h-full w-full grid place-items-center">
        <form @submit.prevent="submit" class="relative bg-white p-20 rounded-xl w-full md:w-[40%]">
            <label class="absolute top-3 right-5 cursor-pointer text-3xl" @click="$router.push('/provisions')">x</label>

            <h3 class="text-2xl font-bold text-gray-600">{{ data.id ? 'Modificar' : 'Registrar' }} una provisión</h3>
            <p class="my-5 mx-auto text-center font-bold">Dolar BCV: {{ dolar }}</p>
            <div class="grid lg:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="service" class="block text-sm font-medium text-gray-700">Servicio:</label>
                    <Loader v-if="!loadedService" />
                    <select id="service" required name="service" v-model="data.service"
                        v-else-if="servicesMinium.length > 0" class="mt-2 p-3 w-full">
                        <option value="" disabled selected>Selecciona un servicio</option>
                        <option :value="service.id" v-for="service in servicesMinium">{{ service.name }}</option>
                    </select>
                    <p v-else class="mt-2 py-3 text-gray-700 text-sm">No se encontraron servicios registrados.</p>
                </div>
                <!--div class="mb-4">
                    <label for="apartamento" class="block text-sm font-medium text-gray-700">Torre:</label>
                    <select id="apartamento" required name="apartamento" v-model="data.tower" v-if="towers.length > 0"
                        class="mt-2 p-3 w-full">
                        <option value="" disabled selected>Selecciona una torre</option>
                        <option :value="tower.id" v-for="tower in towers">{{ tower.Nombre }}</option>
                        <option value="0">Todas las torres</option>
                    </select>
                </div-->

                <div class="mb-4">
                    <label for="month" class="block text-sm font-medium text-gray-700">Mes:</label>
                    <select id="month" required name="month" v-model="data.month"
                        class="mt-2 p-3 w-full capitalize">
                        <option value="" disabled selected>Selecciona un mes</option>
                        <option :value="mes.number" v-for="mes in meses.filter(e => e.number > month)">{{mes.name}}</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Precio en Bs:</label>
                    <input type="text" id="mount_bs" required name="mount_bs" v-model="data.mount_bs" @input="calcValue"
                        class="mt-2 p-3 w-full">
                </div>


                <div class="mb-4">
                    <label for="mount_bs" class="block text-sm font-medium text-gray-700">Precio en divisas:</label>
                    <input type="text" id="mount_dollars" name="mount_dollars" v-model="data.mount_dollars"
                        @input="calcValue" class="mt-2 p-3 w-full">
                </div>

            </div>

            <div class="mt-4 px-2 border-gray-100 flex text-center justify-end space-x-2">
                <button v-if='!sending'
                    class="bg-[#EA5165] hover:bg-[#D54A5C] transition-all text-white font-bold w-full text-center mt-4 h-[40px] mx-auto grid place-items-center rounded-3xl md:w-[50%]">
                    Guardar
                </button>

                <Loader v-else class="mx-auto" />
            </div>
        </form>
    </section>
</template>