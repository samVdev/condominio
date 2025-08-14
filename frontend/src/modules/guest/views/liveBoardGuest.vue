<script lang="ts" setup>
import Loader from '@/components/Loader.vue';
import useBoardLive from '../composable/useBoardLive';
import PollResults from '@/modules/boards/components/PollResults.vue';
import NotRecords from '@/components/notRecords.vue';
import FormSurvey from '@/components/FormSurvey.vue';

const {
    board,
    loadingBoard,
    surveys,
    surveyToVote,
    copiarLink,
    redirectToLink,
    getBoard,
    getSurveys
} = useBoardLive()

</script>

<template>
    <div class="px-4 text-center mx-auto md:w-[90%]">

        <FormSurvey v-if="surveyToVote != '0'" :survey="surveys.find(e => e.id == surveyToVote)"
            @close="surveyToVote = '0'" @getData="getSurveys"/>

        <div
            class="mx-auto mt-10 mb-2 flex items-center justify-between text-sm px-4 py-2 bg-white shadow rounded-lg border">
            <div class="flex items-center gap-2">
                <span :class="[
                    'h-2 w-2 rounded-full inline-block bg-green-500',
                ]"></span>
                <span class="text-gray-700">
                    Conectado a la junta
                </span>
            </div>
            <button class="text-blue-600 hover:text-blue-800 flex items-center gap-1" @click="getBoard"
                v-if="!loadingBoard">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v6h6M20 20v-6h-6M4 20l5-5M20 4l-5 5" />
                </svg>
                Recargar Junta
            </button>
            <Loader v-else />
        </div>

        <div class="mt-10 mx-auto flex flex-col md:flex-row items-center justify-center gap-6">

            <article class="bg-white shadow-lg rounded-xl p-6 w-full md:w-2/3">
                <div
                    class="w-14 h-14 mx-auto bg-gradient-to-r from-red-300 to-red-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 010 5.656l-1.414 1.414a4 4 0 01-5.656 0m1.414-1.414a4 4 0 010-5.656l1.414-1.414a4 4 0 015.656 0">
                        </path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold mt-4">{{ board.nombre }}</h2>
                <p class="text-gray-500 mb-4">Únete a la reunión programada</p>
                <button @click="redirectToLink" :disabled="!board.enlace" :class="[
                    'font-medium py-2 px-6 rounded-full transition',
                    board.enlace
                        ? 'bg-gradient-to-r from-red-300 to-red-500  text-white hover:opacity-90'
                        : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-50'
                ]">
                    {{ board.enlace ? 'Unirse a la Junta' : 'Sin enlace para la junta' }}
                </button>

            </article>
            <article class="md:w-1/3">
                <div class="w-full bg-white shadow-md rounded-xl p-4 text-left">
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Link de acceso</h3>
                    <div class="flex items-center gap-2 ">
                        <span class="text-sm text-blue-600 truncate">{{ board.enlace || 'Sin Enlace' }}</span>
                        <button @click="copiarLink" class="text-gray-400 hover:text-gray-600 transition" title="Copiar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-4 12h4a2 2 0 002-2v-8a2 2 0 00-2-2h-4a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mt-4 bg-white shadow-md rounded-xl p-4 w-full text-left">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Personas en la junta</h3>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0zm6 13v-2a4 4 0 00-3-3.87M4 18v-2a4 4 0 013-3.87" />
                        </svg>
                        <span>
                            {{ board.connectedUsers }} persona {{ board.connectedUsers === 1 ? '' : 's' }}
                            conectada{{ board.connectedUsers === 1 ? '' : 's' }}
                        </span>
                    </div>
                </div>
            </article>
        </div>

        <nav class="flex gap-5 items-center justify-left my-5">
            <h3 class="text-xl font-bold text-gray-800">Propuestas ({{ surveys.length }})</h3>
            <button title="recargar propuestas" @click="getSurveys" v-if="board.activa">
                <font-awesome-icon icon="rotate-right" class="block" />
            </button>
        </nav>

        <PollResults :id="poll.id" :question="poll.question" :options="poll.options"
            :totalPresentes="poll.totalPresentes" :response="poll.response" v-for="poll in surveys"
            v-if="surveys.length > 0" @reply="surveyToVote = poll.id" :activeSurvey="poll.active"/>
        <section v-else class="h-full scale-[.8] mt-10">
            <NotRecords />
        </section>


    </div>
</template>
