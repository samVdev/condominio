import { useRouter } from "vue-router"
import elevatorServices from '../../services/elevators'
import { alertWithToast } from "@/utils/toast"
import { ref } from "vue"
import type { elevatorType } from "../../types/elevatorType"

export default () => {
    const data = ref<elevatorType>({
        id: '',
        tower: '-1',
        number: '',
        tower_id: '',
        status: false
    })

    const sending = ref(false)
    const router = useRouter()

    const showElevator = async (id: string) => {
        if (!id) return
        try {
            const response = await elevatorServices.showElevator(id)
            data.value = {
                ...response.data,
                id
            }
        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            router.push('/condominium/elevators').then(() => alertWithToast(message, 'error'))
        }
    }

    const insertElevator = async (form: any) => {
        try {
            const response = await elevatorServices.insertElevator(form)
            return response.data.message
        } catch (error) {
            throw error
        }
    }

    const updateElevator = async (form: any) => {
        try {
            const response = await elevatorServices.updateElevator(data.value.id, form)
            return response.data.message
        } catch (error) {
            throw error
        }
    }


    const submit = async (e) => {
        try {
            sending.value = true
            const response = !data.value.id ? await insertElevator(data.value) : await updateElevator(data.value)
            router.push('/condominium/elevators').then(() => alertWithToast(response, 'success'))
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
        showElevator,
        submit
    }
}