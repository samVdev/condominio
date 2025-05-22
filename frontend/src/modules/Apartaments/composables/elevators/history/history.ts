import { reactive, ref } from "vue"
import elevatorsServices from '../../../services/elevators'
import useTableGrid from "@/composables/useTableGrid"
import type { Params } from "@/types/params"
import { questionSweet } from "@/utils/question"
import { alertWithToast } from "@/utils/toast"

export default () => {

  const data = reactive({
    rows: [] as any[],
    links: [] as string[],
    search: "",
    sort: "",
    direction: "",
    offset: 0
  })

  const viewImage = ref('')
  const loaded = ref(false)

  const getInfo = () => elevatorsServices.getHistory(`offset=${data.offset}&${new URLSearchParams(route.query as Params).toString()}`)

  const {
    route,
    setSearch,
    setSort,
    loadScroll,
  } = useTableGrid(data, getInfo)


  const getHistory = async (query: string) => {
    try {
      const response = await elevatorsServices.getHistory(query)
      data.rows = response.data.rows
      data.search = response.data.search
      data.sort = response.data.sort
      data.direction = response.data.direction
      data.offset = 10
    } catch (error) {

    } finally {
      loaded.value = true
    }
  }


  return {
    data,
    route,
    loaded,
    viewImage,
    setSearch,
    setSort,
    loadScroll,
    getHistory
  }

}

