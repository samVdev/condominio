<script lang="ts" setup>

const props = defineProps<{
    icon: string,
    value: string,
    label: string,
    class?: string,
    redirect: boolean
}>()

</script>

<template>
    <div class="ThisDiv grid border border-stroke bg-white px-7.5 px-5 py-6 rounded-xl shadow-xl relative" :class="class">
        <button class="absolute top-5 right-5 cursor-pointer" @click="(e) => $emit('redirect', {e: e})" v-if="redirect">
        <font-awesome-icon icon="arrow-up-right-from-square"/>
        </button>
        <font-awesome-icon :icon="icon" class="p-3 rounded-full bg-[#EA5165e3] text-white"/>
        <h4 class="text-2xl font-bold text-black my-5">{{ value }}</h4>
        <p class="text-xl font-medium capitalize text-gray-700">{{ label }}</p>
    </div>
</template>

<style scoped>
.ThisDiv {
    animation: swing-top 1s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
</style>