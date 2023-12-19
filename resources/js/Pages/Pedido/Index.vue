

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, computed, ref, nextTick } from 'vue'
import { Head, usePage, useForm, router, Link } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import Swal from 'sweetalert2';
import CrearModal from '@/Pages/Ruta/Partials/CrearModal.vue';
import AsignarRepartidor from '@/Pages/Pedido/Partials/AsignarRepartidor.vue';
import AsignarMultiplesPedidos from '@/Pages/Pedido/Partials/AsignarMultiplesPedidos.vue';
import EditarModal from '@/Pages/Pedido/Partials/EditarModal.vue';
//import DataTable from 'datatables.net-vue3';
import DataTable from 'datatables.net-dt';
import DataTablesCore from 'datatables.net';
import language from 'datatables.net-plugins/i18n/es-ES.mjs';
DataTable.use(DataTablesCore);
import moment from 'moment';
import Sortable from 'sortablejs';

const datos = ref([]);
const tabla1 = ref(null);
const sortableTable = ref(null);
const { permissions } = usePage().props.auth

const options = {
  responsive: true,
  language,
  order: [1, 'desc'],
};
const titulo = "Pedidos"
const ruta = "pedidos";

const tabla = () => {
  nextTick(() => {
    tabla1.value = new DataTable('#tabla1', options);
  })
}

setTimeout(() => {
  if (route().current('pedidos.index')) {
    window.open(self.location, '_self');
  }
}, 60000);

onMounted(() => {
  datos.value = usePage().props.pedidos;
  tabla()

  const sortable = new Sortable(sortableTable.value, {
    animation: 150,
    onEnd: (evt) => {
      const fromIndex = evt.oldIndex;
      const toIndex = evt.newIndex;
      const rows = datos.value;
      rows.splice(toIndex, 0, rows.splice(fromIndex, 1)[0]);
      datos.value = rows;
    },
    ghostClass: 'dragged-row',
    chosenClass: 'dragged-row',
  });
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
      formDelete.delete(route(ruta + '.destroy', id),
        {
          preserveScroll: true,
          onSuccess: () => {
            ok('Eliminado')
            router.get(route(ruta + '.index'));
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

const selectedOrders = ref([]);
const selectedRows = ref([]);
const selectAllRows = (event) => {
  const isChecked = event.target.checked;
  if (isChecked) {
    selectedRows.value = datos.value.map((row) => row.id);
  } else {
    selectedRows.value = [];
  }
  selectedOrders.value = selectedRows.value;
};

const toggleRowSelection = (id) => {
  if (selectedRows.value.includes(id)) {
    selectedRows.value = selectedRows.value.filter((rowId) => rowId !== id);
  } else {
    selectedRows.value = [...selectedRows.value, id];
  }
  selectedOrders.value = selectedRows.value;
};
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
        
        <AsignarMultiplesPedidos v-show="permissions.includes('asignar-repartidor')" :selectedOrders="selectedOrders">
        </AsignarMultiplesPedidos>
        <!-- <CrearModal v-show="permissions.includes('asignar-ruta')"></CrearModal> -->
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
                        <input type="checkbox" class="form-checkbox text-indigo-600 border-indigo-600 rounded-md"
                          @change="selectAllRows" />
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        ID
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center  text-center">
                        Orden
                      </div>
                    </th>

                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Cliente
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Pedido
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Calle
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Colonia
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Teléfono
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Comentario
                      </div>
                    </th>

                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Fecha
                      </div>
                    </th>

                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Hora
                      </div>
                    </th>

                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Acciones
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody ref="sortableTable" @update="onRowOrderChange" class="sortable">
                  <tr :key="id" v-for="{
                    id, telefono, venta, colonia, comentario, direccion, fecha, hora
                  }, index in datos" class="bg-white text-center dark:bg-gray-800 dark:border-gray-700" :data-id="id">
                    <td scope="row"
                      class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                      <input type="checkbox" class="form-checkbox text-indigo-600 border-indigo-600 rounded-md"
                        :value="id" :checked="selectedRows.includes(id)" @change="toggleRowSelection(id)" />
                    </td>
                    <th scope="row"
                      class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                      {{ id }}
                    </th>
                    <th scope="row"
                      class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                      {{ venta.codigo }}
                    </th>

                    <td scope="row" class="p-1 border dark:border-gray-700">
                      {{ venta.cliente.nombre }}
                    </td>
                    <td scope="row" class="p-1 border text-start dark:border-gray-700">

                      {{ venta.detalles_ventas.map(entry => (
                        "Cantidad: " + entry.cantidad + " -- Producto: " + entry.producto.nombre
                      )).join(' | ') }}

                    </td>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      {{ direccion }}
                    </td>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      {{ colonia }}
                    </td>

                    <td scope="row" class="p-1 border dark:border-gray-700">

                      {{ telefono }}
                    </td>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      {{ comentario }}
                    </td>

                    <td scope="row" class="p-1 border dark:border-gray-700">

                      {{ moment(String(fecha)).format('DD/MM/YYYY') }}
                    </td>

                    <td scope="row" class="p-1 border dark:border-gray-700">

                      {{ hora }}
                    </td>

                    <td scope="row" class="p-1 flex justify-center border text-end dark:border-gray-700">
                      <AsignarRepartidor v-show="permissions.includes('asignar-repartidor')" :categoria-id="id">Asignar
                      </AsignarRepartidor>
                      <EditarModal :cliente-id="id" v-show="permissions.includes('editar-pedidos')">
                      </EditarModal>
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

.dragged-row {
  background-color: #b200d6 !important;
  color: white;
  opacity: 0.8;
  transition: background-color 0.2s, opacity 0.2s;
}
</style>
