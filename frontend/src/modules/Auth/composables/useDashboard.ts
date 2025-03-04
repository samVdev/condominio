import { alertWithToast } from "@/utils/toast";
import { ref } from "vue"
import { getCountedDataService } from "../services/panel";

export default () => {

    const totalValues = ref({
        countTotal: 0,
        gastosDia: 0,
        gastosSemana: 0,
        gastosMes: 0,
        countTowerA: 0,
        countTowerB: 0,
        countTowerC: 0,
        countRecibes: 0,
    })

    const getCountedData = async () => {
        try {
            const response = await getCountedDataService()
            totalValues.value = response.data
        } catch (error) {
            const message = error.response.data.errors.msg || 'Error inesperado';
            alertWithToast(message, 'error')
        }
    }

    return {
        totalValues,
        getCountedData
    }
}