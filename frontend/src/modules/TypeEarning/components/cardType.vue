<script lang="ts" setup>

const props = defineProps<{
    name: string,
    created: string
}>()

</script>


<template>
    <article class="bg-white rounded-xl border bg-card text-card-foreground h-[180px] shadow-sm w-full overflow-hidden transition-all-300 hover:shadow-md animate-fade-in transition-all">
        <div class="flex justify-between items-center px-5 py-5">
            <h5 class="text-lg font-medium line-clamp-1">{{ name }}</h5>
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