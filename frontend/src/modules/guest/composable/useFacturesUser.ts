import { reactive, ref } from "vue"
import facturesUser from '../services'
import useTableGrid from "@/composables/useTableGrid"
import type { Params } from "@/types/params"
import type { factureUserType } from "../types/factureUserType"
import { alertWithToast } from "@/utils/toast"

export default () => {
    const facturesPending = ref<factureUserType[]>([])
    const factures = reactive({
        rows: [] as factureUserType[],
        links: [] as string[],
        search: "",
        sort: "",
        direction: "",
        offset: 0
    })

    const counted = ref({
        pending: "0",
        payment: "0",
        total: '0'
    })

    const factureToPay = ref<factureUserType>({
        id: "",
        mount_dollars: 0,
        mount_bs: 0,
        dollar_bcv: 0,
        porcent: 0,
        tower: "",
        created: "",
        alicuot: 0,
        payment: false,
        isForMora: false,
        total: 0
    })

    const seeAllFactures = ref(false)
    const loaded = ref(false)

    const getInfo = () => facturesUser.getFacturesCompleted(`offset=${factures.offset}&${new URLSearchParams(route.query as Params).toString()}`)

    const {
        route,
        setSearch,
        setSort,
        loadScroll,
    } = useTableGrid(factures, getInfo)

    const getFacturesCompleted = async () => {
        const response = await facturesUser.getFacturesCompleted('')
        factures.rows = response.data.rows
        factures.search = response.data.search
        factures.sort = response.data.sort
        factures.direction = response.data.direction
        factures.offset = 10
    }

    const getFacturesPending = async () => {
        const response = await facturesUser.getFacturesPending('')
        facturesPending.value = response.data
    }

    const getCounted = async () => {
        const response = await facturesUser.getCounted()
        counted.value = {
            pending: response.data.pending || 0,
            payment: response.data.payment || 0,
            total: response.data.total || 0,
        }
    }

    const cleanFacture = () => {
        factureToPay.value = {
            id: "",
            mount_dollars: 0,
            mount_bs: 0,
            dollar_bcv: 0,
            porcent: 0,
            tower: "",
            created: "",
            alicuot: 0,
            payment: false,
            isForMora: false,
            total: 0
        }
    }

    const submitPay = async (data: any) => {
        try {
            const id = factureToPay.value.id
            data.id = id
            const response = await facturesUser.saveReceipt(id, data)
            const message = response.data.message
            alertWithToast(message, 'success')
            cleanFacture()
            getFacturesPending()
            getFacturesCompleted()
        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        }
    }

    return {
        factures,
        route,
        loaded,
        counted,
        factureToPay,
        facturesPending,
        seeAllFactures,
        setSearch,
        setSort,
        loadScroll,
        getFacturesPending,
        getFacturesCompleted,
        getCounted,
        cleanFacture,
        submitPay,
    }
}