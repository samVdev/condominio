import { reactive, ref } from "vue"
import type { typeEarningType } from "../types/typeEarningType"
import TypeEarningsService from '../services'
import { alertWithToast } from "@/utils/toast"
import { questionSweet } from "@/utils/question"
import useTableGrid from "@/composables/useTableGrid"
import { onBeforeRouteUpdate } from "vue-router"
import type { Params } from "@/types/params"

export default () => {
  const typeEarnings = reactive({
    rows: [] as typeEarningType[],
    links: [] as string[],
    page: "1",
    search: "",
    sort: "",
    direction: "",
    offset: 0
  })

  const loaded = ref(false)

  const isOpenCreate = ref(false)
  const sending = ref(false)
  const data = ref<typeEarningType>({
    id: '',
    name: "",
  })

  const typeEarningsMinium = ref<typeEarningType[]>([])

  const getInfo = () => TypeEarningsService.getTypeEarnings(`offset=${typeEarnings.offset}&${new URLSearchParams(route.query as Params).toString()}`)


  const {
    route,
    setSearch,
    loadScroll
  } = useTableGrid(typeEarnings, getInfo)

  const getTypeEarnings = async (query: string) => {
    try {
      loaded.value = false
      const response = await TypeEarningsService.getTypeEarnings(query)
      typeEarnings.rows = response.data.rows
      typeEarnings.search = response.data.search
      typeEarnings.sort = response.data.sort
      typeEarnings.direction = response.data.direction
      typeEarnings.offset = 10
    } catch (error) {

    } finally {
      loaded.value = true
    }
  }

  const getTypeEarningsToSelect = async () => {
    try {
      loaded.value = false
      const response = await TypeEarningsService.getTypeEarningsToSelect()
      typeEarningsMinium.value = response.data
    } catch (error) {

    } finally {
      loaded.value = true
    }
  }

  const showTypeEarning = async (id: string) => {
    try {
      const response = await TypeEarningsService.showTypeEarning(id)
      data.value = response.data
      data.value.id = id
      isOpenCreate.value = true
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }

  const insertTypeEarning = async () => {
    try {
      const response = await TypeEarningsService.insertTypeEarning(data.value)
      return response.data.message
    } catch (error) {
      throw error
    }
  }

  const updateTypeEarning = async () => {
    try {
      const response = await TypeEarningsService.updateTypeEarning(data.value.id, data.value)
      return response.data.message
    } catch (error) {
      throw error
    }
  }

  const deleteTypeEarning = async (id?: string) => {
    if (id === undefined) return

    const typeEarning = typeEarnings.rows.find(e => e.id == id)

    const confirm = await questionSweet('Info', `¿Estás seguro que desea eliminar el <strong>${typeEarning.name}`, 'question')

    if (!confirm) return

    try {
      await TypeEarningsService.deleteTypeEarning(id)
      alertWithToast('Eliminado Correctamente', 'success')
      await getTypeEarnings(new URLSearchParams(route.query as Params).toString())
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }


  const submit = async () => {
    try {
      sending.value = true
      const response = !data.value.id ? await insertTypeEarning() : await updateTypeEarning()
      data.value = {
        id: '',
        name: "",
      }
      isOpenCreate.value = false
      await getTypeEarnings(new URLSearchParams(route.query as Params).toString())
      alertWithToast(response, 'success')
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    } finally {
      sending.value = false
    }
  }

  onBeforeRouteUpdate(async (to, from) => {
    if (to.query !== from.query) {
      await getTypeEarnings(
        new URLSearchParams(to.query as Params).toString()
      )
    }
  })



  return {
    typeEarnings,
    isOpenCreate,
    data,
    sending,
    route,
    loaded,
    typeEarningsMinium,
    getTypeEarnings,
    showTypeEarning,
    deleteTypeEarning,
    submit,
    setSearch,
    getTypeEarningsToSelect,
    loadScroll
  }
}

