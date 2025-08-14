import { ref } from "vue"
import elevatorsServices from '../../services/elevators'
import { alertWithToast } from "@/utils/toast"
import { useRouter } from "vue-router"

export default () => {

  const form = ref({
    description: '',
    image: '',
  })

  const router = useRouter()
  const id = ref('')

  const reportElevator = async (e: any) => {
    if (id.value === undefined) return

    try {
      const formData = new FormData(e.target)
      const keys = Object.keys(form.value)

      for (let index = 0; index < keys.length; index++) {
        const key = keys[index];
        formData.append(key, form.value[key])
      }

      formData.append('_method', 'PUT');

      await elevatorsServices.reportElevator(id.value, formData)
      router.push('/condominium/elevators').then(() => {
        alertWithToast('Reportado Correctamente', 'success')
      })

    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    }
  }




  return {
    reportElevator,
    form,
    id
  }

}

