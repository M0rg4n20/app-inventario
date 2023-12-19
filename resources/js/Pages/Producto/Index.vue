

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, computed, ref, nextTick } from 'vue'
import { Head, usePage } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import Swal from 'sweetalert2';
import StockColor from '@/Components/StockColor.vue';
import CrearModal from '@/Pages/Producto/Partials/CrearModal.vue';
import EditarModal from '@/Pages/Producto/Partials/EditarModal.vue';

//import DataTable from 'datatables.net-vue3';
import DataTable from 'datatables.net-dt';
import DataTablesCore from 'datatables.net';
import language from 'datatables.net-plugins/i18n/es-ES.mjs';
DataTable.use(DataTablesCore);

const datos = ref([]);
const tabla1 = ref(null);


const options = {
  responsive: true,
  language,
  stateSave: true
};


const tabla = () => {
  nextTick(() => {
    tabla1.value = new DataTable('#tabla1', options);

  })
}

onMounted(() => {
  datos.value = usePage().props.productos.data;
  tabla()
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
      formDelete.delete(route('productos.destroy', id),
        {
          preserveScroll: true,
          onSuccess: () => { ok('Eliminado') }
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

    <Head title="Productos" />
    <AuthenticatedLayout>
      <div class="ml-4 col-span-full">
        <Breadcrumb>
          <BreadcrumbItem href="/" home>
            Inicio
          </BreadcrumbItem>
          <BreadcrumbItem>
            Productos
          </BreadcrumbItem>
        </Breadcrumb>
      </div>
      <div class=" px-5 col-span-full flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Productos</h1>
        <CrearModal></CrearModal>
      </div>
      <div
        class="p-4 mb-4 bg-white col-span-12 pb-5 rounded-lg shadow-sm 2xl:col-span-12 dark:border-gray-700 sm:p-4 dark:bg-gray-800">
        <div class="overflow-x-auto">
          <div class="lg:inline-block min-w-full  mt-4">
            <div class="overflow-hidden">

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
                        Nombre
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center text-center">
                        Imagen
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Código
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Categoría
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Stock
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Precio compra
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Precio venta
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Precio mayorista
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Agregado
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
                  <tr :key="id"
                    v-for="{
                      id, nombre, imagen_1, codigo, categoria, stock, precio_compra, precio_venta, precio_mayorista, agregado
                    }, index in datos"
                    class="bg-white text-center dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row"
                      class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                      {{ id }}
                    </th>
                    <th scope="row"
                      class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                      {{ nombre }}
                    </th>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      <img class="rounded-full shadow-2xl border-2 w-10 h-10 object-contain" :src="imagen_1"
                        alt="image description">
                    </td>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      {{ codigo }}
                    </td>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      {{ categoria }}
                    </td>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      <StockColor :cantidad="stock">
                        {{ stock }}
                      </StockColor>
                    </td>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      {{ precio_compra }}
                    </td>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      {{ precio_venta }}
                    </td>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      {{ precio_mayorista }}
                    </td>

                    <td scope="row" class="p-1 border dark:border-gray-700">
                      {{ agregado }}
                    </td>

                    <td scope="row" class="p-1 border dark:border-gray-700">


                      <span
                        class="inline-block rounded bg-blue-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-blue-700">
                        <EditarModal :cliente-id="id"></EditarModal>
                      </span>
                      <span
                        class="inline-block rounded bg-red-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-red-700">
                        <button @click.prevent="eliminar(id, nombre)"><i class="fas fa-trash-alt"></i></button>
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
