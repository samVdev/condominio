import { alertWithToast } from "@/utils/toast";
import { ref } from "vue"
import { getCountedDataService } from "../services/panel";
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
            const response = await getCountedDataService()
            totalValues.value = response.data
        } catch (error) {
            const message = error.response.data.errors.msg || 'Error inesperado';
            alertWithToast(message, 'error')
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