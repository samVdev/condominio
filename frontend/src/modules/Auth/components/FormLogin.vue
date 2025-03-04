<script setup lang="ts">
import InputPassword from "@/components/inputPassword.vue"
import { ref } from "vue"

defineProps({
  sending: Boolean
})
const emit = defineEmits(['submit'])
const email = ref(null)
const password = ref(null)
const submit = async () => {
  emit('submit', {
    email: email.value,
    password: password.value
  })
}
</script>

<template>
  <form @submit.prevent="submit" id="Login" class="block md:grid">
    <h1>Iniciar Sesión</h1>

    <div class="mb-6">
      <label class="block ">Correo Electrónico</label>
      <input type="email" name="email" v-model="email" autocomplete="email" placeholder="email@domain.ext"
        class="mb-2 h-[6vh] border-b-[1px] border-[#5759D4] w-full" />

    </div>
    <div class="my-6">
      <label class="block">Contraseña</label>
        <InputPassword v-model="password" name="password" placeholder="Ingresa la contraseña" 
        class="mt-0 h-[6vh] border-b-[1px] border-[#5759D4] w-full"/>
    </div>

    <div class="block my-6">

      <button id="buttonSubmit" class="block" type="submit" :isDisabled='sending' data-testid="submit-btn">
        {{ sending ? 'Iniciando sesión...' : 'Iniciar sesión' }}
      </button>
    </div>

  </form>
</template>

<style>
#Login {
  width: 80%;
  border-radius: 20px;
  padding: 10px;
  grid-template-rows: 40% 100px 100px 100px;
  z-index: 5;
  margin: 0 auto;
  font-family: -apple-system, BlinkMacSystemFont, sans-serif;
}

#Login {
  -webkit-animation: slide-in-right 0.45s ease-out both;
  animation: slide-in-right 0.45s ease-out both;
}

#Login h1 {
  font-size: 30px;
  padding-bottom: 10px;
  color: var(--BgMenu);
  text-align: center;
  margin-top: 10px;
  align-self: center;
}

#buttonSubmit {
  height: 45px;
  display: block;
  padding-left: 5px;
  padding-right: 5px;
  margin-bottom: 10%;
  margin-top: 10px;
  background-color: #5759D4;
  border-radius: 10px;
  border: none;
  width: 80%;
  color: white;
  cursor: pointer;
  margin: 0 auto 10% auto;
}
</style>
