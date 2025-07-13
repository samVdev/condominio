<script setup lang="ts">
import { ref } from 'vue'


const form = ref({
    question_text: '',
    options: ['']
})

const error = ref('')
const success = ref('')

const emit = defineEmits(['close', 'submit'])

const addOption = () => {
    form.value.options.push('')
}

const removeOption = (index: number) => {
    form.value.options.splice(index, 1)
}

const submitSurvey = async () => {
    error.value = ''
    success.value = ''

    const payload = {
        question_text: form.value.question_text,
        options: form.value.options.filter(o => o.trim() !== '')
    }

    if (payload.options.length < 2) {
        error.value = 'Debe haber al menos dos opciones.'
        return
    }

    emit('submit', payload)
}
</script>


<template>
    <section class="overlay grid place-items-center w-full bg-[#000000ab]">

        <div class="relative bg-white p-10 w-full md:w-[40%] gap-4 border shadow-lg sm:rounded-lg">
            <label class="absolute top-3 right-5 cursor-pointer text-2xl" @click="$emit('close')">×</label>

            <h2 class="text-xl font-bold">Crear Propuesta</h2>

            <div class="my-5">
                <label class="block text-sm font-medium mb-1">Pregunta</label>
                <input v-model="form.question_text" type="text" class="w-full border p-2 rounded" />
            </div>

            <div v-for="(option, index) in form.options" :key="index" class="flex gap-2 items-center mb-5">
                <input v-model="form.options[index]" type="text" class="flex-1 border p-2 rounded"
                    :placeholder="`Opción ${index + 1}`" />
                <button @click="removeOption(index)" class="text-red-600">🗑️</button>
            </div>

            <button @click="addOption" class="text-sm text-blue-600 mt-5">+ Agregar opción</button>

            <div>
                <button @click="submitSurvey" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Crear Encuesta
                </button>
            </div>

            <p v-if="error" class="text-red-600 text-sm mt-2">{{ error }}</p>
            <p v-if="success" class="text-green-600 text-sm mt-2">{{ success }}</p>
        </div>
    </section>
</template>
