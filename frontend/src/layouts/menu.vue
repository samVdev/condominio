<script lang="ts" setup>
import { useSidebar } from '@/composables/useSidebar';
import { Menu } from '@/types/Menu';
import { computed } from 'vue';
const { isClose } = useSidebar()

const props = defineProps<{
  menus: any
}>()

const activeClass = computed(() => {
  return isClose ? 'activeOpen' : 'activeClose';
});

</script>


<template>
    <nav
    class="overflow-x-hidden mt-0"
    :class="isClose ? `grid h-full items-center justify-center ml-5 text-[#EA5165]` : 'bg-[#EA5165] text-white h-full'"
    >
      <ul 
      class="mt-16">
        <li v-for="item in menus" :key="item.name" 
        :class="isClose ? `justify-center bg-white rounded-full border-1 shadow-md overflow-hidden hover:text-white hover:bg-[#EA5165] activeOpen` : 'hover:bg-white hover:text-[#EA5165] activeClose'"
        class="my-4 mx-4 rounded-xl transition ease-in duration-[.1s]">
          <router-link
            :to="`/${item.path}`"
            :title="`Ir a ${item.title}`"
            :class="isClose ? `justify-center` : ''"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium"
            @click="$emit('closeMenuAuto', true)"
          >
            <font-awesome-icon :icon="item.icon" class="md:h-[3vh] 2xl:h-[2vh]"/>
            <p 
            :class="isClose ? `block md:hidden` : ''"
            class="capitalize"
            >{{ item.title }} </p>
          </router-link>
        </li>
      </ul>
    </nav>
</template>

<style>
.activeClose > .router-link-active {
  @apply rounded-xl bg-white text-[#EA5165]
}

.activeOpen > .router-link-active{
  @apply rounded-xl bg-[#EA5165] text-white
}
</style>