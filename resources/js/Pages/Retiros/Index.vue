

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, nextTick } from 'vue'
import { Head, usePage, useForm, router } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import Swal from 'sweetalert2';
import CrearModal from '@/Pages/Retiros/Partials/CrearModal.vue';

import DataTable from 'datatables.net-dt';
import DataTablesCore from 'datatables.net';
import language from 'datatables.net-plugins/i18n/es-ES.mjs';
DataTable.use(DataTablesCore);

const datos = ref([]);
const tabla1 = ref(null);

const options = {
  responsive: true,
  language,
  order: [3, 'desc']
};
const titulo = "Retiros"
const ruta = "retiros";
const tabla = () => {
  nextTick(() => {
    tabla1.value = new DataTable('#tabla1', options);
  })
}

const formatDate = (isoDate) => {
  const date = new Date(isoDate);
  const formattedDate = date.toLocaleString('es-ES', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
  });
  return formattedDate;
};

onMounted(() => {
  datos.value = usePage().props.retiros.map(retiro => {
    return {
      ...retiro,
      created_at: formatDate(retiro.created_at)
    };
  });
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

      <div class=" px-5 col-span-12 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ titulo }}</h1>
      </div>

      <div
        class="p-4 mb-4 bg-white col-span-12 border border-gray-200 rounded-lg shadow-sm 2xl:col-span-12 dark:border-gray-700 sm:p-4 dark:bg-gray-800">
        <div class="overflow-x-auto">
          <div class="inline-block min-w-full align-middle">
            <div class="overflow-visible">

              <table id="tabla1" class="pt-3 w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead
                  class="text-md text-gray-700 bg-gray-200/80 border border-gray-300  dark:border-gray-700 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th scope="col" class="p-1 text-center border border-gray-300 dark:border-gray-500 w-20">
                      ID
                    </th>
                    <th scope="col" class="p-1 text-center border border-gray-300 dark:border-gray-500">
                      Repartidor
                    </th>
                    <th scope="col" class="p-1 text-center border border-gray-300 dark:border-gray-500">
                      Monto
                    </th>
                    <th scope="col" class="p-1 text-center border border-gray-300 dark:border-gray-500">
                      Fecha
                    </th>
                    <th scope="col" class="p-1 text-center border border-gray-300 dark:border-gray-500">
                      Estado
                    </th>
                    <th scope="col" class="p-1 text-center border border-gray-300 dark:border-gray-500">
                      Comentario
                    </th>
                    <th scope="col" class="p-1 text-center border border-gray-300 dark:border-gray-500">
                      Acciones
                    </th>
                  </tr>
                </thead>
                <tbody>

                  <tr :key="id" v-for="{ id, repartidor_name, monto, created_at, estado, comentario }, index in datos"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td scope="row"
                      class="px-3 py-1 border  text-center border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
                      {{ id }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border  border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
                      {{ repartidor_name }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border  border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
                      {{ monto }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border text-end border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
                      {{ created_at }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border text-end border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
                      {{ estado }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border text-end border-gray-300 dark:border-gray-700 text-gray-900 whitespace-nowrap dark:text-white">
                      {{ comentario }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border  border-gray-300 dark:border-gray-700 text-gray-900 text-center whitespace-nowrap dark:text-white">
                      <!-- v-if="estado === 'Pendiente'" -->
                      <CrearModal :id="id" />
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
