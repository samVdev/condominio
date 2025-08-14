import { reactive, ref } from "vue"
import boardsServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { questionSweet } from "@/utils/question"
import useTableGrid from "@/composables/useTableGrid"
import { onBeforeRouteUpdate } from "vue-router"
import type { Params } from "@/types/params"
import type { boardType } from "../types/boardType"



export default () => {
  const boards = reactive({
    rows: [] as boardType[],
    links: [] as string[],
    page: "1",
    search: "",
    sort: "",
    direction: "",
    offset: 0
  })

  const url = import.meta.env.VITE_APP_API_URL

  const loaded = ref(false)

  const isOpenCreate = ref(false)
  const sending = ref(false)

  const getInfo = () => boardsServices.get(`offset=${boards.offset}&${new URLSearchParams(route.query as Params).toString()}`)

  const {
    route,
    setSort,
    setSearch,
    loadScroll
  } = useTableGrid(boards, getInfo)

  const getServices = async (query: string) => {
    try {
      loaded.value = false
      const response = await boardsServices.get(query)
      boards.rows = response.data.rows.map(e => {
        return {
          ...e,
          imagen: `${url}/${e.imagen}`
        }
      })
      boards.search = response.data.search
      boards.sort = response.data.sort
      boards.direction = response.data.direction
      boards.offset = 10
    } catch (error) {

    } finally {
      loaded.value = true
    }
  }

  const deleteService = async (uuid?: string) => {
    if (uuid === undefined) return

    const post = boards.rows.find(e => e.uuid == uuid)

    if (post.statusEnd) return alertWithToast('No se puede eliminar una junta ya finalizada', 'warning')

    const confirm = await questionSweet('Info', `¿Estás seguro que desea eliminar el <strong>${post.nombre}`, 'question')

    if (!confirm) return

    try {
      await boardsServices.delete(uuid)
      alertWithToast('Eliminado Correctamente', 'success')
      await getServices(new URLSearchParams(route.query as Params).toString())
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }


  onBeforeRouteUpdate(async (to, from) => {
    if (to.query !== from.query && (to.name == 'boards')) {
      await getServices(
        new URLSearchParams(to.query as Params).toString()
      )
    }
  })

  return {
    boards,
    isOpenCreate,
    sending,
    route,
    loaded,
    getServices,
    setSort,
    deleteService,
    setSearch,
    loadScroll,
  }
}

