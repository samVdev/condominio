<script lang="ts" setup>
import useFormBoards from '../composables/useFormBoards';
import { useRoute } from 'vue-router';
import { onMounted } from 'vue';
import Loader from '@/components/Loader.vue';


const {
    form,
    now,
    sending,
    showService,
    submit
} = useFormBoards()

const route = useRoute()

const id = route.params.id as string || ''

const loadInfo = async () => {
    if (id) {
        await showService(id)
        if (!form.value.uuid) return
    }
}

onMounted(() => {
    loadInfo()
})
</script>

<template>
<form @submit.prevent="submit"
    class="fixed bg-white left-[50%] top-[50%] z-50 p-10 w-full translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background shadow-lg duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 data-[state=open]:slide-in-from-top-[48%] sm:rounded-lg sm:max-w-[825px] overflow-hidden animate-fade-in">
    
    <label class="absolute top-3 right-5 cursor-pointer text-2xl" @click="$router.push('/boards')">×</label>
    <h5 class="font-semibold tracking-tight text-xl mb-5">{{ id ? 'Editar junta' : 'Crear junta' }}</h5>

    <article class="col-span-2 block gap-5 md:flex">
        <div class="w-full md:w-[50%]">
            <!-- Name Field -->
            <div>
                <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm block my-4 font-medium" for="nombre">
                    Nombre de la junta
                </label>
                <input
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm transition-all-200"
                    id="nombre" name="nombre" v-model="form.nombre" 
                    placeholder="Ej: Junta Anual 2024">
            </div>

            <div class="mt-4">
                <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm block my-4 font-medium" for="descripcion">
                    Descripción
                </label>
                <textarea
                    class="flex h-20 resize-none w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm transition-all-200"
                    id="descripcion" name="descripcion" v-model="form.descripcion"
                    placeholder="Detalles de la junta"></textarea>
            </div>
        </div>

        <div class="w-full md:w-[50%] md:pl-5">
            <div class="mt-4 md:mt-0">
                <label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm block my-4 font-medium" for="fecha">
                    Fecha de la junta
                </label>
                <input
                    type="datetime-local"
                    :min="now.toISOString().slice(0, 16)"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm transition-all-200"
                    id="fecha" name="fecha" v-model="form.fecha">
            </div>
        </div>
    </article>

    <div class="items-center flex justify-end gap-2 my-3 capitalize col-span-2">
        <button v-if="!sending"
            class="inline-flex items-center bg-blue-500 text-white justify-center gap-2 text-sm font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input h-10 rounded-xl px-4 transition-all hover:bg-blue-700">
            <font-awesome-icon icon="check" />
            {{ id ? 'Actualizar' : 'Registrar' }}
        </button>

        <Loader v-else class="mx-auto" />
    </div>
</form>
</template>