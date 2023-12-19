

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, reactive, computed, watch } from 'vue'
import { Head, usePage,useForm } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const tabla_categorias = ref({})

//buscador


const form=useForm({
    id:'',
    slug: '',
    key: '',
    value: '',
});



onMounted(() => {
    tabla_categorias.value = usePage().props.configuraciones;
});



</script>
<template>
    <div>

        <Head title="Configuraciones" />
        <AuthenticatedLayout>

            <div class="ml-4 col-span-full">

                <Breadcrumb>
                    <BreadcrumbItem href="/" home>
                        Inicio
                    </BreadcrumbItem>
                    <BreadcrumbItem>
                        Configuraciones
                    </BreadcrumbItem>
                </Breadcrumb>
            </div>
            <div class="px-5 col-span-full flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Configuraciones</h1>
            </div>
            <div
                class="p-4 mb-4 bg-white col-span-6 border border-gray-200 rounded-lg shadow-sm 2xl:col-span-12 dark:border-gray-700 sm:p-4 dark:bg-gray-800">

                <div :key="config.id" class="col-span-6 mt-3 shadow-default xl:col-span-6" v-for="config in tabla_categorias">
                    <InputLabel :for="config.slug" :value="config.key" class="text-base font-bold leading-6 text-gray-900" />
                    <TextInput :id="config.key" type="text" :value="config.value" />
                </div>
            </div>

        </AuthenticatedLayout>

    </div>
</template>


<style type="text/css" scoped></style>
