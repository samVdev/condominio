import { alertWithToast } from "@/utils/toast"
import { onMounted, onUnmounted, ref } from "vue"
import servicesGuest from '../services'
import { useRoute, useRouter } from "vue-router"
import type { boardType } from "@/modules/boards/types/boardType"

export default () => {
    const board = ref<boardType>({
        uuid: '',
        nombre: '',
        descripcion: '',
        fecha: '',
        activa: false,
        statusEnd: false,
        description_end: '',
        enlace: '',
        duration: '',
        connectedUsers: 0
    })
    const route = useRoute()
    const router = useRouter()
    const loadingBoard = ref(false)

    const surveyToVote = ref('0')

    const surveys = ref([])

    const uuid = route.params.uuid as string

    const getBoard = async () => {
        if (loadingBoard.value) return

        loadingBoard.value = true
        try {
            const response = await servicesGuest.getBoard(uuid)
            board.value = response.data
        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        } finally {
            loadingBoard.value = false
        }
    }


    const disconnect = async () => {
        try {
            await servicesGuest.disconnect(uuid)
        } catch (error) {
        }
    }

    function copiarLink() {
        if (!board.value.enlace) return alertWithToast('La junta aun no tiene un enlace', 'info')
        navigator.clipboard.writeText(board.value.enlace)
    }

    const redirectToLink = () => {
        if (!board.value.enlace) return alertWithToast('La junta aun no tiene un enlace', 'info')
        window.open(board.value.enlace, '_blank');
    }

    const handleBeforeUnload = (event: BeforeUnloadEvent) => {
        disconnect()
        event.preventDefault()
        event.returnValue = ''
    }


    const getSurveys = async () => {
        try {
            const response = await servicesGuest.getSurveys(uuid)
            if (response.data.message) return 
            surveys.value = response.data
        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        }
    }

    onMounted(() => {
        if (uuid) {
            getBoard()
            getSurveys()
        } else {
            router.back()
        }
        window.addEventListener('beforeunload', handleBeforeUnload)
    })

    onUnmounted(() => {
        disconnect()
        window.removeEventListener('beforeunload', handleBeforeUnload)
    })

    return {
        board,
        surveys,
        loadingBoard,
        surveyToVote,
        getBoard,
        copiarLink,
        redirectToLink,
        getSurveys,
    }
}