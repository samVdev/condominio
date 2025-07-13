<script lang="ts" setup>
import { ref } from 'vue'
import { alertWithToast } from "@/utils/toast"
import { useRoute } from "vue-router"
import Http from "@/utils/Http";
import Loader from '@/components/Loader.vue';
import PopupTemp from './popupTemp.vue';

const props = defineProps<{
  survey: any
}>()

const selected = ref(null)
const loading = ref(false)
const showCancelPopup = ref(false)
const countdown = ref(10)
let countdownInterval: number | null = null
let submissionTimeout: number | null = null

const route = useRoute()
const uuidParams = route.params.uuid as string

const emit = defineEmits(['close', 'getData'])

const startCountdown = () => {
  showCancelPopup.value = true
  countdown.value = 10
  
  countdownInterval = window.setInterval(() => {
    countdown.value--
    if (countdown.value <= 0) {
      clearCountdown()
      submitResponse()
    }
  }, 1000)
}

const clearCountdown = () => {
  if (countdownInterval) {
    clearInterval(countdownInterval)
    countdownInterval = null
  }
}

const cancelSubmission = () => {
  clearCountdown()
  showCancelPopup.value = false
}

const submitResponse = async () => {
  showCancelPopup.value = false
  if (loading.value) return
  loading.value = true
  
  try {
    const payload = {
      board: uuidParams,
      survey: props.survey.id,
      selected: selected.value
    }
    const response = await Http.post(`/api/boards/survey/new-response`, payload);
    alertWithToast(response.data.message, 'success')
    emit('close')
    emit('getData')
  } catch (error) {
    let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
    message = message.split('. (')[0]
    alertWithToast(message, 'error')
  } finally {
    loading.value = false
  }
}

const submit = () => {
  if (!selected.value) return
  startCountdown()
}
</script>

<template>
  <section class="overlay grid place-items-center w-full bg-[#000000ab]">
    <div class="bg-white rounded-xl shadow p-6 w-full max-w-lg mx-auto relative">
      <label class="absolute top-3 right-5 cursor-pointer text-2xl" @click="$emit('close')">×</label>

      <h2 class="text-lg font-semibold text-gray-800 mb-4">
        {{ survey.question }}
      </h2>
  
      <div class="space-y-3 mb-6">
        <label
          v-for="option in survey.options"
          :key="option.label"
          class="flex items-center gap-3 cursor-pointer text-gray-700 hover:text-gray-900"
        >
          <input
            type="radio"
            name="option"
            :value="option.id"
            v-model="selected"
            class="accent-blue-500"
          />
          <span>{{ option.label }}</span>
        </label>
      </div>
  
      <button
        v-if="!loading"
        @click="submit"
        :disabled="!selected"
        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition"
      >
        Enviar respuesta
      </button>

      <Loader v-else />
      <PopupTemp v-if="showCancelPopup" :countdown="countdown" :selected="survey.options.find(e => e.id == selected).label" @cancelSubmission="cancelSubmission"/>

    </div>
  </section>
</template>