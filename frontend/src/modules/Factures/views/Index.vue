<script lang="ts" setup>
import IndexFactures from '../components/Index.vue'

const checkID = (e) => {
  if (e && e.id) return e.id
  return '' 
}

</script>

<template>

<main>
  <router-view v-slot="{ Component }">
      <Transition name="expandModal" :style="{'--modal-top': `50%`,'--modal-left': `50%`}">
        <div v-if="$route.path.includes('/factures/form')" class="overlay w-full bg-[#000000ab]" >
          <component :is="Component" :key="$route.path"/>
        </div>
      </Transition>
    </router-view>

    <label v-if="$route.name != 'factures'" class="fixed top-3 right-5 cursor-pointer text-black text-3xl"
    @click="$router.push('/dashboard')">x</label>

    <section class="mx-auto md:w-[90%]">
      <IndexFactures to="/factures" :toUserExpenses="$route.name != 'factures'" :activeCreate="$route.name == 'factures'" @form="(e: any) => $router.push(`/factures/form/${checkID(e)}`) "/>
    </section>

    

</main>
</template>