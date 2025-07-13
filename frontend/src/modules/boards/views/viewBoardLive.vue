<script lang="ts" setup>
import { parseDate } from '@/utils/parseDate'
import ParticipantCard from '../components/ParticipantCard.vue'
import PollResults from '../components/PollResults.vue'
import useLiveBoards from '../composables/useLiveBoards'
import CloseBoards from '../components/closeBoards.vue'
import LinkInput from '../components/linkInput.vue'
import CreateSurvey from '../components/createSurvey.vue'
import NotRecords from '@/components/notRecords.vue'
import { useAuthStore } from '@/modules/Auth/stores'
import FormSurvey from '@/components/FormSurvey.vue'

const {
    board,
    apts,
    loadingApt,
    seeClose,
    sending,
    formSurvey,
    surveys,
    surveyToVote,
    endBoard,
    getAptsBoard,
    changeLink,
    submitSurvey,
    getSurveys,
    statusSurvey,
    initService,
    deleteSurvey
} = useLiveBoards()

const store = useAuthStore()

</script>

<template>
    <section class="min-h-screen p-6 w-[90%] mx-auto">

        <CloseBoards v-if="seeClose" :sending="sending" @submit="endBoard" @close="seeClose = false" />

        <CreateSurvey v-if="formSurvey" :sending="sending" @submit="submitSurvey" @close="formSurvey = false" />

        <FormSurvey v-if="surveyToVote != '0'" :survey="surveys.find(e => e.id == surveyToVote)"
            @close="surveyToVote = '0'" @getData="getSurveys" />

        <div class="gap-4 w-full md:flex">
            <div class="mb-6 md:w-[90%]">
                <article class="grid place-items-center mb-5 md:flex md:justify-between md:items-center mx-auto">

                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium"
                                :class="board.activa
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-600'">
                                <span v-if="board.activa" class="h-2 w-2 rounded-full bg-green-500 animate-ping"></span>
                                {{ board.activa ? 'Activado' : 'Inactivo' }}
                            </span>

                            <h1 class="text-2xl font-bold text-gray-800 truncate">
                                {{ board.nombre }}
                            </h1>
                        </div>

                        <div class="text-sm text-gray-500 flex items-center gap-2">
                            <span class="inline-flex items-center gap-1">
                                📅
                                <span>{{ parseDate(board.fecha) }}</span>
                            </span>
                        </div>

                        <div v-if="board.statusEnd" class="text-sm text-gray-500 flex items-center gap-2">
                            <span class="inline-flex items-center gap-1">
                                ⏱️
                                <span>{{ board.duration }}</span>
                            </span>
                        </div>

                        <div v-if="board.description_end" class="text-sm text-gray-700">
                            <p class="font-semibold text-gray-800 mb-1">
                                📝 Descripción de finalización:
                            </p>
                            <p class="pl-1 border-l-2 border-gray-300 ml-1">{{ board.description_end }}</p>
                        </div>

                        <div>
                            <h4 class="text-base font-semibold text-gray-800 mb-1 flex items-center gap-1">
                                🔗 Enlace:
                            </h4>
                            <div v-if="board.description_end" class="text-sm text-blue-600 break-all">
                                {{ board.enlace }}
                            </div>
                            <LinkInput v-else :modelValue="board.enlace" @changeLink="changeLink" />
                        </div>
                    </div>


                    <button type="button"
                        class="bg-red-500 text-white font-bold w-[50vw] md:w-[20%] gap-2 h-[50px] text-center rounded-2xl px-4 transition-all hover:bg-red-400"
                        @click="initService" v-if="board && !board.activa && !board.statusEnd">
                        Comenzar junta
                    </button>

                    <button type="button"
                        class="bg-blue-600 text-white font-bold w-[50vw] md:w-[20%] gap-2 h-[50px] text-center rounded-2xl px-4 transition-all hover:bg-blue-500"
                        @click="seeClose = true" v-if="board && board.activa && !board.statusEnd">
                        Terminar junta
                    </button>
                </article>

                <nav class="flex gap-5 items-center justify-left mb-5">
                    <h3 class="text-xl font-bold text-gray-800">Apartamentos conectados ({{ apts.porcent }}%)</h3>
                    <button title="Recargar apartamentos" @click="getAptsBoard" v-if="!loadingApt && board.activa">
                        <font-awesome-icon icon="rotate-right" />
                    </button>
                </nav>
                <div class="flex flex-wrap gap-4">
                    <ParticipantCard v-for="(participant, index) in apts.rows" :key="index" :name="participant.apt"
                        :connected="participant.connected"
                        :connectedText="participant.connected && !board.statusEnd ? 'Conectado' : board.statusEnd && participant.connected ? 'Asistió' : 'Ausente'" />
                </div>
            </div>

            <aside class="md:w-[30%]">

                <nav class="flex gap-5 items-center justify-between mb-5">
                    <h3 class="text-xl font-bold text-gray-800">Propuestas</h3>

                    <div class="flex justify-center items-center gap-2">
                        <button title="Nueva propuesta" class="block" @click="formSurvey = true" v-if="board.activa">
                            <font-awesome-icon icon="plus" />
                        </button>
                        <button title="recargar propuestas" @click="getSurveys" v-if="board.activa">
                            <font-awesome-icon icon="rotate-right" class="block" />
                        </button>
                    </div>
                </nav>
                <PollResults :id="poll.id" :question="poll.question" :options="poll.options"
                    :totalPresentes="poll.totalPresentes" :isAdmin="store.authUser.isAdmin" @delete="deleteSurvey"
                    @status="statusSurvey" :activeSurvey="poll.active" :response="true" v-for="poll in surveys"
                    v-if="surveys.length > 0" />
                <section v-else class="h-full scale-[.8]">
                    <NotRecords />
                </section>
            </aside>
        </div>
    </section>
</template>
