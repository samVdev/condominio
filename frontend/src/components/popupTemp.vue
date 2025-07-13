<script lang="ts" setup>
const props = defineProps<{
    countdown: number,
    selected: string
}>()
</script>

<template>
    <section class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50">
        <div
            class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full transform transition-all scale-95 opacity-0 animate-modal-fade">
            
            <h3 class="text-2xl font-bold text-gray-800 mb-4">
                ¿Quieres cancelar el envío?
            </h3>
            
            <p class="text-gray-600 mb-6">
                Tu respuesta se enviará automáticamente en 
                <span class="font-semibold text-primary">{{ countdown }}</span> segundos.
            </p>

            <div class="mb-4 p-3 bg-gray-100 rounded-lg">
                <p class="text-sm text-gray-500">Selección actual:</p>
                <p class="font-bold text-gray-800">{{ selected || 'Ninguna selección' }}</p>
            </div>
            
            <div class="flex justify-end gap-3">
                <button 
                    @click="$emit('cancelSubmission')"
                    class="px-5 py-2 rounded-lg bg-red-500 text-white font-medium transition">
                    Cancelar envío
                </button>
            </div>
        </div>
    </section>
</template>

<style scoped>
@keyframes modal-fade {
    0% {
        opacity: 0;
        transform: scale(0.95);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-modal-fade {
    animation: modal-fade 0.3s ease-out forwards;
}

.text-primary {
    @apply text-blue-600;
}

.bg-primary {
    @apply bg-blue-600 hover:bg-blue-700;
}
</style>