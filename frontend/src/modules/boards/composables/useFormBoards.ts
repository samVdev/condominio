import { ref } from "vue"
import postsServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { useRouter } from "vue-router"
import type { boardType } from "../types/boardType"


export default () => {
  const sending = ref(false)
  const now = ref(new Date())
  const form = ref<boardType>({
    uuid: '',
    nombre: '',
    descripcion: '',
    fecha: '',
    activa: false,
    statusEnd: false,
    description_end: '',
    enlace: '',
    duration: ''
  })

  const router = useRouter()
  const url = import.meta.env.VITE_APP_API_URL

  const showService = async (uuid: string) => {
    try {
      const response = await postsServices.show(uuid)
      form.value = {
        ...response.data,
        imagen: `${url}/${response.data.imagen}`
      }
      form.value.uuid = uuid
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }

  const insertService = async (formData: any) => {
    try {
      const response = await postsServices.insert(formData)
      return response.data.message
    } catch (error) {
      throw error
    }
  }

  const updateService = async (formData: any) => {
    try {
      const response = await postsServices.update(form.value.uuid, formData)
      return response.data.message
    } catch (error) {
      throw error
    }
  }


  const submit = async (e: any) => {
    try {
      /*const formData = new FormData(e.target)
      const keys = Object.keys(form.value)

      for (let index = 0; index < keys.length; index++) {
        const key = keys[index];
        formData.append(key, form.value[key])
      }
      
      if(form.value.id) formData.append('_method', 'PUT');*/

      sending.value = true
      const response = !form.value.uuid ? await insertService(form.value) : await updateService(form.value)
      router.push('/boards').then(() => alertWithToast(response, 'success'))
    } catch (error) {
      console.log(error)
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    } finally {
      sending.value = false
    }
  }


  return {
    form,
    now,
    sending,
    showService,
    submit,
  }
}

