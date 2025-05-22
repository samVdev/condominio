<template>
    <main>
        <nav class="w-full grid grid-cols-2 px-10 gap-2  md:gap-20 md:px-[20vh]">
            <router-link :to="{ path: '/condominium/apt' }"
                class="font-bold w-full justify-center my-5 gap-2 h-[50px] rounded-2xl px-4 flex place-items-center transition-all border-[1px]"
                :class="$route.path.includes('/apt') ? 'bg-blue-600 text-white hover:bg-blue-500' : 'text-blue-600 border-blue-600 hover:bg-blue-600 hover:text-white'">
                <font-awesome-icon icon="building" />
                <p>Apartamentos</p>
            </router-link>
            <router-link :to="{ path: '/condominium/elevators' }"
                class="font-bold w-full justify-center my-5 gap-2 h-[50px] rounded-2xl px-4 flex place-items-center transition-all border-[1px]"
                :class="$route.path.includes('/elevators') ? 'bg-blue-600 text-white hover:bg-blue-500' : 'text-blue-600 border-blue-600 hover:bg-blue-600 hover:text-white'">
                <font-awesome-icon icon="elevator" />
                <p>Ascensores</p>
            </router-link>
        </nav>

        <RouterView></RouterView>
    </main>
</template>