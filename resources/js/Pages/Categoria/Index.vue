

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, reactive, nextTick } from 'vue'
import { Head, usePage, useForm,router } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import Swal from 'sweetalert2';
import CrearModal from '@/Pages/Categoria/Partials/CrearModal.vue';
import EditarModal from '@/Pages/Categoria/Partials/EditarModal.vue';

//import DataTable from 'datatables.net-vue3';
import DataTable from 'datatables.net-dt';
import DataTablesCore from 'datatables.net';
import language from 'datatables.net-plugins/i18n/es-ES.mjs';
DataTable.use(DataTablesCore);

const datos=ref([]);
const tabla1=ref(null);


const options = {
  responsive: true,
  language,
  stateSave: true
};


const tabla=()=>{
    nextTick(()=>{
        tabla1.value=new DataTable('#tabla1', options);

    })
}

onMounted(() => {
    datos.value =usePage().props.categorias.data;
    tabla()
});


const formDelete = useForm({
    id: '',
});





//modal eliminar
const eliminar = (id, name) => {

    const alerta = Swal.mixin({ buttonsStyling: true });
    alerta.fire({
        width: 350,
        title: "Seguro de eliminar " + name,
        text: 'Se eliminará definitivamente',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        cancelButtonColor: 'red',
        confirmButtonColor: '#2563EB',

    }).then((result) => {
        if (result.isConfirmed) {
            formDelete.delete(route('categorias.destroy', id),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                         ok('Eliminado')
                         router.get(route('categorias.index'))
                        }
                });
        }
    });
}

const ok = (mensaje) => {
    //form.reset();

    Swal.fire({
        width: 350,
        title: mensaje,
        icon: 'success'
    })
}



</script>
<template>
    <div>

        <Head title="Categorias" />
        <AuthenticatedLayout>

            <div class="ml-4 col-span-full">

                <Breadcrumb>
                    <BreadcrumbItem href="/" home>
                        Inicio
                    </BreadcrumbItem>
                    <BreadcrumbItem>
                        Categorias
                    </BreadcrumbItem>
                </Breadcrumb>
            </div>

            <div class=" px-5 col-span-12 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Categorias</h1>
                <CrearModal></CrearModal>
            </div>

            <div
                class="p-4 mb-4 bg-white col-span-7 border border-gray-200 rounded-lg shadow-sm 2xl:col-span-12 dark:border-gray-700 sm:p-4 dark:bg-gray-800">
                <div class="overflow-x-auto">

                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-visible">

                            <table id="tabla1" class="w-full pt-3 text-sm text-left text-gray-600 dark:text-gray-400">
                                <thead class="text-md text-gray-700 bg-gray-200/80 border border-gray-300  dark:border-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="p-1 text-center border border-gray-300 dark:border-gray-500">
                                            ID
                                        </th>
                                        <th scope="col" class="p-1 text-center border border-gray-300 dark:border-gray-500">
                                            Nombre
                                        </th>

                                        <th scope="col" class="p-1 text-center border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center w-20">
                                                Acciones
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr :key="id" v-for="{
                                        id, nombre }, index in datos"
                                        class="bg-white border-b text-center dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-2 py-2 border  border-gray-300 dark:border-gray-700 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ id }}
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-2 border  border-gray-300 dark:border-gray-700 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ nombre }}
                                        </th>


                                        <td scope="row"
                                            class="px-3 py-1 border  border-gray-300 dark:border-gray-700 text-right">
                                            <span
                                                class="inline-block rounded bg-blue-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-blue-700">
                                                <EditarModal :categoria-id="id"></EditarModal>
                                            </span>
                                            <span
                                                class="inline-block rounded bg-red-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-red-700">
                                                <button @click.prevent="eliminar(id, nombre)"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </span>
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
}
</style>
