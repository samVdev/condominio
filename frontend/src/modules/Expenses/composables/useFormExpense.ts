import { ref } from "vue"
import type { expenseType } from "../types/ExpenseType"
import expensesServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { useRouter } from "vue-router"

export default () => {
  const expenses = ref({
    rows: [] as expenseType[],
    links: [] as string[],
    page: "1",
    search: "",
    sort: "",
    direction: ""
  })

  const url = import.meta.env.VITE_APP_API_URL

  const sending = ref(false)
  const data = ref<expenseType>({
    id: '',
    service: "",
    tower: '',
    mount_dollars: 0,
    mount_bs: 0,
    dollarBefore: 0,
    image: ''
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


  const submit = async (e) => {
    try {
      const form = new FormData(e.target)
      const keys = Object.keys(data.value)

      for (let index = 0; index < keys.length; index++) {
        const key = keys[index];
        form.append(key, data.value[key])
      }
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
    expenses,
    data,
    sending,
    showExpense,
    submit,
  }
}

