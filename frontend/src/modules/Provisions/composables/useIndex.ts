import { reactive, ref } from "vue"
import type { provisionType } from "../types/ProvisionType"
import provisionsServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { questionSweet } from "@/utils/question"
import useTableGrid from "@/composables/useTableGrid"
import { onBeforeRouteUpdate } from "vue-router"
import type { Params } from "@/types/params"



export default (emit: any) => {
  const provisions = reactive({
    rows: [] as provisionType[],
    links: [] as string[],
    search: "",
    sort: "",
    direction: "",
    month: 0,
    offset: 0,
    Facture: {
      USD: 0,
      BS: 0
    },
  })

  const viewImage = ref('')
  const loaded = ref(false)

  const getInfo = () => provisionsServices.getProvisions(`offset=${provisions.offset}&${new URLSearchParams(route.query as Params).toString()}`)

  const {
    route,
    setSearch,
    setSort,
    loadScroll,
    setMonth,
  } = useTableGrid(provisions, getInfo)


  const getProvisions = async (query: string) => {
    try {
      loaded.value = false
      const response = await provisionsServices.getProvisions(query)
      provisions.rows = response.data.rows
      provisions.search = response.data.search
      provisions.sort = response.data.sort
      provisions.direction = response.data.direction
      provisions.Facture = response.data.Facture
      provisions.offset = 10
      provisions.month = response.data.month
    } catch (error) {

    } finally {
      loaded.value = true

    }
  }

  const deleteProvision = async (id?: string) => {
    if (id === undefined) return

    const provision = provisions.rows.find(e => e.id == id)

    const confirm = await questionSweet('Info', `¿Estás seguro que desea eliminar el <strong>${provision.name}`, 'question')

    if (!confirm) return

    try {
      await provisionsServices.deleteProvision(id)
      alertWithToast('Eliminado Correctamente', 'success')
      await getProvisions(new URLSearchParams(route.query as Params).toString())
      emit('getFunds', {})
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }


  onBeforeRouteUpdate(async (to, from) => {
    if (to.query !== from.query && (to.name == 'provisions' || to.name == 'provisionsUser')) {
      await getProvisions(
        new URLSearchParams(to.query as Params).toString()
      )
    }
  })

  return {
    provisions,
    route,
    loaded,
    viewImage,
    setSearch,
    setSort,
    loadScroll,
    getProvisions,
    deleteProvision,
    setMonth,
  }
}

