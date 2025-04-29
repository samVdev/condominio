import { reactive, ref } from "vue"
import type { earningType } from "../types/EarningType"
import earningsServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { questionSweet } from "@/utils/question"
import useTableGrid from "@/composables/useTableGrid"
import { onBeforeRouteUpdate } from "vue-router"
import type { Params } from "@/types/params"



export default () => {
  const earnings = reactive({
    rows: [] as earningType[],
    links: [] as string[],
    search: "",
    sort: "",
    direction: "",
    offset: 0,
    month: 0,
    Facture: {
      USD: 0,
      BS: 0
    }
  })

  const viewImage = ref('')
  const loaded = ref(false)

  const getInfo = () => earningsServices.getEarnings(`offset=${earnings.offset}&${new URLSearchParams(route.query as Params).toString()}`)

  const {
    route,
    setSearch,
    setSort,
    loadScroll,
    setMonth,
  } = useTableGrid(earnings, getInfo)


  const getEarnings = async (query: string) => {
    try {
      loaded.value = false
      const response = await earningsServices.getEarnings(query)
      earnings.rows = response.data.rows
      earnings.search = response.data.search
      earnings.sort = response.data.sort
      earnings.direction = response.data.direction
      earnings.month = response.data.month
      earnings.Facture = response.data.Facture
      earnings.offset = 10
    } catch (error) {

    } finally {
      loaded.value = true

    }
  }

  const deleteEarning = async (id?: string) => {
    if (id === undefined) return

    const earning = earnings.rows.find(e => e.id == id)

    const confirm = await questionSweet('Info', `¿Estás seguro que desea eliminar el <strong>${earning.name}`, 'question')

    if (!confirm) return

    try {
      await earningsServices.deleteEarning(id)
      alertWithToast('Eliminado Correctamente', 'success')
      await getEarnings(new URLSearchParams(route.query as Params).toString())
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }


  onBeforeRouteUpdate(async (to, from) => {
    if (to.query !== from.query && (to.name == 'earnings' || to.name == 'earningsUser')) {
      await getEarnings(
        new URLSearchParams(to.query as Params).toString()
      )
    }
  })

  return {
    earnings,
    route,
    loaded,
    viewImage,
    setSearch,
    setSort,
    loadScroll,
    getEarnings,
    deleteEarning,
    setMonth,
  }
}

