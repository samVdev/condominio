import { ref } from "vue"
import type { serviceType } from "../types/serviceType"
import ApartamentsServices from '../services'
import type { towersType } from "../types/towersType"

export default () => {
  const towers = ref<towersType[]>([])

  const getTowers = async () => {
    const response = await ApartamentsServices.getTowers()
    towers.value = response.data
  }

  return {
    towers,
    getTowers,
  }
}

