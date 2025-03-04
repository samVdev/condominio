<script lang="ts" setup>
import { ref } from 'vue';

const search = ref('')

const $emit = defineEmits(['search', 'setClientNPS'])


const submit = () => {
    $emit('search', {
        search: search.value
    })
}

</script>

<template>
            <div class="w-full flex justify-between items-center flex-col my-5 pt-2 px-5 gap-y-2 md:flex-row">

                        <select name="selectorRol" @change="(e: any) => $emit('setClientNPS', {filter: e.target.value})" class="pr-11 h-10 pl-3 py-2 border-slate-200 border-[1px] text-gray-500 rounded transition duration-200 ease ">
                            <option value="">Sin filtrar por cliente</option>
                            <option value="4">Detractores</option>
                            <option value="7">Neutrales</option>
                            <option value="10">Promotores</option>
                            <option value="publish">publicidad</option>
                        </select>

                        <form @submit.prevent="submit" class="relative">
                            <input
                                v-model="search"
                                class="bg-white w-full pr-11 h-10 pl-3 py-2 bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-200 ease focus:outline-none focus:border-slate-400 hover:border-slate-400"
                                placeholder="Buscar..." />
                            <button class="absolute h-8 w-8 right-1 top-1 my-auto px-2 flex items-center bg-white rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                    stroke="currentColor" class="w-8 h-8 text-slate-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                        </form>
            </div>
</template>