import { reactive, ref } from "vue"
import type { factureType } from "../types/factureType"
import facturesServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { questionSweet } from "@/utils/question"
import useTableGrid from "@/composables/useTableGrid"
import { onBeforeRouteUpdate } from "vue-router"
import type { Params } from "@/types/params"



export default () => {
  const factures = reactive({
    rows: [] as factureType[],
    links: [] as string[],
    search: "",
    sort: "",
    direction: "",
    offset: 0
  })

  const loaded = ref(false)

  const getInfo = () => facturesServices.getFactures(`offset=${factures.offset}&${new URLSearchParams(route.query as Params).toString()}`)

  const {
    route,
    setSearch,
    setSort,
    loadScroll,
  } = useTableGrid(factures, getInfo)


  const getFactures = async (query: string) => {
    try {
      loaded.value = false
      const response = await facturesServices.getFactures(query)
      factures.rows = response.data.rows
      factures.search = response.data.search
      factures.sort = response.data.sort
      factures.direction = response.data.direction
      factures.offset = 10
    } catch (error) {

    } finally {
      loaded.value = true

    }
  }

  const deleteFacture = async (id?: string) => {
    if (id === undefined) return

    const facture = factures.rows.find(e => e.id == id)

    const confirm = await questionSweet('Info', `¿Estás seguro que desea eliminar la factura?`, 'question')

    if (!confirm) return

    try {
      await facturesServices.deleteFactures(id)
      alertWithToast('Eliminado Correctamente', 'success')
      await getFactures(new URLSearchParams(route.query as Params).toString())
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }


  onBeforeRouteUpdate(async (to, from) => {
    if (to.query !== from.query && (to.name == 'factures')) {
      await getFactures(
        new URLSearchParams(to.query as Params).toString()
      )
    }
  })

  return {
    factures,
    route,
    loaded,
    setSearch,
    setSort,
    loadScroll,
    getFactures,
    deleteFacture,
  }
}

