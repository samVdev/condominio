<script lang="ts" setup>

const props = defineProps<{
    editBtn?: boolean,
    deleteBtn?: boolean,
    recibesBtn?: boolean,
    expensesBtn?: boolean,
    earningsBtn?: boolean,
    emailBtn?: boolean,
    historyBtn?: boolean,
    reportElevatorBtn?: boolean,
}>()

</script>

<template>
    <div class="flex items-center butons">
        <button @click="$emit('edit')" class="bg-blue-600" title="Editar este registro" v-if="editBtn">
            <font-awesome-icon icon="pen" />
        </button>
        <button @click="$emit('earnings')" class="bg-green-600" title="Ver Ingresos" v-if="earningsBtn">
            <font-awesome-icon icon="money-bill-trend-up" />
        </button>
        <button @click="$emit('report')" class="bg-orange-500" title="Hacer reporte" v-if="reportElevatorBtn">
            <font-awesome-icon icon="flag" />
        </button>
        <button @click="$emit('history')" class="bg-green-600" title="Ver historial" v-if="historyBtn">
            <font-awesome-icon icon="timeline" />
        </button>
        <button @click="$emit('expenses')" class="bg-blue-600" title="Ver Gastos" v-if="expensesBtn">
            <font-awesome-icon icon="money-bill-transfer" />
        </button>
        <button @click="$emit('email')" class="bg-orange-600" title="Enviar por email" v-if="emailBtn">
            <font-awesome-icon icon="envelope" />
        </button>
        <button @click="$emit('recives')" class="bg-orange-500" title="Ver Recibos pendientes" v-if="recibesBtn">
            <font-awesome-icon icon="receipt" />
        </button>
        <button @click="$emit('remove')" class="bg-red-600" title="Eliminar este registro" v-if="deleteBtn">
            <font-awesome-icon icon="trash" />
        </button>
    </div>
</template>