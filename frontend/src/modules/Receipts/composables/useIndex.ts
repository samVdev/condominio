import { reactive, onMounted, ref } from "vue"
import { onBeforeRouteUpdate } from "vue-router"
import useTableGrid from "@/composables/useTableGrid"
import useHttp from "@/composables/useHttp"
import ReceiptsService from "../services"

type Params = string | string[][] | Record<string, string> | URLSearchParams | undefined

export default () => {

  const data = reactive({
    rows: [],
    links: [],
    page: "1",
    search: "",
    sort: "",
    direction: "",
    offset: 0
  })

  const loaded = ref(true)
  const {
    errors,
  } = useHttp()


  const getUSersScroll = () => ReceiptsService.getUsersReceipts(new URLSearchParams(route.query as Params).toString())

  const {
    route,
    router,
    setSearch,
    setSort,
    loadScroll
  } = useTableGrid(data, getUSersScroll)

  const getUsers = async (routeQuery: string) => {
    loaded.value = true
    const response = await ReceiptsService.getUsersReceipts(`offset=0&${routeQuery}`)
    errors.value = {}
    data.rows = response.data.rows
    data.search = response.data.search
    data.sort = response.data.sort
    data.direction = response.data.direction
    data.offset = 10
    loaded.value = false

  }


  onBeforeRouteUpdate(async (to, from) => {
    if (to.query !== from.query && 
      (from.path == '/dashboard' && to.path == '/dashboard') || 
      (from.path == '/users' && to.path == '/users') ||
      (from.path == '/receipts' && to.path == '/receipts')
    ) {
      await getUsers(
        new URLSearchParams(to.query as Params).toString()
      )
    }
  })

  onMounted(() => {
    getUsers(
      new URLSearchParams(route.query as Params).toString()
    )
  })

  return {
    errors,
    data,
    router,
    route,
    loaded,
    setSearch,
    setSort,
    loadScroll
  }
}

