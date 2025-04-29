import { ref } from "vue"
import type { earningType } from "../types/EarningType"
import earningsServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { useRouter } from "vue-router"
import { getDolar } from "@/modules/Auth/services/configService"

export default () => {
  const earnings = ref({
    rows: [] as earningType[],
    links: [] as string[],
    page: "1",
    search: "",
    sort: "",
    direction: ""
  })

  const dolar = ref(0)

  const url = import.meta.env.VITE_APP_API_URL

  const sending = ref(false)
  const data = ref<earningType>({
    id: '',
    type: "",
    tower: '',
    mount_dollars: 0,
    mount_bs: 0,
    dollarBefore: 0,
    image: '',
    facture: false
  })

  const router = useRouter()

  const showEarning = async (id: string) => {
    if (!id) return
    try {
      const response = await earningsServices.showEarning(id)
      data.value = {
        ...response.data,
        image: `${url}/${response.data.image}`
      }
      data.value.id = id
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      router.push('/earnings').then(() => alertWithToast(message, 'error'))
    }
  }

  const getDollarBcv = async () => {
    try {
      const response = await getDolar()
      dolar.value = response.data.dolar
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      router.push('/earnings').then(() => alertWithToast(message, 'error'))
    }
  }

  const insertEarning = async (form: any) => {
    try {
      const response = await earningsServices.insertEarning(form)
      return response.data.message
    } catch (error) {
      throw error
    }
  }

  const updateEarning = async (form: any) => {
    try {
      const response = await earningsServices.updateEarning(data.value.id, form)
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
      if (data.value.id) form.append('_method', 'PUT');

      sending.value = true
      const response = !data.value.id ? await insertEarning(form) : await updateEarning(form)
      router.push('/earnings').then(() => alertWithToast(response, 'success'))
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
    earnings,
    data,
    sending,
    showEarning,
    submit,
    getDollarBcv,
  }
}

