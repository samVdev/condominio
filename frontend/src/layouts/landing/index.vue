<template>
    <section id="Inicio" class="h-[80vh] grid place-items-center object-contain md:bg-bottom">
        <div class="font-bold text-center">
            <h2 class="text-5xl mb-4 md:text-5xl 2xl:text-5xl text-white">Gestión inteligente para el</h2>
            <h1 class="text-4xl md:text-5xl 2xl:text-8xl text-[#EA5165] font-extrabold">condominio Yutaje</h1>
        </div>
    </section>
</template>

<style scoped>
#Inicio {
    background-image: linear-gradient(rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.288) 100%), url('/images/lan_index.jfif');
    background-position: center 40%;
    background-size: cover;
}

@media (min-width: 768px) {
    #Inicio {
        background-position: center 80%;
    }
}
</style>