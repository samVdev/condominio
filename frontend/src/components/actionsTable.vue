<script lang="ts" setup>

const props = defineProps<{
    editBtn?: boolean,
    deleteBtn?: boolean,
    recibesBtn?: boolean,
    expensesBtn?: boolean
}>()

</script>

<template>
    <div class="flex items-center butons">
        <button @click="$emit('edit')" class="bg-blue-600" title="Editar este registro" v-if="editBtn">
            <font-awesome-icon icon="pen" />
        </button>
        <button @click="$emit('expenses')" class="bg-blue-600" title="Ver Gastos" v-if="expensesBtn">
            <font-awesome-icon icon="money-bill-transfer" />
        </button>
        <button @click="$emit('recives')" class="bg-orange-500" title="Ver Recibos pendientes" v-if="recibesBtn">
            <font-awesome-icon icon="receipt" />
        </button>
        <button @click="$emit('remove')" class="bg-red-600" title="Eliminar este registro" v-if="deleteBtn">
            <font-awesome-icon icon="trash" />
        </button>
    </div>
</template>