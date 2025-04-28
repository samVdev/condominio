import { reactive, ref } from "vue"
import type { newsType } from "../types/newsType"
import postsServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { questionSweet } from "@/utils/question"
import useTableGrid from "@/composables/useTableGrid"
import { onBeforeRouteUpdate } from "vue-router"
import type { Params } from "@/types/params"



export default () => {
  const posts = reactive({
    rows: [] as newsType[],
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

  const getInfo = () => postsServices.get(`offset=${posts.offset}&${new URLSearchParams(route.query as Params).toString()}`)

  const {
    route,
    setSearch,
    loadScroll
  } = useTableGrid(posts, getInfo)

  const getServices = async (query: string) => {
    try {
      loaded.value = false
      const response = await postsServices.get(query)
      posts.rows = response.data.rows.map(e => {
        return {
          ...e,
          imagen: `${url}/${e.imagen}`
        }
      })
      posts.search = response.data.search
      posts.sort = response.data.sort
      posts.direction = response.data.direction
      posts.offset = 10
    } catch (error) {

    } finally {
      loaded.value = true
    }
  }

  const sendEmail = async (id?: string) => {
    if (id === undefined) return

    const post = posts.rows.find(e => e.id == id)

    const confirm = await questionSweet('Info', `¿Estás seguro que desea enviar <strong>${post.titulo}`, 'question')

    if (!confirm) return

    try {
      await postsServices.email(id)
      alertWithToast('Enviado Correctamente', 'success')
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }


  const deleteService = async (id?: string) => {
    if (id === undefined) return

    const post = posts.rows.find(e => e.id == id)

    const confirm = await questionSweet('Info', `¿Estás seguro que desea eliminar el <strong>${post.titulo}`, 'question')

    if (!confirm) return

    try {
      await postsServices.delete(id)
      alertWithToast('Eliminado Correctamente', 'success')
      await getServices(new URLSearchParams(route.query as Params).toString())
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }

  onBeforeRouteUpdate(async (to, from) => {
    if (to.query !== from.query && (to.name == 'news')) {
      await getServices(
        new URLSearchParams(to.query as Params).toString()
      )
    }
  })

  return {
    posts,
    isOpenCreate,
    sending,
    route,
    loaded,
    getServices,
    deleteService,
    setSearch,
    loadScroll,
    sendEmail
  }
}

