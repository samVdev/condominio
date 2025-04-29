<script lang="ts" setup>

const props = defineProps<{
    name: string,
    is_elevator: boolean,
    created: string
}>()

</script>


<template>
    <article class="bg-white rounded-xl border bg-card text-card-foreground max-h-[200px] shadow-sm w-full overflow-hidden transition-all-300 hover:shadow-md animate-fade-in transition-all">
        <div class="flex justify-between items-center px-5 py-5">
            <h5 class="text-lg font-medium line-clamp-1">{{ name }}</h5>
            <div 
            :class="is_elevator ? 'hover:bg-orange-400 bg-orange-500' : 'hover:bg-blue-300 bg-blue-600'"
            class="inline-flex items-center gap-2 rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent text-white transition-all-200 ">
                <font-awesome-icon icon="elevator" v-if="is_elevator" />
                <p>{{ is_elevator ? 'Elevator' : 'Regular' }}</p>
            </div>
        </div>
        <p class="text-sm text-[#64748b] px-5 py-1">Creado: {{ created }}</p>
        <div class="items-center flex justify-end gap-2 px-5 py-5">
           <button @click="$emit('edit')" class="inline-flex bg-[#f8fafc] items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input h-9 rounded-md px-3 transition-all-200 hover:bg-blue-500 hover:text-white">
            <font-awesome-icon icon="pen-to-square" />
            Editar
        </button> 
           <button @click="$emit('delete')" class="inline-flex bg-[#f8fafc] items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input h-9 rounded-md px-3 transition-all-200 hover:bg-red-500 hover:text-white">
            <font-awesome-icon icon="trash-can" />
            Eliminar
        </button>
        </div>
    </article>
</template>