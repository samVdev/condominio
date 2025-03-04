<script lang="ts" setup>
const props = defineProps<{
    text: string
}>()
</script>

<template>
    <div class="w-[60%] md:w-[15%] md:min-w-[15%]">
        <p class="border-[1px] border-[#EC6173] rounded-2xl py-2 bg-[#FDEDEF] text-[#EC6173] font-semibold w-full">{{ text }}</p>
    </div>
</template>