import { ref } from "vue"
import type { factureType } from "../types/factureType"
import facturesServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { useRoute, useRouter } from "vue-router"
import getDate from "@/utils/getDate"

export default () => {
  const expenses = ref({
    rows: [] as factureType[],
    links: [] as string[],
    page: "1",
    search: "",
    sort: "",
    direction: ""
  })

  const sending = ref(false)
  const data = ref<factureType>({
    id: '',
    month: '',
    mount_bs: 0,
    dollar_bcv: 0,
    code: '',
    mount_dollars: 0,
    porcent: 0,
    created: getDate()
  })

  const router = useRouter()

  const insertFacture = async () => {
    try {
      const response = await facturesServices.insertFacture(data.value)
      return response.data
    } catch (error) {
      throw error
    }
  }

  const submit = async () => {
    try {
      sending.value = true
      const response = await insertFacture()
      router.push('/factures').then(() => {
        alertWithToast(response.message, 'success')
        if(response.messEar) alertWithToast(response.messEar, 'warning')
      })
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    } finally {
      sending.value = false
    }
  }

  return {
    expenses,
    data,
    sending,
    submit,
  }
}

