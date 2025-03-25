import { reactive, ref } from "vue"
import type { expenseType } from "../types/ExpenseType"
import expensesServices from '../services'
import { alertWithToast } from "@/utils/toast"
import { questionSweet } from "@/utils/question"
import useTableGrid from "@/composables/useTableGrid"
import { onBeforeRouteUpdate } from "vue-router"
import type { Params } from "@/types/params"



export default () => {
  const expenses = reactive({
    rows: [] as expenseType[],
    links: [] as string[],
    search: "",
    sort: "",
    direction: "",
    offset: 0
  })

  const viewImage = ref('')
  const loaded = ref(false)

  const getInfo = () => expensesServices.getExpenses(`offset=${expenses.offset}&${new URLSearchParams(route.query as Params).toString()}`)

  const {
    route,
    setSearch,
    setSort,
    loadScroll,
  } = useTableGrid(expenses, getInfo)


  const getExpenses = async (query: string) => {
    try {
      loaded.value = false
      const response = await expensesServices.getExpenses(query)
      expenses.rows = response.data.rows
      expenses.search = response.data.search
      expenses.sort = response.data.sort
      expenses.direction = response.data.direction
      expenses.offset = 10
    } catch (error) {

    } finally {
      loaded.value = true

    }
  }

  const deleteExpense = async (id?: string) => {
    if (id === undefined) return

    const expense = expenses.rows.find(e => e.id == id)

    const confirm = await questionSweet('Info', `¿Estás seguro que desea eliminar el <strong>${expense.name}`, 'question')

    if (!confirm) return

    try {
      await expensesServices.deleteExpense(id)
      alertWithToast('Eliminado Correctamente', 'success')
      await getExpenses(new URLSearchParams(route.query as Params).toString())
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }


  onBeforeRouteUpdate(async (to, from) => {
    if (to.query !== from.query && (to.name == 'expenses' || to.name == 'expensesUser')) {
      await getExpenses(
        new URLSearchParams(to.query as Params).toString()
      )
    }
  })

  return {
    expenses,
    route,
    loaded,
    viewImage,
    setSearch,
    setSort,
    loadScroll,
    getExpenses,
    deleteExpense,
  }
}

