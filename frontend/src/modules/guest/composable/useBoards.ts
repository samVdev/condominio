import { alertWithToast } from "@/utils/toast"
import { ref } from "vue"
import servicesGuest from '../services'

export default () => {
    const boardsActive = ref([])

    const getBoardsAct = async () => {
        try {
            const response = await servicesGuest.getBoardsAct()
            boardsActive.value = response.data
        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        }
    }

    return {
        boardsActive,
        getBoardsAct
    }
}