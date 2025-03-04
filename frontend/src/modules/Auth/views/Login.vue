<script setup lang="ts">
import FormLogin from "../components/FormLogin.vue";
import { useLogin } from '../composables/useLogin'

const { login, sending } = useLogin()
</script>

<template>
  <main id="cnt-Login" class="block md:grid relative h-screen py-10 overflow-auto z-[10] md:min-h-[100vh]">
    <article class="ContainerLogin block z-[12] w-[100%] h-auto grid-cols-2 md:grid md:w-[60vw] md:h-[80vh] md:m-[20px auto]">
      <div class="ImageLogin h-[40vh] rounded-r-2xl shadow-4xl md:h-[100%]"></div>
      <FormLogin class="pb-10 md:pb-0"
      @submit='login($event)' :sending='sending'/>
    </article>
    <div class="fixed bottom-0 z-[11]">
      <div class="wave"></div>
      <div class="wave"></div>
      <div class="wave"></div>
    </div>
  </main>
</template>


<style scoped>
#cnt-Login {
    width: 100%;
    align-items: center;
    justify-content: center;
    background-image: #D2E0E9;
    position: relative;
    grid-template-rows: 1fr;
    background-image: radial-gradient(circle at 85% 1%, hsla(0, 0%, 93%, 0.05) 0%, hsla(190,0%,93%,0.05) 96%,transparent 96%, transparent 100%),radial-gradient(circle at 14% 15%, hsla(190,0%,93%,0.05) 0%, hsla(190,0%,93%,0.05) 1%,transparent 1%, transparent 100%),radial-gradient(circle at 60% 90%, hsla(190,0%,93%,0.05) 0%, hsla(190,0%,93%,0.05) 20%,transparent 20%, transparent 100%),radial-gradient(circle at 79% 7%, hsla(190,0%,93%,0.05) 0%, hsla(190,0%,93%,0.05) 78%,transparent 78%, transparent 100%),radial-gradient(circle at 55% 65%, hsla(190,0%,93%,0.05) 0%, hsla(190,0%,93%,0.05) 52%,transparent 52%, transparent 100%),linear-gradient(135deg, #EA5165,#EA5165);

}

.ContainerLogin {
    background-color: #fff;
    border-radius: 20px;
    box-shadow: 0px 0px 100px -6px rgba(0, 0, 0, 0.75);
    overflow: hidden;
}

.ImageLogin {
    background-image: url("/images/lan_benef.jfif");
    width: 100%;
    background-size: cover;
    -webkit-animation: slide-in-left 0.45s ease-out both;
    animation: slide-in-left 0.45s ease-out both;
}
</style>

