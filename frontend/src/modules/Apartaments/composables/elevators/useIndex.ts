import { reactive, ref } from "vue"
import elevatorsServices from '../../services/elevators'
import useTableGrid from "@/composables/useTableGrid"
import type { Params } from "@/types/params"
import { questionSweet } from "@/utils/question"
import { alertWithToast } from "@/utils/toast"
import Swal from "sweetalert2";
import type { elevatorType } from "../../types/elevatorType"
import { useRouter } from "vue-router"

export default () => {

  const elevators = ref<elevatorType[]>([])

  const data = reactive({
    rows: [] as elevatorType[],
    links: [] as string[],
    search: "",
    sort: "",
    direction: "",
    offset: 0
  })

  const resumeData = ref({
    count: 0,
    opertives: 0,
    damaged: 0
  })

  const router = useRouter()
  const loaded = ref(false)

  const getInfo = () => elevatorsServices.getElevators(`offset=${data.offset}&${new URLSearchParams(route.query as Params).toString()}`)

  const {
    route,
    setSearch,
    setSort,
    loadScroll,
  } = useTableGrid(data, getInfo)


  const getElevators = async (query: string) => {
    try {
      const response = await elevatorsServices.getElevators(query)
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
      const response = await elevatorsServices.getResume()
      resumeData.value = response.data
    } catch (error) {

    } finally {
      loaded.value = true
    }
  }

  const getMin = async () => {
    try {
      const response = await elevatorsServices.getMin()
      elevators.value = response.data
    } catch (error) {

    } finally {
      loaded.value = true
    }
  }

  const deleteElevator = async (id?: string) => {
    if (id === undefined) return

    const apt = data.rows.find(e => e.id == id)

    const confirm = await questionSweet('Info', `¿Estás seguro que desea eliminar <strong>${apt.number}`, 'question')

    if (!confirm) return

    try {
      await elevatorsServices.deleteElevator(id)
      alertWithToast('Eliminado Correctamente', 'success')
      await getElevators(new URLSearchParams(route.query as Params).toString())
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }

  const reportElevator = async (id?: string) => {
    if (id === undefined) return

    const elevator = data.rows.find(e => e.id == id)

    const confirm = await questionSweet('Info', 
      `¿Estás seguro que desea reportar como 
      <label class='font-bold ${elevator.status ? 'text-red-600' : 'text-green-600'}'>${elevator.status ? 'Dañado' : 'Operativo'}</label> 
      el Ascensor: <strong>${elevator.number}?`, 
      'question')

    if (!confirm) return

    router.push({ name: 'reportForm', params: { id: elevator.id}, query: {type: elevator.status ? 'dañado' : 'operativo'}})
  }




  return {
    data,
    route,
    loaded,
    resumeData,
    elevators,
    getElevators,
    setSearch,
    setSort,
    loadScroll,
    deleteElevator,
    reportElevator,
    getMin
  }

}

