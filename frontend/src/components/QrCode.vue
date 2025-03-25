<script lang="ts" setup>
import QRCodeVue3 from 'qrcode-vue3';


const props = defineProps<{
  survey_name: string
}>();

const emit = defineEmits(
    ["closeModal"]
)

const url = location.origin
</script>

<template>
  <section
    v-if="survey_name"
    class="fixed inset-0 grid place-items-center bg-[#EA51650009a] z-[1000] "
  >
    <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center cursor-default relative">
      <button @click="$emit('closeModal')" class="absolute top-5 right-5 font-semibold text-2xl cursor-pointer z-[2000]">x</button>

      <h2 class="text-2xl font-bold mb-4">
        Escanea el código QR
      </h2>
      <div class="w-[250px] p-5 mx-auto">
        <QRCodeVue3
          :value="`${url}/${survey_name}`"
          :backgroundOptions="{ color: '#ffffff' }"
          :cornersSquareOptions="{ type: 'extra-rounded', color: '#EA5165000' }"
          :cornersDotOptions="{ type: 'extra-rounded', color: '#EA5165000' }"
          :dotsOptions="{type: 'rounded', color: '#EA5165000'}"
          downloadButton="bg-[#EA5165] block text-white mx-auto my-4 font-semibold py-2 px-4 rounded-md hover:bg-[#E65729] transition duration-200"
           fileExt="png"
          :download="true"
          :downloadOptions="{ name: 'miqrcode', extension: 'png' }"
        />
      </div>
      <router-link 
      class="text-blue-700 text-center my-10"
      :to="{name: 'FormOpinion', params: {suveyName: survey_name}}"
      >{{ `${url}/${survey_name}` }}</router-link>

      <router-link 
      class="text-blue-700 text-center my-2"
      :to="{name: 'LoginStatisc', params: {survey: survey_name}}"
      >{{ `${url}/statics/auth/${survey_name}` }}</router-link>

      <p class="text-gray-700">
        Usa tu dispositivo móvil para escanear el código QR y obtener más información.
      </p>
    </div>
  </section>
</template>
