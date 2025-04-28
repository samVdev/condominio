import { ref } from "vue"
import type { newsType } from "../types/newsType"
import postsServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { useRouter } from "vue-router"


export default () => {
  const sending = ref(false)
  const data = ref<newsType>({
    id: '',
    titulo: '',
    subtitulo: '',
    imagen: '',
    usuario: '',
  })

  const router = useRouter()
  const url = import.meta.env.VITE_APP_API_URL

  const showService = async (id: string) => {
    try {
      const response = await postsServices.show(id)
      data.value = {
        ...response.data,
        imagen: `${url}/${response.data.imagen}`
      }
      data.value.id = id
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }

  const insertService = async (form: any) => {
    try {
      const response = await postsServices.insert(form)
      return response.data.message
    } catch (error) {
      throw error
    }
  }

  const updateService = async (form: any) => {
    try {
      const response = await postsServices.update(data.value.id, form)
      return response.data.message
    } catch (error) {
      throw error
    }
  }


  const submit = async (e) => {
    try {
      const form = new FormData(e.target)
      const keys = Object.keys(data.value)

      for (let index = 0; index < keys.length; index++) {
        const key = keys[index];
        form.append(key, data.value[key])
      }
      
      if(data.value.id) form.append('_method', 'PUT');

      sending.value = true
      const response = !data.value.id ? await insertService(form) : await updateService(form)
      router.push('/news').then(() => alertWithToast(response, 'success'))
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    } finally {
      sending.value = false
    }
  }


  return {
    data,
    sending,
    showService,
    submit,
  }
}

