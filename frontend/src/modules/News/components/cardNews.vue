<script lang="ts" setup>

const props = defineProps<{
    titulo: string,
    subtitulo: string,
    imagen: string
}>()

</script>


<template>
    <div class="cardNews">
        <img :src="imagen" :alt="`imagen de ${titulo}`">
        <div class="cardNews__content">
            <p class="cardNews__title">{{ titulo }}</p>
            <p class="cardNews__description">{{subtitulo}}</p>
            <slot></slot>
        </div>
    </div>

</template>


<style>
.cardNews {
    position: relative;
    width: 300px;
    height: 200px;
    background: #000;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}

.cardNews img {
    width: 100%;
    height: 100%;
    opacity: .7;
    transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}

.cardNews:hover {
    transform: rotate(-5deg) scale(1.1);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.cardNews__content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    width: 100%;
    height: 100%;
    padding: 20px;
    box-sizing: border-box;
    background-color: #fff;
    opacity: 0;
    transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}

.cardNews:hover .cardNews__content {
    transform: translate(-50%, -50%) rotate(0deg);
    opacity: 1;
}

.cardNews__title {
    margin: 0;
    font-size: 24px;
    color: #333;
    font-weight: 700;
}

.cardNews__description {
    margin: 10px 0 0;
    font-size: 14px;
    color: #777;
    line-height: 1.4;
}

.cardNews:hover img {
    scale: 0;
    transform: rotate(-45deg);
}
</style>