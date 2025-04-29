import { ref } from "vue"
import type { provisionType } from "../types/ProvisionType"
import provisionsServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { useRouter } from "vue-router"
import { getDolar } from "@/modules/Auth/services/configService"

export default () => {
  const provisions = ref({
    rows: [] as provisionType[],
    links: [] as string[],
    page: "1",
    search: "",
    sort: "",
    direction: ""
  })

  const dolar = ref(0)

  const url = import.meta.env.VITE_APP_API_URL

  const sending = ref(false)
  const data = ref<provisionType>({
    id: '',
    service: "",
    tower: '0',
    mount_dollars: 0,
    mount_bs: 0,
    month: '',
    facture: false,
    pay: false
  })

  const router = useRouter()

  const showProvision = async (id: string) => {
    if (!id) return
    try {
      const response = await provisionsServices.showProvision(id)
      data.value = {
        ...response.data,
        image: `${url}/${response.data.image}`
      }
      data.value.id = id
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      router.push('/provisions').then(() => alertWithToast(message, 'error'))
    }
  }

  const getDollarBcv = async () => {
    try {
      const response = await getDolar()
      dolar.value = response.data.dolar
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      router.push('/provisions').then(() => alertWithToast(message, 'error'))
    }
  }

  const insertProvision = async (form: any) => {
    try {
      const response = await provisionsServices.insertProvision(form)
      return response.data.message
    } catch (error) {
      throw error
    }
  }

  const updateProvision = async (form: any) => {
    try {
      const response = await provisionsServices.updateProvision(data.value.id, form)
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
      const response = !data.value.id ? await insertProvision(form) : await updateProvision(form)
      router.push('/provisions').then(() => alertWithToast(response, 'success'))
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    } finally {
      sending.value = false
    }
  }

  return {
    dolar,
    provisions,
    data,
    sending,
    showProvision,
    submit,
    getDollarBcv,
  }
}

