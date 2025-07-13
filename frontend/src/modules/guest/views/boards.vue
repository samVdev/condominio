<script setup lang="ts">
import NoInfo from '@/components/noInfo.vue';
import BoardCard from '../../../components/boardCard.vue';
import useBoards from '../composable/useBoards';
import { onMounted } from 'vue';

const {
    boardsActive,
    getBoardsAct
} = useBoards()


onMounted(() => {
    getBoardsAct()
})

</script>

<template>
    <main class="px-10">
        <div class="pr-20 text-left mt-10">
            <h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl">Juntas: </h2>
        </div>

        <div class="relative border-gray-300 border-[1px] border-l-0 border-r-0 py-10 min-h-[30vh]">
            <BoardCard v-if="boardsActive.length > 0" v-for="board in boardsActive"
            :nombre="board.nombre" :descripcion="board.descripcion" :fecha="board.fecha" :participantes="board.personas" 
            @entryBoard="$router.push({name: 'liveBoardGuest', params: {uuid: board.uuid}})"
            />

            <div class="w-full absolute h-full top-[50%] translate-y-[-50%] scale-[.8]" v-else>
                <NoInfo icon="ban" title="No se han encontrado juntas"/>
            </div>
        </div>

    </main>
</template>