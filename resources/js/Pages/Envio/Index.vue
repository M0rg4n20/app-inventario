

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, computed, ref, nextTick, watch } from 'vue'
import { Head, usePage, useForm, router, Link } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import Swal from 'sweetalert2';
import DataTable from 'datatables.net-dt';
import DataTablesCore from 'datatables.net';
import language from 'datatables.net-plugins/i18n/es-ES.mjs';
import StatusColor from '@/Components/StatusColor.vue';
import EditarModal from '@/Pages/Envio/Partials/EditarModal.vue';
DataTable.use(DataTablesCore);
import moment from 'moment';
import TextInput from '@/Components/TextInput.vue';
import Multiselect from '@vueform/multiselect';
import Sortable from 'sortablejs';
const sortableTable = ref(null);
const { permissions } = usePage().props.auth
const datos = ref([]);
const tabla1 = ref(null);

const estados = ref({
  value: '',
  placeholder: "Seleccione",
  options: [
    { "value": "Asignado", "label": "Asignado" },
    { "value": "Entregado", "label": "Entregado" },
    { "value": "Cancelado", "label": "Cancelado" },
    { "value": "Reprogramado", "label": "Reprogramado" }
  ],
});

const options = {
  responsive: true,
  language,
  order: [0, 'asc'],
};

const titulo = "Envios"
const ruta = "envios";

const buscarEstado = ref('');
const buscarRepartidor = ref('');

const tabla = () => {
  nextTick(() => {
    tabla1.value = new DataTable('#tabla1', options);
  })
}

setTimeout(() => {
  if (route().current('envios.index')) {
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
      saveOrder();
    },
    ghostClass: 'dragged-row',
    chosenClass: 'dragged-row',
  });
});

const actualizarTabla = () => {
  const searchQuery = `${buscarEstado.value || ''} ${buscarRepartidor.value || ''}`;
  tabla1.value.search(searchQuery).draw();
};

watch(buscarEstado, () => {
  actualizarTabla();
});

const saveOrder = () => {
  const newOrder = datos.value.map((item, index) => ({
    id: item.id,
    order: index + 1,
  }));

  axios.post(route('envios.save-order'), { order: newOrder })
    .then(response => {
      console.log('Orden guardado exitosamente');
    })
    .catch(error => {
      console.error('Error al guardar el orden: ', error);
    });
};

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
            <div class="overflow-auto">
              <div class="mt-4 flex justify-end">
                <div class="w-1/4 pr-2">
                  <Multiselect v-model="buscarEstado" :options="estados.options" placeholder="Seleccione el estado"
                    />
                </div>
                <div class="w-1/4 pr-2">
                  <TextInput id="buscarPorRepartidor" type="search" v-model="buscarRepartidor" @input="actualizarTabla" placeholder="Buscar"/>
                </div>
              </div>
              <table id="tabla1" class="pt-3 w-full text-sm text-center text-gray-600 dark:text-gray-400">
                <thead class="text-md text-center text-gray-700 bg-gray-200/80 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500" title="Prioridad">
                      <div class="flex justify-center"></div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        ID
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center  text-center">
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
                        Ruta
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Repartidor
                      </div>
                    </th>
                    <th scope="col" class="border border-gray-300 dark:border-gray-500">
                      <div class="flex justify-center">
                        Estado
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
                <tbody ref="sortableTable" class="sortable">
                  <tr :key="id" v-for="{
                    id, telefono, venta, colonia, estado, ruta, direccion, fecha, hora, orden, comentario, repartidor, created_at
                  }, index in datos" class="bg-white text-center dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row"
                      class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                      <span title="Prioridad">{{ orden }}</span>
                    </th>
                    <th scope="row"
                      class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                      {{ id }}
                    </th>
                    <th scope="row"
                      class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">

                      {{ venta.cliente.nombre }}
                    </th>
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
                      {{ ruta.nombre }}
                    </td>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      {{ repartidor.name }}
                    </td>
                    <td scope="row" class="p-1 border dark:border-gray-700">
                      <StatusColor :texto="estado">
                        {{ estado }}
                      </StatusColor>
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

                    <td scope="row" class="p-1 border mx-auto dark:border-gray-700">
                      <EditarModal v-show="permissions.includes('editar-envios')" :cliente-id="id">
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

.dragged-row {
  background-color: #b200d6 !important;
  color: white;
  opacity: 0.8;
  transition: background-color 0.2s, opacity 0.2s;
}

.dataTables_filter label {
  display: none
}
</style>
