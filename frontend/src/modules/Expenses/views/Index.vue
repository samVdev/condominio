<script lang="ts" setup>
import IndexExpense from '../components/Index.vue'

const checkID = (e) => {
  if (e && e.id) return e.id
  return '' 
}

</script>

<template>

<main>
  <router-view v-slot="{ Component }">
      <Transition name="expandModal" :style="{'--modal-top': `50%`,'--modal-left': `50%`}">
        <div v-if="$route.path.includes('/expenses/form')" class="overlay w-full bg-[#000000ab]" >
          <component :is="Component" :key="$route.path"/>
        </div>
      </Transition>
    </router-view>

    <section class="mx-auto md:w-[90%]">
      <IndexExpense to="/expenses" :activeCreate="true" @form="(e: any) => $router.push(`/expenses/form/${checkID(e)}`)"></IndexExpense>
    </section>

</main>
</template>