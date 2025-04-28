<script lang="ts" setup>
import CardDash from '@/modules/Auth/components/cardDash.vue'
import IndexEarning from '../components/Index.vue'
import { onMounted } from 'vue'
import useFunds from '../composables/useFunds'
import { onBeforeRouteUpdate } from 'vue-router'

const checkID = (e) => {
  if (e && e.id) return e.id
  return ''
}

const {
  funds,
  getFunds,
} = useFunds()


onMounted(() => {
  getFunds()
})


onBeforeRouteUpdate(async (to, from) => {
    if (to.query !== from.query && (to.name == 'earnings')) {
      await getFunds()
    }
  })


</script>

<template>

  <main>
    <router-view v-slot="{ Component }">
      <Transition name="expandModal" :style="{ '--modal-top': `50%`, '--modal-left': `50%` }">
        <div v-if="$route.path.includes('/earnings/form')" class="overlay w-full bg-[#000000ab]">
          <component :is="Component" :key="$route.path" />
        </div>
      </Transition>
    </router-view>


    <nav class="w-full flex items-center justify-end px-10 gap-2 md:gap-20">
      <router-link :to="{ path: '/typeEarnings'}"
        class="font-bold w-full mb-5 gap-2 h-[50px] rounded-2xl px-4 flex place-items-center transition-all bg-blue-600 text-white hover:bg-blue-500 border-[1px] md:w-[20%]">
        <p class="mx-auto">Tipos de ingresos</p>
      </router-link>
    </nav>

    <section class="mx-auto md:w-[90%]">
      <section class="grid grid-cols-1 gap-5 px-2 pb-10 mx-auto md:px-5 md:grid-cols-2">
        <CardDash :redirect="false" icon="sack-dollar" :value="`${funds.total}$`"label="Fondo de reserva" />
      </section>

      <IndexEarning to="/earnings" :activeCreate="true"
        @form="(e: any) => $router.push(`/earnings/form/${checkID(e)}`)"></IndexEarning>
    </section>

  </main>
</template>