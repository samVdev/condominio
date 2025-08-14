import { useRouter } from "vue-router"
import ApartamentsServices from '../../services'
import type { towersType } from "../../types/towersType"
import { alertWithToast } from "@/utils/toast"
import { ref } from "vue"

export default () => {
    const data = ref<towersType>({
        id: '',
        tower: '-1',
        name: '',
        porcent: '',
        sizes: '',
        persona: ''
    })

    const sending = ref(false)
    const router = useRouter()

    const showApt = async (id: string) => {
        if (!id) return
        try {
            const response = await ApartamentsServices.showApt(id)
            data.value = {
                ...response.data,
                id
            }
        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            router.push('/condominium/apt').then(() => alertWithToast(message, 'error'))
        }
    }

    const insertApt = async (form: any) => {
        try {
            const response = await ApartamentsServices.insertApt(form)
            return response.data.message
        } catch (error) {
            throw error
        }
    }

    const updateApt = async (form: any) => {
        try {
            const response = await ApartamentsServices.updateApt(data.value.id, form)
            return response.data.message
        } catch (error) {
            throw error
        }
    }


    const submit = async (e) => {
        try {
            sending.value = true
            const response = !data.value.id ? await insertApt(data.value) : await updateApt(data.value)
            router.push('/condominium/apt').then(() => alertWithToast(response, 'success'))
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
        showApt,
        submit
    }
}