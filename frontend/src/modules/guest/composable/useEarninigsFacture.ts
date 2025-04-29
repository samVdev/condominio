import { reactive, ref } from "vue"
import facturesUser from '../services'
import type { Params } from "@/types/params"
import { useRoute, useRouter } from "vue-router"
import { alertWithToast } from "@/utils/toast"
import type { earningType } from "@/modules/Earnings/types/EarningType"

export default () => {
  const data = reactive({
    rows: [] as earningType[],
    links: [] as string[],
    search: "",
    offset: 0
  })

  const route = useRoute()
  const router = useRouter()
  const loaded = ref(false)
  const isFetching = ref(false);
  const moreScroll = ref(true);

  const getEarninigs = async () => {
    try {
      const response = await facturesUser.getEarningsFacture(`${new URLSearchParams(route.query as Params).toString()}`)
      data.rows = response.data.rows
      data.search = response.data.search
      data.offset = 10
    } catch (error) {
      let message = error.response ? error.response.data.message : 'Ha ocurrido un error inesperado'
      router.push('/home').then(() => alertWithToast(message, 'error'))
    } finally {
      loaded.value = true
    }
  }


  const loadScroll = async (e: Event) => {

    const target = e.currentTarget as HTMLElement;

    if (isFetching.value || !moreScroll.value) return;
    isFetching.value = true;

    const scrollTopBefore = target.scrollTop;

    target.style.pointerEvents = "none";
    target.style.scrollBehavior = "auto";

    const { scrollTop, clientHeight, scrollHeight } = target;

    if (scrollTop + clientHeight >= scrollHeight - 5) {

      const response = await facturesUser.getEarningsFacture(`${new URLSearchParams(route.query as Params).toString()}&offset=${data.offset}`);
      if (response.data.rows.length > 0) {
        data.rows.push(...response.data.rows)
        moreScroll.value = true
        data.offset += 10
      } else {
        moreScroll.value = false
        setTimeout(() => {
          moreScroll.value = true;
        }, 10000);
      }

      requestAnimationFrame(() => {
        target.scrollTop = scrollTopBefore;
        target.style.pointerEvents = "auto";
        isFetching.value = false;
      });

    } else {
      isFetching.value = false;
      target.style.pointerEvents = "auto";
    }
  };


  return {
    data,
    loaded,
    getEarninigs,
    loadScroll
  }
}