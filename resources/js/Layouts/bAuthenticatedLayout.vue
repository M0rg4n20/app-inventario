<script setup>
import { onMounted,onUnmounted } from 'vue';
import SideBar from '@/Components/SideBar.vue';
import NavBar from '@/Components/NavBar.vue';
import { initFlowbite } from 'flowbite'
import { useConfigStore } from '@/store/config.js'
const configStore = useConfigStore();

onMounted(() => {
    initFlowbite();

})

/*window.addEventListener("beforeunload", () => {
    localStorage.removeItem('currentMenu');
});
*/

onUnmounted(() => {
    //localStorage.removeItem('currentMenu');



})
</script>

<template>
    <NavBar></NavBar>
    <div class="flex pt-16 overflow-none dark:bg-gray-900 ">
        <SideBar :is-open="configStore.getIsOpen"></SideBar>
        <div id="main-content" :class="configStore.getIsOpen ? 'lg:ml-64' : ''"
            class="relative w-full h-full bg-gray-50 dark:bg-gray-900 ">

            <!-- Page Content -->
            <main class="grid grid-cols-1 p-3 xl:grid-cols-12 xl:gap-4 dark:bg-gray-900 z-20">
                <slot/>
            </main>
        </div>
    </div>
</template>
