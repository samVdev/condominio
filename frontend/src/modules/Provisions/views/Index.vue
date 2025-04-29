<script lang="ts" setup>
import CardDash from '@/modules/Auth/components/cardDash.vue'
import IndexProvision from '../components/Index.vue'
import useFunds from '../composables/useFunds'
import { onMounted } from 'vue'

const checkID = (e) => {
  if (e && e.id) return e.id
  return ''
}

const {
  funds,
  provisions,
  getFunds,
  getFundsDetails,
} = useFunds()

onMounted(() => {
  getFunds()
})

</script>

<template>

  <main>
    <router-view v-slot="{ Component }">
      <Transition name="expandModal" :style="{ '--modal-top': `50%`, '--modal-left': `50%` }">
        <div v-if="$route.path.includes('/provisions/form')" class="overlay w-full bg-[#000000ab]">
          <component :is="Component" :key="$route.path" />
        </div>
      </Transition>
    </router-view>

    <div v-if="provisions.offset > 0" class="grid place-items-center overlay w-full bg-[#000000ab]">
      <article class="relative bg-white p-20 rounded-xl overflow-auto h-full w-full md:w-[50%] md:h-[80%] ">
        <label class="absolute top-3 right-5 cursor-pointer text-3xl" @click="() => provisions.offset = 0">x</label>
        <h3 class="text-2xl font-bold text-gray-600 mb-10 text-center">Provisiones: (<small class="">{{ funds.total
        }}$</small>)</h3>

        <ul class="text-gray-700 capitalize" v-for="prov in provisions.rows">
          <hr class="h-[1vh] ">
          <li class="flex gap-2 justify-between items-center my-5 px-2 ">
            <p>{{ prov.name }} </p>
            <p class="font-bold">{{ prov.total }}$</p>
          </li>
          <hr class="h-[1vh] ">
        </ul>

        <ul class="text-gray-700 capitalize absolute w-[85%] bottom-5">
          <hr class="h-[1vh] ">
          <li class="flex gap-2 justify-between items-center my-5 px-2 ">
            <p>Total </p>
            <p class="font-bold">{{funds.total}}$</p>
          </li>
          <hr class="h-[1vh] ">
        </ul>

      </article>
    </div>

    <section class="mx-auto md:w-[90%]">
      <section class="grid grid-cols-1 gap-5 px-2 pb-10 mx-auto md:px-5 md:grid-cols-2">
        <CardDash :redirect="false" icon="hand-holding-dollar" :value="`${funds.month}$`" label="Este mes" />
        <CardDash :redirect="true" icon="sack-dollar" :value="`${funds.total}$`" @redirect="() => getFundsDetails()"
          label="Total de provisiones" />
      </section>

      <IndexProvision to="/provisions" :activeCreate="true" @getFunds="getFunds"
        @form="(e: any) => $router.push(`/provisions/form/${checkID(e)}`)"></IndexProvision>
    </section>

  </main>
</template>