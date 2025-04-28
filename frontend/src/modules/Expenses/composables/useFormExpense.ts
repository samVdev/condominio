import { ref } from "vue"
import type { expenseType } from "../types/ExpenseType"
import expensesServices from '../services'
import provisionsServices from '@/modules/Provisions/services'
import { alertWithToast } from "@/utils/toast"
import { useRouter } from "vue-router"
import { getDolar } from "@/modules/Auth/services/configService"

export default () => {
  const expenses = ref({
    rows: [] as expenseType[],
    links: [] as string[],
    page: "1",
    search: "",
    sort: "",
    direction: ""
  })

  const dolar = ref(0)

  const url = import.meta.env.VITE_APP_API_URL

  const sending = ref(false)
  const data = ref<expenseType>({
    id: '',
    service: "",
    tower: '',
    mount_dollars: 0,
    mount_bs: 0,
    dollarBefore: 0,
    facture: false,
    image: ''
  })

  const provision = ref<any>({
    checked: false,
    total: 0
  })

  const router = useRouter()

  const showExpense = async (id: string) => {
    if (!id) return
    try {
      const response = await expensesServices.showExpense(id)
      data.value = {
        ...response.data,
        image: `${url}/${response.data.image}`
      }
      data.value.id = id
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      router.push('/expenses').then(() => alertWithToast(message, 'error'))
    }
  }

  const getDollarBcv = async () => {
    try {
      const response = await getDolar()
      dolar.value = response.data.dolar
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      router.push('/expenses').then(() => alertWithToast(message, 'error'))
    }
  }

  const insertExpense = async (form: any) => {
    try {
      const response = await expensesServices.insertExpense(form)
      return response.data.message
    } catch (error) {
      throw error
    }
  }

  const updateExpense = async (form: any) => {
    try {
      const response = await expensesServices.updateExpense(data.value.id, form)
      return response.data.message
    } catch (error) {
      throw error
    }
  }

  
  const checkProvision = async () => {
    try {
      const response = await provisionsServices.checkProvision(data.value.service, data.value.id || '0')
      provision.value = {
        checked: true,
        total: response.data.total ? response.data.total : 0
      }
      if(response.data.total)  alertWithToast(`Se a encontrado una provisión de ${response.data.total}$`, 'info')
    } catch (error) {
      console.log(error)
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
      const response = !data.value.id ? await insertExpense(form) : await updateExpense(form)
      router.push('/expenses').then(() => alertWithToast(response, 'success'))
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
    expenses,
    data,
    sending,
    provision,
    showExpense,
    submit,
    getDollarBcv,
    checkProvision,
  }
}

