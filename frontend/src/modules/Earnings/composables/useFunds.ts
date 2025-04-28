import { ref } from "vue"
import AdminServices from '@/modules/Auth/services/panel'
import { alertWithToast } from "@/utils/toast"

export default () => {
    const funds = ref({
        month: 0,
        total: 0
    })

    const getFunds = async () => {
        try {
            const response = await AdminServices.getFundService()
            funds.value.total = response.data.countTotal
        } catch (error) {
            alertWithToast('No se pudo obtener el fondo de reserva', 'error')
        }
    }

    return {
        funds,
        getFunds,
    }
}