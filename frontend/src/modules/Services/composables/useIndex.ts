import { ref } from "vue"
import type { serviceType } from "../types/serviceType"
import servicesServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { questionSweet } from "@/utils/question"
import useTableGrid from "@/composables/useTableGrid"
import { onBeforeRouteUpdate } from "vue-router"
import type { Params } from "@/types/params"



export default () => {
  const services = ref({
    rows: [] as serviceType[],
    links: [] as string[],
    page: "1",
    search: "",
    sort: "",
    direction: ""
  })

  const loaded = ref(false)

  const isOpenCreate = ref(false)
  const sending = ref(false)
  const data = ref<serviceType>({
    id: '',
    name: "",
    is_elevator: false,
  })

  const servicesMinium = ref<serviceType[]>([])

  const {
    route,
    setSearch,
  } = useTableGrid(services.value)

  const getServices = async (query: string) => {
      try {
        loaded.value = false
        const response = await servicesServices.getServices(query)
        services.value.rows = response.data
      } catch (error) {
        
      } finally{
        loaded.value = true
      }
  }

  const getServicesToSelect = async () => {
    try {
      loaded.value = false
      const response = await servicesServices.getServicesToSelect()
      servicesMinium.value = response.data
    } catch (error) {
      
    } finally{
      loaded.value = true
    }
  }

  const showService = async (id: string) => {
    try {
      const response = await servicesServices.showService(id)
      data.value = response.data
      data.value.id = id
      isOpenCreate.value = true
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }

  const insertService = async () => {
    try {
      const response = await servicesServices.insertService(data.value)
      return response.data.message
    } catch (error) {
      throw error
    }
  }

  const updateService = async () => {
    try {
      const response = await servicesServices.updateService(data.value.id, data.value)
      return response.data.message
    } catch (error) {
      throw error
    }
  }

  const deleteService = async (id?: string) => {
    if (id === undefined) return

    const service = services.value.rows.find(e => e.id == id)

    const confirm = await questionSweet('Info', `¿Estás seguro que desea eliminar el <strong>${service.name}`, 'question')

    if (!confirm) return

    try {
      await servicesServices.deleteService(id)
      alertWithToast('Eliminado Correctamente', 'success')
      await getServices(new URLSearchParams(route.query as Params).toString())
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }


  const submit = async () => {
    try {
      sending.value = true
      const response = !data.value.id ? await insertService() : await updateService()
      data.value = {
        id: '',
        name: "",
        is_elevator: false,
      }
      isOpenCreate.value = false
      await getServices(new URLSearchParams(route.query as Params).toString())
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
        await getServices(
          new URLSearchParams(to.query as Params).toString()
        )
      }
    })
  
    

  return {
    services,
    isOpenCreate,
    data,
    sending,
    route,
    loaded,
    servicesMinium,
    getServices,
    showService,
    deleteService,
    submit,
    setSearch,
    getServicesToSelect
  }
}

