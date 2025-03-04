<script lang="ts" setup>

const props = defineProps<{
    text: string,
    icon: string
}>()
</script>

<template>
    <div class="flex items-center gap-3 capitalize text-2xl">
        <font-awesome-icon :icon="icon" class="text-[#F97415] inline-block"/>
        <h3 class="inline-block">{{ text }}</h3>
    </div>
</template>