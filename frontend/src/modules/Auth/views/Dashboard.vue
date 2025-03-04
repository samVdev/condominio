<script setup lang="ts">
import CardDash from '@/modules/Auth/components/cardDash.vue';
import TableUsersDash from '@/modules/Auth/components/tableUsersDash.vue';
import useDashboard from '../composables/useDashboard';
import { onMounted } from 'vue';
import UsersOnlyTable from '@/modules/User/components/usersOnlyTable.vue';

const {
  totalValues,
  getCountedData
} = useDashboard()

onMounted(() => {
  getCountedData()
})

</script>

<template>

  <main id="dashboard" class="mt-[-4vh]">

    <section class="grid gap-5 px-2 md:px-5 parentGrid">
      <CardDash :redirect="false" icon="wallet" :value="`${totalValues.countTotal.toString()}$`" label="Cuenta" class="div1" />
      <CardDash :redirect="true" icon="book-open" :value="totalValues.gastosDia.toString()" label="Gastos del dia" class="div2" />
      <CardDash :redirect="true" icon="users" :value="totalValues.gastosSemana.toString()" label="Gastos de la semana" class="div3" />
      <CardDash :redirect="true" icon="user-tie" :value="totalValues.gastosMes.toString()" label="Gastos del mes" class="div4" />
      <CardDash :redirect="true" icon="building" :value="totalValues.countTowerA.toString()" label="Torre A (Recibos)" class="div5" />
      <CardDash :redirect="true" icon="building" :value="totalValues.countTowerB.toString()" label="Torre B (Recibos)" class="div6" />
      <CardDash :redirect="true" icon="building" :value="totalValues.countTowerC.toString()" label="Torre C (Recibos)" class="div7" />
      <CardDash :redirect="true" icon="building" :value="totalValues.countRecibes.toString()" label="Torre D (Recibos)" class="div8" />

      <article class="relative overflow-hidden div9">
        <div class="flex items-center justify-between py-5 mx-auto px-6">
          <p class="text-title text-gray-600 mt-2">Inquilinos</p>
        </div>
        <UsersOnlyTable/>
      </article>
    </section>


  </main>

</template>

<style>
#dashboard article {
  @apply border rounded-2xl  bg-white shadow-md h-[100%] w-full;
}

#dashboard .text-title {
  @apply text-2xl font-bold my-5 block;
}

.parentGrid {
grid-template-columns: repeat(2, 1fr);
grid-template-rows: repeat(5, 1fr);
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
  grid-template-rows: repeat(5, 1fr);
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
