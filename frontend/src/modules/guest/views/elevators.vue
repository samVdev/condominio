<script setup lang="ts">
import tablesHeader from "@/components/tablesHeader.vue"
import Loader from "@/components/Loader.vue";
import { onMounted } from "vue";
import type { Params } from "@/types/params";
import NotRecords from "@/components/notRecords.vue";
import ActionsTable from "@/components/actionsTable.vue";
import { onBeforeRouteUpdate } from "vue-router";
import useIndex from '@/modules/Apartaments/composables/elevators/useIndex'

const {
    data,
    route,
    loaded,
    getElevators,
    setSort,
    loadScroll,
    setSearch,
} = useIndex()

onMounted(() => getElevators(new URLSearchParams(route.query as Params).toString()))

onBeforeRouteUpdate(async (to, from) => {
    if (to.query !== from.query && (from.path == '/guest/elevators' && to.path == '/guest/elevators')) {
        await getElevators(
            new URLSearchParams(to.query as Params).toString()
        )
    }
})
</script>

<template>
    <main>
        <tablesHeader title="Ascensores" icon="elevator" :searchActive="true" @setSearch="({ e }) => setSearch(e)"
            :btnCreate="false" />


        <router-view v-slot="{ Component }">
            <Transition name="expandModal" :style="{ '--modal-top': `50%`, '--modal-left': `50%` }">
                <div v-if="$route.path.includes('/guest/elevators/history')"
                    class="overlay w-full grid place-items-center bg-[#000000ab]"
                    :class="$route.path.includes('/guest/elevators/history') ? '!p-0' : ''">
                    <component :is="Component" :key="$route.path" class="bg-white">
                        <label class="absolute top-3 right-5 cursor-pointer font-semibold text-2xl"
                            @click="$router.push('/guest/elevators')">x</label>
                    </component>
                </div>
            </Transition>
        </router-view>

        <section class="relative my-4 overflow-auto animate-fade-in mx-auto md:w-[90%]">

            <div class="fakeTable overflow-hidden table-animation h-[70vh]" @scroll="loadScroll">
                <article class="fakeTable-head grid-cols-4">
                    <a to="#" class="cursor-pointer" @click.prevent="setSort('number')">
                        Número de ascensor
                        <font-awesome-icon icon="sort" class="ml-2" />
                    </a>
                    <a to="#" class="cursor-pointer" @click.prevent="setSort('tower')">
                        Torre
                        <font-awesome-icon icon="sort" class="ml-2" />
                    </a>
                    <a to="#" class="cursor-pointer" @click.prevent="setSort('status')">
                        Estado
                        <font-awesome-icon icon="sort" class="ml-2" />
                    </a>
                    <p>Acción</p>
                </article>

                <section v-if="data.rows.length > 0">
                    <div v-for="row in data.rows" :key="row.id" class="fakeTable-body grid-cols-4">
                        <p>{{ row.number }}</p>
                        <p>{{ row.tower }}</p>
                        <p class="flex justify-center items-center gap-4"
                            :class="row.status ? 'text-green-700' : 'text-red-500'">
                            <label class="font-bold">{{ row.status ? 'Operativo' : 'Dañado' }}</label>
                            <font-awesome-icon :icon="row.status ? 'circle-check' : 'circle-xmark'" class="scale-[1.5]"
                                :title="row.status ? 'Operativo' : 'Dañado'" />
                        </p>
                        <p>
                            <ActionsTable :historyBtn="true"
                                @history="() => $router.push({ name: 'elevatorHistoryGuest', query: { elevator: row.id } })" />
                        </p>
                    </div>
                </section>

                <div class="FadeTR" v-else>
                    <Loader v-if="!loaded" class="mx-auto mt-5" />
                    <NotRecords v-else />
                </div>

            </div>

        </section>

    </main>
</template>
