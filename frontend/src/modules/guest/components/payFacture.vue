<script lang="ts" setup>
import { alertWithToast } from '@/utils/toast';
import { onMounted, ref } from 'vue';
import type { factureUserType } from '../types/factureUserType';
import facturesUser from '../services'

const copied = ref('')

const copyToClipboard = (text: string, field: string) => {
    navigator.clipboard.writeText(text).then(() => {
        copied.value = field
        alertWithToast(`${field} copiado al portapapeles`, 'success')
        setTimeout(() => copied.value = null, 2000);
    });
};

const props = defineProps<{
    facture: factureUserType
}>()

const account = ref({
    cuenta: '',
    cedu: '',
    titu: '',
    banco: '',
})

const paymentForm = ref({
    cedula: '',
    ref: '',
    totalDol: props.facture.total,
    dollar_bcv: props.facture.dollar_bcv,
})

const getAccount = async () => {
    try {
        const response = await facturesUser.getAccount()
        account.value = response.data
    } catch (error) {
        let message = 'Error inesperado';
        if (error.response) {
            message = error.response.data.errors.msg;
        }
        alertWithToast(message, 'error')
    }
}

onMounted(() => {
    getAccount()
})

</script>

<template>
    <div class="w-full max-w-md rounded-2xl bg-card shadow-xl overflow-hidden transition-all duration- bg-white">
        <div class="relative flex justify-between items-center p-6 bg-[#e2384fd2]">
            <div class="flex items-center gap-3 text-white">
                <font-awesome-icon icon="building" class="h-6 w-6" />
                <h2 class="text-xl font-semibold">Detalles de Pago</h2>
            </div>
        </div>

        <form @submit.prevent="() => $emit('paying', { data: paymentForm })" class="p-6 ">
            <div class="rounded-2xl shadow-xl overflow-hidden mb-6">
                <div class="p-4 flex items-center text-white justify-between bg-[#e2384fd2]">
                    <div class="flex items-center gap-3 capitalize">
                        <font-awesome-icon icon="credit-card" class="h-6 w-6" />
                        <h3 class="font-medium">{{ account.banco }}</h3>
                    </div>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Titular</span>
                        <div class="flex items-center gap-2">
                            <span class="font-medium">{{ account.titu }}</span>
                            <button @click="() => copyToClipboard(account.titu, 'Titular')"
                                class="text-[#e2384fd2] hover:text-[#e2384f]" title="Copiar titular">
                                <font-awesome-icon icon="fa-regular fa-circle-check" v-if="copied == 'Titular'" />
                                <font-awesome-icon icon="fa-regular fa-clone" v-else />
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Número de cuenta</span>
                        <div class="flex items-center gap-2">
                            <span class="font-medium tracking-wider">{{ account.cuenta }}</span>
                            <button @click="() => copyToClipboard(account.cuenta, 'Número de cuenta')"
                                class="text-[#e2384fd2] hover:text-[#e2384f]" title="Copiar número de cuenta">
                                <font-awesome-icon icon="fa-regular fa-circle-check"
                                    v-if="copied == 'Número de cuenta'" />
                                <font-awesome-icon icon="fa-regular fa-clone" v-else />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">
                        Cédula:
                    </label>
                    <input class="text-2xl font-bold" name="cedula" maxlength="8" type="text" placeholder="00.000.000"
                        v-model="paymentForm.cedula" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">
                        Nº referencia :
                    </label>
                    <input class="text-2xl font-bold" name="ref" type="text" placeholder="123456" maxlength="6"
                        v-model="paymentForm.ref" required>
                </div>
            </div>



            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Total a pagar ($)
                </label>
                <input class="text-2xl font-bold" type="text" name="dol" :value="`$${facture.total.toFixed(2)}`"
                    required disabled>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Total a pagar (bs)
                </label>
                <input class="text-2xl font-bold" type="text" name="bs" :value="`Bs. ${facture.dollar_bcv.toFixed(2)}`"
                    required disabled>
            </div>
            <div class="mb-6 rounded-md p-4 text-gray-600 text-sm">
                <p class="mb-2 font-medium">Instrucciones:</p>
                <ol class="list-decimal pl-5">
                    <li>Realiza la transferencia por el importe exacto</li>
                    <li>Usa tu nombre como referencia</li>
                    <li>Una vez realizado el pago, guarda el comprobante</li>
                </ol>
            </div>

            <button
                class="flex bg-[#e2384f] items-center justify-center gap-2 mx-auto text-sm font-medium border h-12 rounded-xl w-[60%] transition-all-200 hover:bg-red-500 text-white">
                Pagar
                <font-awesome-icon icon="arrow-right" />
            </button>
        </form>
    </div>
</template>