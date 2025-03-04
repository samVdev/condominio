<script lang="ts" setup>

const props = defineProps<{
    editBtn: boolean,
    deleteBtn: boolean
}>()

</script>

<template>
    <div class="flex items-center butons">
        <button @click="$emit('edit')" class="bg-blue-600" v-if="editBtn">
            <font-awesome-icon icon="pen" />
        </button>
        <button @click="$emit('remove')" class="bg-red-600" v-if="deleteBtn">
            <font-awesome-icon icon="trash" />
        </button>
    </div>
</template>