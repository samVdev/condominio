<script setup lang="ts">
import CardDash from '@/modules/Auth/components/cardDash.vue';
import useDashboard from '../composables/useDashboard';
import { onMounted, ref } from 'vue';
import UsersOnlyTable from '@/modules/User/components/usersOnlyTable.vue';

const {
  totalValues,
  modalStyle,
  getCountedData,
  redirectTo,
} = useDashboard()

onMounted(() => {
  getCountedData()
})


</script>

<template>

  <main id="dashboard" class="mt-[-4vh] pb-10 md:pb-0 relative">
    <router-view v-slot="{ Component }">
      <Transition name="expandModal" :style="modalStyle">
        <div v-if="$route.path.includes('/expenses/view')" class="overlay bg-[#fffffff2]" >
          <h1 class="text-3xl font-semibold leading-loose text-gray-900 dark:text-white my-2 text-center" v-if="$route.query.date  == 'd'">Gastos en el Dia</h1>
          <h1 class="text-3xl font-semibold leading-loose text-gray-900 dark:text-white my-2 text-center" v-else-if="$route.query.date  == 'w'">Gastos en la Semana</h1>
          <h1 class="text-3xl font-semibold leading-loose text-gray-900 dark:text-white my-2 text-center" v-else-if="$route.query.date  == 'm'">Gastos en el Mes</h1>
          <component :is="Component" :key="$route.path"/>
        </div>
      </Transition>
    </router-view>
    
    <section class="grid gap-5 px-2 md:px-5 md:h-[80vh] parentGrid">
      <CardDash :redirect="false" icon="wallet" :value="`${totalValues.countTotal.toString()}$`" label="Cuenta" class="div1" />
      <CardDash :redirect="true" icon="book-open" @redirect="({e}) => redirectTo(e, '/dashboard/expenses/view/', 'd')"  :value="totalValues.gastosDia.toString()" label="Gastos del dia" class="div2" />
      <CardDash :redirect="true" icon="users" @redirect="({e}) => redirectTo(e, '/dashboard/expenses/view/', 'w')"  :value="totalValues.gastosSemana.toString()" label="Gastos de la semana" class="div3" />
      <CardDash :redirect="true" icon="user-tie" @redirect="({e}) => redirectTo(e, '/dashboard/expenses/view/', 'm')" :value="totalValues.gastosMes.toString()" label="Gastos del mes" class="div4" />
      <CardDash :redirect="true" icon="building" :value="totalValues.countTowerA.toString()" label="Torre A (Recibos Pendientes)" class="div5" />
      <CardDash :redirect="true" icon="building" :value="totalValues.countTowerB.toString()" label="Torre B (Recibos Pendientes)" class="div6" />
      <CardDash :redirect="true" icon="building" :value="totalValues.countTowerC.toString()" label="Torre C (Recibos Pendientes)" class="div7" />
      <CardDash :redirect="true" icon="building" :value="totalValues.countRecibes.toString()" label="Torre D (Recibos Pendientes)" class="div8" />

      <article class="relative overflow-hidden div9 border rounded-2xl bg-white shadow-md md:h-[100%] w-full">
        <div class="flex items-center justify-between py-5 mx-auto px-6">
          <p class="text-title text-gray-600">Inquilinos</p>
          <router-link to="/users" class="bg-blue-600 text-white font-bold w-[50vw] md:w-[10%] gap-2 h-[50px] rounded-2xl px-4 flex place-items-center transition-all hover:bg-blue-500">
            <p>Usuarios</p>
            <font-awesome-icon icon="arrow-up-right-from-square" />
          </router-link>
        </div>
        <UsersOnlyTable/>
      </article>
    </section>


  </main>

</template>

<style>
#dashboard .text-title {
  @apply text-2xl font-bold my-5 block;
}

.parentGrid {
grid-template-columns: repeat(2, 1fr);
grid-template-rows: repeat(auto, 1fr);
}

.div1 { grid-area: 1 / 1 / 2 / 2; }
.div2 { grid-area: 1 / 2 / 2 / 3; }
.div3 { grid-area: 2 / 2 / 3 / 3; }
.div4 { grid-area: 2 / 1 / 3 / 2; }
.div5 { grid-area: 3 / 1 / 4 / 2; }
.div6 { grid-area: 3 / 2 / 4 / 3; }
.div7 { grid-area: 4 / 1 / 5 / 2; }
.div8 { grid-area: 4 / 2 / 5 / 3; }
.div9 { grid-area: 5 / 1 / 6 / 3; }


@media (min-width: 768px) {
  .parentGrid {
  grid-template-columns: repeat(5, 1fr);
  grid-template-rows: repeat(4, 1fr);
}

.div1 {
  grid-area: 1 / 1 / 2 / 2;
}

.div2 {
  grid-area: 2 / 1 / 3 / 2;
}

.div3 {
  grid-area: 3 / 1 / 4 / 2;
}

.div4 {
  grid-area: 4 / 1 / 5 / 2;
}

.div5 {
  grid-area: 4 / 2 / 5 / 3;
}

.div6 {
  grid-area: 4 / 3 / 5 / 4;
}

.div7 {
  grid-area: 4 / 4 / 5 / 5;
}

.div8 {
  grid-area: 4 / 5 / 5 / 6;
}

.div9 {
  grid-area: 1 / 2 / 4 / 6;
}
}

</style>
