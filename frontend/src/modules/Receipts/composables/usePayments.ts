import { reactive, onMounted, ref } from "vue"
import { onBeforeRouteUpdate, useRoute } from "vue-router"
import useTableGrid from "@/composables/useTableGrid"
import useHttp from "@/composables/useHttp"
import ReceiptsService from "../services"
import type { receiptsType } from "../types/receiptsType"
import { questionSweet } from "@/utils/question"
import { alertWithToast } from "@/utils/toast"

type Params = string | string[][] | Record<string, string> | URLSearchParams | undefined

export default () => {

  const data = reactive({
    rows: [] as receiptsType[],
    links: [],
    page: "1",
    search: "",
    sort: "",
    direction: "",
    offset: 0
  })

  const seeAllData = ref({
    recibe_id: 0,
    nombre: '',
    phone: '',
    apt: '',
    mora: false,
    days: false,
    payment: 0,
    dolarBCV: 0,
    cedula: '',
    referencia: '',
    porcent: 0,
    factura: '',
    date: '',
    user: '',
    accepted: false
  })

  const route = useRoute()
  const loading = ref(false)
  const loaded = ref(true)
  const {
    errors,
  } = useHttp()

  const getUSersScroll = () => ReceiptsService.getReceipts(`offset=${data.offset}&${new URLSearchParams(route.query as Params).toString()}`)

  const {
    router,
    setSearch,
    setSort,
    loadScroll
  } = useTableGrid(data, getUSersScroll)

  const getUsers = async (routeQuery: string) => {
    loaded.value = true
    const response = await ReceiptsService.getReceipts(`offset=0&${routeQuery}`)
    errors.value = {}
    data.rows = response.data.rows
    data.search = response.data.search
    data.sort = response.data.sort
    data.direction = response.data.direction
    data.offset = 10
    loaded.value = false

  }

  const clearData = () => {
    seeAllData.value = {
      recibe_id: 0,
      nombre: '',
      phone: '',
      apt: '',
      mora: false,
      days: false,
      payment: 0,
      dolarBCV: 0,
      cedula: '',
      referencia: '',
      porcent: 0,
      factura: '',
      date: '',
      user: '',
      accepted: false
    }
  }

  const acceptOrDecline = async (accept: boolean) => {
    const result = await questionSweet('Atención', `¿Estas seguro que quieres <strong>${accept ? 'aceptar' : 'rechazar'}</strong> el recibo de <strong> ${seeAllData.value.nombre}</strong>  en la factura <strong>#${seeAllData.value.factura}</strong> ?`, 'question')
    if (!result || loading.value) return
    loading.value = true

    const data = {
      action: accept,
      id: seeAllData.value.recibe_id
    }

    try {
      const response = await ReceiptsService.actionReceipt(data)
      alertWithToast(response.data.message, 'success');
      clearData()
      getUsers(
        new URLSearchParams(route.query as Params).toString()
      )
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    } finally {
      loading.value = false
    }
  }

  onBeforeRouteUpdate(async (to, from) => {
    if (to.query !== from.query) {
      await getUsers(
        new URLSearchParams(to.query as Params).toString()
      )
    }
  })

  onMounted(() => {
    if (!route.query.status) {
      router.push({
        path: route.path,
        query: {
          status: 'n'
        }
      })
    } else {
      getUsers(
        new URLSearchParams(route.query as Params).toString()
      )
    }
  })


  return {
    errors,
    data,
    router,
    route,
    loaded,
    seeAllData,
    loading,
    setSearch,
    setSort,
    loadScroll,
    clearData,
    acceptOrDecline,
  }
}

