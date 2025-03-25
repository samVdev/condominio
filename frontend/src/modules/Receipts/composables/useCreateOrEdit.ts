import { onMounted, reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import useHttp from "@/composables/useHttp";
import UserService from "@/modules/User/services";
import type Role from "../types/Role"
import type User from "../types/User"
import { alertWithToast } from '@/utils/toast';

export default (userId?: string) => {
  const router = useRouter();
  
  const user: User = reactive({    
    name: "", 
    email: "", 
    password: "", 
    phone: "", 
    role_id: "",
    apt_id: "",
    suspend: false
  })
 
  const roles = ref<Role[]>([])
  
  const {  
    errors,
    sending,
    loading,
  } = useHttp()
  
  onMounted(() => {
    if (userId) getUser()
      getRoles()
  })

  const getUser = async () => {
    loading.value = true
    const response = await UserService.getUser(userId)
    user.name = response.data.name
    user.email = response.data.email
    user.phone = response.data.phone
    user.password = null
    user.role_id = response.data.role_id        
    user.apt_id = response.data.apt_id
    user.suspend = response.data.suspend
  }

  const getRoles = async () => {
    loading.value = true
    const responseRoles = await UserService.helperTablesGet()
    roles.value = responseRoles.data.roles
  }

  const insertUser = async (user: User) => {  
  try {
    const response = await UserService.insertUser(user)
    return response.data.message
  } catch (error) {
    throw error
  }
  }

  const updateUser = async (user: User, userId: string) => {
   try {
    const response = await UserService.updateUser(userId, user)
    return response.data.message
   } catch (error) {
    throw error
   }
  }
  
  const submit = async (user: User, userId?: string) => {  
    try {
    sending.value = true
    const response = !userId ? await insertUser (user)  : await updateUser(user, userId)
      router.push( { path: '/users' } ).then(() => alertWithToast(response, 'success'))
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      message = message.split('. (')[0]
      alertWithToast(message, 'error')
    } finally{
      sending.value= false
    }
  }

  return {
    user,
    errors,
    roles,
    sending,
    loading,
    router,

    submit    
  }

}
