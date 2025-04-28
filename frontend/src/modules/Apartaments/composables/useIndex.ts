import { reactive, ref } from "vue"
import ApartamentsServices from '../services'
import type { towersType } from "../types/towersType"
import useTableGrid from "@/composables/useTableGrid"
import type { Params } from "@/types/params"
import { questionSweet } from "@/utils/question"
import { alertWithToast } from "@/utils/toast"

export default () => {
  const towers = ref<towersType[]>([])

  const data = reactive({
    rows: [] as any[],
    links: [] as string[],
    search: "",
    sort: "",
    direction: "",
    offset: 0
  })

  const resumeData = ref({
    count: 0,
    porcent: 0
  })

  const loaded = ref(false)

  const getInfo = () => ApartamentsServices.getApts(`offset=${data.offset}&${new URLSearchParams(route.query as Params).toString()}`)


  const {
    route,
    setSearch,
    setSort,
    loadScroll,
  } = useTableGrid(data, getInfo)


  const getTowers = async () => {
    const response = await ApartamentsServices.getTowers()
    towers.value = response.data
  }

  const getApt = async (query: string) => {
    try {
      const response = await ApartamentsServices.getApts(query)
      data.rows = response.data.rows
      data.search = response.data.search
      data.sort = response.data.sort
      data.direction = response.data.direction
      data.offset = 10
      getResume()
    } catch (error) {

    } finally {
      loaded.value = true
    }
  }

  const getResume = async () => {
    try {
      const response = await ApartamentsServices.getResume()
      resumeData.value = response.data
    } catch (error) {

    } finally {
      loaded.value = true
    }
  }


  const deleteApt = async (id?: string) => {
    if (id === undefined) return

    const apt = data.rows.find(e => e.id == id)

    const confirm = await questionSweet('Info', `¿Estás seguro que desea eliminar <strong>${apt.name}`, 'question')

    if (!confirm) return

    try {
      await ApartamentsServices.deleteApt(id)
      alertWithToast('Eliminado Correctamente', 'success')
      await getApt(new URLSearchParams(route.query as Params).toString())
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }

  return {
    towers,
    data,
    route,
    loaded,
    resumeData,
    getApt,
    getTowers,
    setSearch,
    setSort,
    loadScroll,
    deleteApt
  }

}

