<script lang="ts" setup>
import { ref } from 'vue';
import Loader from '@/components/Loader.vue';

const descripcion = ref('')

const props = defineProps<{
    sending: boolean
}>()

</script>

<template>
    <section class="overlay grid place-items-center w-full bg-[#000000ab]">
        <form @submit.prevent="$emit('submit', descripcion)"
            class="relative bg-white p-10 w-full md:w-[40%] gap-4 border shadow-lg sm:rounded-lg">

            <label class="absolute top-3 right-5 cursor-pointer text-2xl" @click="$emit('close')">×</label>
            <h5 class="font-semibold tracking-tight text-xl mb-5">Culminar junta</h5>

            <div class="w-full">
                <div class="mt-4">
                    <label
                        class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm block my-4 font-medium"
                        for="descripcion">
                        Descripción (Opcional)
                    </label>
                    <textarea
                        class="flex h-20 resize-none w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm transition-all-200"
                        id="descripcion" name="descripcion" v-model="descripcion"
                        placeholder="Agregar detalles de la junta"></textarea>
                </div>
            </div>
            <div class="items-center flex justify-end gap-2 my-3 capitalize col-span-2">
                <button v-if="!sending"
                    class="inline-flex items-center bg-blue-500 text-white justify-center gap-2 text-sm font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input h-10 rounded-xl px-4 transition-all hover:bg-blue-700">
                    Culminar
                    <font-awesome-icon icon="check" />
                </button>

                <Loader v-else class="mx-auto" />
            </div>
        </form>
    </section>
</template>