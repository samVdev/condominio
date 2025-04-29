import { alertWithToast } from "@/utils/toast";
import { ref } from "vue"
import adminService from "../services/panel";
import { useRouter } from 'vue-router'

export default () => {

    const totalValues = ref({
        countTotal: 0,
        gastosDia: 0,
        gastosSemana: 0,
        gastosMes: 0,
        countTowerA: 0,
        countTowerB: 0,
        countTowerC: 0,
        countTowerD: 0,
    })

    const modalStyle = ref({})

    const router = useRouter()
    const isExpensesView = ref(false);

    const getCountedData = async () => {
        try {
            const response = await adminService.getCountedDataService()
            const countTotal = await getFundData()
            totalValues.value = {
                ...response.data,
                countTotal
            }
        } catch (error) {
            const message = error.response.data.errors.msg || 'Error inesperado';
            alertWithToast(message, 'error')
        }
    }

    const getFundData = async () => {
        try {
            const response = await adminService.getFundService()
            return response.data.countTotal.toFixed(2)
        } catch (error) {
            const message = error.response.data.errors.msg || 'Error inesperado';
            alertWithToast(message, 'error')
            return 0
        }
    }

    const redirectTo = (e: any, to: string, params?: any) => {
        const rect = e.target.getBoundingClientRect();
        modalStyle.value = {
            "--modal-top": `${rect.top}px`,
            "--modal-left": `${rect.left}px`,
        };
        router.push({ path: to, query: {...params} });
    };
    

    return {
        totalValues,
        isExpensesView,
        modalStyle,
        getCountedData,
        redirectTo,
    }
}