

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, computed,ref,nextTick} from 'vue'
import { Head, usePage,useForm,router,Link } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import Swal from 'sweetalert2';

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
  order: [1, 'desc'],
  //stateSave: true
};
const titulo="Ventas"
const ruta="ventas";

const tabla=()=>{
    nextTick(()=>{
        tabla1.value=new DataTable('#tabla1', options);

    })
}

onMounted(() => {
    datos.value =usePage().props.ventas.data;
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
            formDelete.delete(route(ruta+'.destroy', id),
                {
                    preserveScroll: true,
                    onSuccess: () => { ok('Eliminado')
                    router.get(route(ruta+'.index'));
                }
                });
        }
    });
}

const ok = (mensaje) => {

    Swal.fire({
        width: 350,
        title: mensaje,
        icon: 'success'
    })
}


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
                        {{titulo}}
                    </BreadcrumbItem>
                </Breadcrumb>
            </div>
            <div class=" px-5 col-span-full flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{titulo}}</h1>
                <button type="button" @click="router.get(route(ruta+'.create'))"
            class="m-1 p-2 text-sm font-medium rounded text-center text-white bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-700">
            Crear Venta
        </button>
            </div>
            <div
                class="p-4 mb-4 bg-white col-span-12 pb-5 rounded-lg shadow-sm 2xl:col-span-12 dark:border-gray-700 sm:p-4 dark:bg-gray-800">
                <div class="overflow-x-auto">
                    <div class="">
                        <div class="overflow-auto">

                            <table id="tabla1" class="pt-3 w-full text-sm text-center text-gray-600 dark:text-gray-400">
                                <thead class="text-md text-center text-gray-700 bg-gray-200/80 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                ID
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center  text-center">
                                                Código factura
                                            </div>
                                        </th>

                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Cliente
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Vendedor
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Metodos de pago
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                               Tipo de venta
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                               Entrega
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Neto
                                            </div>
                                        </th>
                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Total
                                            </div>
                                        </th>

                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Fecha
                                            </div>
                                        </th>

                                        <th scope="col" class="border border-gray-300 dark:border-gray-500">
                                            <div class="flex justify-center">
                                                Acciones
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr :key="id" v-for="{
                                        id, cliente, codigo, vendedor, metodo_pago, forma_entrega,tipo_pago, neto, total, fecha}, index in datos"
                                        class="bg-white text-center dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                                            {{ id }}
                                        </th>
                                        <th scope="row"
                                            class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                                            {{ codigo }}
                                        </th>

                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ cliente }}
                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ vendedor }}
                                        </td>

                                        <td scope="row" class="p-1 border dark:border-gray-700">

                                            {{ metodo_pago}}
                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ tipo_pago }}
                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ forma_entrega }}
                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ neto }}
                                        </td>
                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ total }}
                                        </td>

                                        <td scope="row" class="p-1 border dark:border-gray-700">
                                            {{ fecha }}
                                        </td>

                                        <td scope="row" class="p-1 border text-end dark:border-gray-700">
                                            <span
                                                class="inline-block rounded bg-sky-300 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-sky-400">
                                                <a :href="route('ventas.generar_ticket', codigo)" target="_blank"><i class="fas fa-print"></i></a>
                                            </span>
                                            <span
                                                class="inline-block rounded bg-blue-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-blue-700">
                                                <Link :href="route('ventas.edit', id)"><i class="fas fa-edit"></i>
                                            </Link>
                                            </span>
                                            <span
                                                class="inline-block rounded bg-red-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-red-700">
                                                <button @click.prevent="eliminar(id, codigo)"><i
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
