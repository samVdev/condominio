import { reactive, ref } from "vue"
import provisionsServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { onBeforeRouteUpdate } from "vue-router"

export default () => {
    const funds = ref({
        month: 0,
        total: 0
    })

    const provisions = reactive({
        rows: [],
        links: [] as string[],
        search: "",
        sort: "",
        direction: "",
        offset: 0,
    })

    const getFunds = async () => {
        try {
            const response = await provisionsServices.getFunds()
            funds.value = response.data
        } catch (error) {
            alertWithToast('No se pudo obtener el total de proviciones', 'error')
        }
    }


    const getFundsDetails = async () => {
        try {
            const response = await provisionsServices.getFundsDetails()
            provisions.rows = response.data.rows
            provisions.offset = 10
        } catch (error) {
            alertWithToast('No se pudo obtener las provisiones', 'error')
        }
    }


    onBeforeRouteUpdate(async (to, from) => {
        if (to.query !== from.query && (to.name == 'provisions')) {
            await getFunds()
        }
    })

    return {
        funds,
        provisions,
        getFunds,
        getFundsDetails,
    }
}