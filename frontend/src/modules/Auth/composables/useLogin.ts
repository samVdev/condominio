import { ref } from "vue"
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/modules/Auth/stores'
import * as AuthService from "@/modules/Auth/services";
import type { FormLogin} from '@/modules/Auth/types/Auth'
import { alertWithToast } from "@/utils/toast";

export function useLogin() {
  const router = useRouter();
  const auth = useAuthStore()
  const sending = ref(false)

  const login = async (form: FormLogin) => {
    const payload = {
      email: form.email,
      password: form.password,
    }
    try {
      sending.value = true;
     await AuthService.login(payload);
      const authUser = await auth.getAuthUser();
      if (authUser) {
        auth.setGuest({ value: "isNotGuest" });
        if(authUser.isAdmin) await router.push("/dashboard");
        else await router.push("/home");
      }
    } catch (err) {
      const message = err.response.data.errors.msg || 'Error inesperado';
      alertWithToast(message, 'error')

    } finally {
      sending.value = false;
    }
  }

  return {
    login,
    sending,
  }
}
