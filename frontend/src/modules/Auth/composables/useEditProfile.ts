import { ref } from "vue";
import { useAuthStore } from "../stores"
import { useRouter } from "vue-router";
import { postInfoUserService, postPassowrdsUserService } from "../services";
import { alertWithToast } from "@/utils/toast";

export default () => {

    const store = useAuthStore()
    const router = useRouter()

    const userInfo = ref({
        name: '',
        email: '',
        tel: '',
    })
    
    const passwords = ref({
        current: '',
        newPassword: '',
        confirmNewPassword: '',
    })

    const updateUser = async () => {
        const data = await store.getAuthUser()
        if (!data) return router.back()
        userInfo.value = {
            name: data.fullName,
            email: data.email,
            tel: data.phoneNumber,
        }
    }

    const submitInfoUser = async () => {
        try {
            const response = await postInfoUserService(userInfo.value)
            await store.getAuthUser()
            router.back()
            setTimeout(() => {
                alertWithToast(response.data.data.msg, 'success');
            }, 100); 
        } catch (error) {
            let message = 'Error inesperado';
            if (error.response) {
                message = error.response.data.errors.msg;
            }
            alertWithToast(message, 'error')
        }
    }

    const submitPasswordUser = async () => {
        try {
            const response = await postPassowrdsUserService(passwords.value)
            router.back()
            setTimeout(() => {
                alertWithToast(response.data.data.msg, 'success');
            }, 100); 
        } catch (error) {
            let message = 'Error inesperado';
            if (error.response) {
                message = error.response.data.errors.msg;
            }
            alertWithToast(message, 'error')
        }
    }

    return {
        updateUser,
        submitInfoUser,
        submitPasswordUser,
        userInfo,
        passwords
    }
}