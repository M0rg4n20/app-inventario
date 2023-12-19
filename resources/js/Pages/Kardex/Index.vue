

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, computed, ref, nextTick } from 'vue'
import { Head, usePage, useForm, router, Link } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import DataTable from 'datatables.net-dt';
import DataTablesCore from 'datatables.net';
import language from 'datatables.net-plugins/i18n/es-ES.mjs';
import moment from 'moment';
DataTable.use(DataTablesCore);

const datos = ref([]);
const tabla1 = ref(null);


const options = {
    responsive: true,
    language,
    order: [0, 'desc'],

};
const titulo = "Kardex"
const ruta = "kardex";

const tabla = () => {
    nextTick(() => {
        tabla1.value = new DataTable('#tabla1', options);

    })
}

onMounted(() => {
    datos.value = usePage().props.productos;
    tabla()
});

</script>
<template>
    <div>

        <Head :title="titulo" />
        <AuthenticatedLayout>
            <div class="ml-4 col-span-full">
                <Breadcrumb>
                    <BreadcrumbItem href="/" home>
                        Inicio
                    </BreadcrumbItem>
                    <BreadcrumbItem>
                        {{ titulo }}
                    </BreadcrumbItem>
                </Breadcrumb>
            </div>
            <div class=" px-5 col-span-full flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ titulo }}</h1>
            </div>
            <div
                class="p-4 mb-4 bg-white col-span-12 pb-5 rounded-lg shadow-sm 2xl:col-span-12 dark:border-gray-700 sm:p-4 dark:bg-gray-800">
                <div class="overflow-x-auto">
                    <div class="lg:inline-block min-w-full  mt-4">
                        <div class="overflow-hidden">

                            <table id="tabla1" class="pt-3 w-full text-sm text-center text-gray-600 dark:text-gray-400">
                                <thead
                                    class="text-md text-center text-gray-700 bg-gray-200/80 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                ID
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center  text-center">
                                                Producto
                                            </div>
                                        </th>

                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Ticket
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Cantidad
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Stock Anterior
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Stock Final
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Fecha
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Tipo
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Proveedor
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Comentario
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Usuario
                                            </div>
                                        </th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr :key="id" v-for="{
                                        id, created_at,producto, cantidad,ticket, tipo,comentario, stock_anterior,
                                        stock_final, proveedor,user
                                    }, index in datos"
                                        class="bg-white text-center text-xs dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                                            {{ id }}
                                        </th>
                                        <th scope="row"
                                            class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-normal text-gray-900 dark:text-white">
                                            {{ producto.codigo}}  {{ producto.nombre}}
                                        </th>

                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ ticket }}
                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">

                                            {{cantidad}}

                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ stock_anterior }}
                                        </td>

                                        <td scope="row" class="p-1 border dark:border-gray-700">

                                            {{ stock_final }}
                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{moment(String(created_at)).format('DD/MM/YYYY hh:mm:ss')}}
                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ tipo }}
                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ proveedor }}
                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ comentario }}
                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ user.name }}
                                        </td>



                                    </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>


<style type="text/css">
@import 'datatables.net-dt';

.imagePreviewWrapper {
    background-repeat: no-repeat;
    width: 100px;
    height: 100px;
    display: block;
    margin: 0 auto;
    background-size: contain;
    background-position: center center;
}</style>
