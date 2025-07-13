import { onMounted, onUnmounted, reactive, ref } from "vue"
import { useRoute, useRouter } from "vue-router"
import type { boardType } from "../types/boardType"
import { alertWithToast } from "@/utils/toast"
import postsServices from '../services'
import { questionSweet } from "@/utils/question"

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
        duration: ''
    })

    const apts = reactive({
        rows: [] as any[],
        porcent: 0,
        links: [] as string[],
        page: "1",
        search: "",
        sort: "",
        direction: "",
        offset: 0
    })

    const surveys = ref([])

    const route = useRoute()
    const router = useRouter()
    const uuidParams = route.params.uuid as string

    const loadingApt = ref(false)
    const seeClose = ref(false)
    const formSurvey = ref(false)
    const sending = ref(false)
    const surveyToVote = ref('0')

    let intervalId: number | null = null

    const getBoard = async (uuid: string) => {
        try {
            const response = await postsServices.show(uuid)
            board.value = response.data

            if (board.value.statusEnd) {
                stopTimer()
            } else {
                startTimer()
            }
        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        }
    }

    const getAptsBoard = async () => {
        if (loadingApt.value) return
        loadingApt.value = true
        try {
            const response = await postsServices.getApts(uuidParams)
            apts.rows = response.data.rows
            apts.porcent = response.data.porcent
            apts.search = response.data.search
            apts.sort = response.data.sort
            apts.direction = response.data.direction
            apts.offset = 10
        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        } finally {
            loadingApt.value = false
        }
    }

    const getSurveys = async () => {
        try {
            const response = await postsServices.getSurveys(uuidParams)

            if (response.data.message) return alertWithToast(response.data.message, 'info')
            surveys.value = response.data

        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        }
    }

    const initService = async () => {
        if (board.value.statusEnd) return alertWithToast('No se puede cambiar el estatus de una junta ya finalizada', 'warning')

        const confirm = await questionSweet('Info', `¿Estás seguro que desea comenzar la junta "<strong>${board.value.nombre}</strong>"?`, 'question')

        if (!confirm) return

        try {
            const response = await postsServices.statusChange(board.value.uuid)
            alertWithToast(response.data.message, 'success')
            getBoard(uuidParams)
        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        }
    }

    const endBoard = async (descripcion: string) => {
        if (sending.value) return
        sending.value = true
        const confirm = await questionSweet('Info', `¿Estás seguro que desea culminar la estatus actual de la junta "<strong>${board.value.nombre}</strong>"`, 'question')

        if (!confirm) return sending.value = false

        try {
            const response = await postsServices.boardEnd(board.value.uuid, descripcion)
            alertWithToast(response.data.message, 'success')
            seeClose.value = false
            getBoard(uuidParams)
        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        } finally {
            sending.value = false
        }
    }

    const changeLink = async (link: string) => {
        try {
            const response = await postsServices.changeLink(uuidParams, { link })
            alertWithToast(response.data.message, 'success')
            getBoard(uuidParams)
        } catch (error) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        }
    }

    const submitSurvey = async (payload: any) => {
        try {
            const response = await postsServices.storeSurvey(uuidParams, payload)
            alertWithToast(response.data.message, 'success')
            formSurvey.value = false
            getSurveys()
        } catch (error: any) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        }
    }

    const statusSurvey = async (id: string) => {
        if (sending.value) return
        sending.value = true
        const confirm = await questionSweet('Info', `¿Estás seguro que desea cambiar el estatus de esta propuesta?`, 'question')

        if (!confirm) return sending.value = false

        try {
            const response = await postsServices.statusSurvey(id)
            alertWithToast(response.data.message, 'success')
            getSurveys()
        } catch (error: any) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        }
    }

    const deleteSurvey = async (id: string) => {
        if (sending.value) return
        sending.value = true
        const confirm = await questionSweet('Info', `¿Estás seguro que desea eliminar esta propuesta`, 'question')

        if (!confirm) return sending.value = false

        try {
            const response = await postsServices.deleteSurvey(id)
            alertWithToast(response.data.message, 'success')
            getSurveys()
        } catch (error: any) {
            let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
            message = message.split('. (')[0]
            alertWithToast(message, 'error')
        }
    }


    const startTimer = () => {
        stopTimer()

        intervalId = window.setInterval(() => {
            if (board.value.statusEnd) {
                stopTimer()
            } else {
                getAptsBoard()
            }
        }, 600000)
    }

    const stopTimer = () => {
        if (intervalId) {
            clearInterval(intervalId)
            intervalId = null
        }
    }

    onMounted(() => {
        if (uuidParams) {
            getBoard(uuidParams)
            getAptsBoard()
            getSurveys()
        } else {
            router.back()
        }
    })

    onUnmounted(() => {
        stopTimer()
    })

    return {
        board,
        loadingApt,
        apts,
        seeClose,
        sending,
        formSurvey,
        surveys,
        surveyToVote,
        changeLink,
        endBoard,
        getAptsBoard,
        submitSurvey,
        getSurveys,
        statusSurvey,
        initService,
        deleteSurvey
    }
}