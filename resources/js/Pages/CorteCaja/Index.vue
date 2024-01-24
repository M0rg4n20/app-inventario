

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref, onMounted, reactive, computed, watch } from 'vue'
import { Head, usePage, Link } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const tabla_categorias = ref({})
const searchTerm = ref('');
const searchRuta = ref('');
const searchRepartidor = ref('');
const mostrarLista = ref(false);

const { lista_fechas } = usePage().props;
const { hoy } = usePage().props;
//filtrado input

const searchCountries = computed(() => {

  if (searchTerm.value === '') {
    mostrarLista.value = false;
    return []
  } else {
    mostrarLista.value = true;
  }
  let matches = 0

  return lista_fechas.filter(country => {
    if (
      country.name.toLowerCase().includes(searchTerm.value.toLowerCase())
      && matches < 10
    ) {
      matches++
      //mostrarLista.value = true;
      //mostrarLista.value = true;
      return country
    }
  })
});

const selectCountry = (country, vis, event) => {
  //searchTerm.value = ''
  mostrarLista.value = false;
  searchTerm.value = country
}
//fin filtrado input


//buscador
const filteredItems = computed(() => {
  let filteredItems1 = usePage().props.cortecaja;

  console.log(searchTerm.value );
  console.log(searchRuta.value );
  console.log(searchRepartidor.value );

  if (searchTerm.value !== "" && searchRuta.value =="" && searchRepartidor.value=="") {
    console.log('Filtro solo por fecha');
    pagination.currentPage = 1;
    filteredItems1 = tabla_categorias.value.filter(bet => {
      return bet.fecha.toLowerCase().includes(searchTerm.value.toLowerCase()) 
    })
  }

  if (searchTerm.value == "" && searchRuta.value !=="" && searchRepartidor.value=="") {
    console.log('Filtro solo por ruta');
    pagination.currentPage = 1;
    filteredItems1 = tabla_categorias.value.filter(bet => {
      return bet.codigo_ruta.toLowerCase().includes(searchRuta.value.toLowerCase()) 
    })
  }

  if (searchTerm.value == "" && searchRuta.value =="" && searchRepartidor.value!=="") {
    console.log('Filtro solo por repartidor');
    pagination.currentPage = 1;
    filteredItems1 = tabla_categorias.value.filter(bet => {
      return bet.repartidor.toLowerCase().includes(searchRepartidor.value.toLowerCase()) 
    })
  }

  if (searchTerm.value !== "" && searchRuta.value !=="" && searchRepartidor.value=="") {
    console.log('Filtro solo por fecha y ruta');
    pagination.currentPage = 1;
    filteredItems1 = tabla_categorias.value.filter(bet => {
      return bet.fecha.toLowerCase().includes(searchTerm.value.toLowerCase()) && bet.codigo_ruta.toLowerCase().includes(searchRuta.value.toLowerCase()) 
    })
  }

  if (searchTerm.value !== "" && searchRuta.value =="" && searchRepartidor.value!=="") {
    console.log('Filtro solo por fecha y repartidor');
    pagination.currentPage = 1;
    filteredItems1 = tabla_categorias.value.filter(bet => {
      return bet.fecha.toLowerCase().includes(searchTerm.value.toLowerCase()) && bet.repartidor.toLowerCase().includes(searchRepartidor.value.toLowerCase()) 
    })
  }

  if (searchTerm.value == "" && searchRuta.value !=="" && searchRepartidor.value!=="") {
    console.log('Filtro solo por repartidor y ruta');
    pagination.currentPage = 1;
    filteredItems1 = tabla_categorias.value.filter(bet => {
      return bet.codigo_ruta.toLowerCase().includes(searchRuta.value.toLowerCase()) && bet.repartidor.toLowerCase().includes(searchRepartidor.value.toLowerCase()) 
    })
  }

  if (searchTerm.value !== "" && searchRuta.value !=="" && searchRepartidor.value!=="") {
    console.log('Filtro solo por fecha, repartidor y ruta');
    pagination.currentPage = 1;
    filteredItems1 = tabla_categorias.value.filter(bet => {
      return bet.fecha.toLowerCase().includes(searchTerm.value.toLowerCase()) && bet.codigo_ruta.toLowerCase().includes(searchRuta.value.toLowerCase()) && bet.repartidor.toLowerCase().includes(searchRepartidor.value.toLowerCase()) 
    })
  }

  return filteredItems1;

})

const totalVenta = computed(() => {
  var efectivo = parseFloat(filteredItems.value.reduce((acc, cur) => acc + parseFloat(cur['monto_tarjeta']), 0))
  var tarjeta = parseFloat(filteredItems.value.reduce((acc, cur) => acc + parseFloat(cur['monto_efectivo']), 0))
  var saldo = parseFloat(filteredItems.value.reduce((acc, cur) => acc + parseFloat((cur['saldo'] < 0) ? (parseFloat(cur['saldo']) * -1) : 0), 0))
  saldo -= parseFloat(filteredItems.value.reduce(
    (acc, cur) => acc + parseFloat(
      (parseInt(cur['metodo_pago_id']) == 3 && parseFloat(cur['saldo']) < 0) ? cur['monto_tarjeta'] : 0
  ), 0));
  return (parseFloat(efectivo - saldo) + parseFloat(tarjeta)).toFixed(2);
})

const totalEfectivo = computed(() => {
  var efectivo = parseFloat(filteredItems.value.reduce((acc, cur) => acc + parseFloat(cur['monto_efectivo']), 0))
  var saldo = parseFloat(filteredItems.value.reduce((acc, cur) => acc + parseFloat((cur['saldo'] < 0) ? (parseFloat(cur['saldo']) * -1) : 0), 0))
  saldo -= parseFloat(filteredItems.value.reduce(
    (acc, cur) => acc + parseFloat(
      (parseInt(cur['metodo_pago_id']) == 3 && parseFloat(cur['saldo']) < 0) ? cur['monto_tarjeta'] : 0
  ), 0));
  return (efectivo-saldo).toFixed(2)
})

const totalTarjeta = computed(() => {
  return (filteredItems.value.reduce((acc, cur) => acc + parseFloat(cur['monto_tarjeta']), 0)).toFixed(2)
})

const pagination = reactive({
  currentPage: 1,
  perPage: 10,
  totalPages: computed(() =>
    Math.ceil(filteredItems.value.length / pagination.perPage)
  ),
});

watch(
  () => pagination.totalPages,
  () => (pagination.currentPage = 1)
);

watch([totalVenta], (currentValue, oldValue) => {
});

const paginatedItems = computed(() => {
  const { currentPage, perPage } = pagination;
  const start = (currentPage - 1) * perPage;
  const stop = start + perPage;
  return filteredItems.value.slice(start, stop);
});

const clickCallback = (page) => {
  pagination.currentPage = page;
}

onMounted(() => {
  tabla_categorias.value = usePage().props.cortecaja;
  searchTerm.value = hoy
});
</script>
<template>
  <div>

    <Head title="Caja" />
    <AuthenticatedLayout>

      <div class="ml-4 col-span-full">

        <Breadcrumb>
          <BreadcrumbItem href="/" home>
            Inicio
          </BreadcrumbItem>
          <BreadcrumbItem>
            Caja
          </BreadcrumbItem>
        </Breadcrumb>
      </div>

      <div
        class="p-4 mb-4 bg-white col-span-12 border border-gray-200 rounded-lg shadow-sm 2xl:col-span-12 dark:border-gray-700 sm:p-4 dark:bg-gray-800">
        <div class="overflow-x-auto">
          <div class="col-span-full flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Caja - Total del corte
              de: {{ searchTerm }}</h1>
          </div>

          <div class="grid grid-cols-1 p-4 xl:grid-cols-12 md:grid-span-12 xl:gap-4 dark:bg-gray-900 z-20">
            
            <div class="p-2 col-span-3">
              <InputLabel for="search" value="Desglose general"
                class="block text-base font-bold leading-6 mb-0 text-gray-900 dark:text-white" />
            </div>

            <div class="p-2 col-span-3">
              <div class="w-full">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Total venta </h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{
                  totalVenta }}</span>

              </div>
            </div>
            <div class="p-2 col-span-3">
              <div class="w-full">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Total venta con Efectivo</h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ totalEfectivo
                }}</span>

              </div>
            </div>
            <div class="p-2 col-span-3">
              <div class="w-full">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Total venta con tarjetas</h3>
                <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ totalTarjeta
                }}</span>

              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 p-4 xl:grid-cols-12 md:grid-span-12 xl:gap-4 dark:bg-gray-900 z-20">
            <div class="p-2 col-span-3">              
              <div class="mt-1">
                <TextInput id="search" type="text" v-model="searchTerm" autocomplete="search"
                  class="block w-full text-gray-900 border border-gray-300 rounded bg-gray-50 sm:text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Ingrese la fecha" />


                <ul v-show="mostrarLista"
                  class="rounded bg-white border border-gray-300 px-1 py-1 space-y-1 absolute z-10">
                  <li v-for="country in searchCountries" :key="country.name"
                    @click="(event) => selectCountry(country.name, false, event)"
                    class="cursor-pointer hover:bg-gray-100 p-1">
                    {{ country.name }}
                  </li>
                </ul>
              </div>
            </div>

            <div class="p-2 col-span-3">             
              <div class="mt-1">
                <TextInput id="searchRuta" type="text" v-model="searchRuta" autocomplete="search"
                  class="block w-full text-gray-900 border border-gray-300 rounded bg-gray-50 sm:text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Ingrese la ruta" />
              </div>
            </div>

            <div class="p-2 col-span-3">             
              <div class="mt-1">
                <TextInput id="searchRepartidor" type="text" v-model="searchRepartidor" autocomplete="search"
                  class="block w-full text-gray-900 border border-gray-300 rounded bg-gray-50 sm:text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Ingrese el repartidor" />
              </div>
          </div>

          </div>            
          

          <div class="inline-block min-w-full align-middle">
            <div class="overflow-visible">

              <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead
                  class="text-md text-gray-700 bg-gray-200/80 border-2 border-gray-300  dark:border-gray-700 dark:bg-gray-700 dark:text-gray-400">
                  <tr>

                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      ID
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Ticket
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Vendedor
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Neto
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Descuento
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Total
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Métodos Pagos
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Efectivo
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Tarjetas
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Cambio
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Tipo venta
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Forma entrega
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Fecha
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Código Ruta
                    </th>
                    <th scope="col" class="p-1 text-center border-2 border-gray-300 dark:border-gray-500">
                      Repartidor
                    </th>
                  </tr>
                </thead>
                <tbody>

                  <tr :key="id"
                    v-for="{ id, codigo, vendedor, neto, monto_efectivo, forma_entrega, descuento, monto_tarjeta, saldo, total, metodo_pago, metodo_pago_id, tipo_pago, fecha, codigo_ruta , repartidor}, index in paginatedItems"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                    <td scope="row"
                      class="px-3 py-1 border-2  text-center border-gray-300 dark:border-gray-700 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                      {{ id }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2  border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ codigo }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2  border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ vendedor }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2 text-end border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ neto }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2 text-end border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ descuento }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2 text-end border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ total }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2 border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ metodo_pago }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2 text-end border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ monto_efectivo }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2 text-end border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ monto_tarjeta }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2 text-end border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ (saldo < 0) ? (metodo_pago_id == 3) ? (saldo*(-1)) - monto_tarjeta : saldo * (-1) : 0 }} </td>
                    <td scope="row"
                      class="px-3 py-1 border-2 text-center border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ tipo_pago }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2 text-center border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ forma_entrega }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2 text-end border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ fecha }}
                    </td>

                    <td scope="row"
                      class="px-3 py-1 border-2 text-end border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ codigo_ruta }}
                    </td>
                    <td scope="row"
                      class="px-3 py-1 border-2 text-end border-gray-300 dark:border-gray-700 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ repartidor }}
                    </td>
                    
                  </tr>

                </tbody>
              </table>
              <pagination :pageCount="pagination.totalPages" class="my-3"
                :containerClass="'flex items-center -space-x-px h-10 text-base'"
                :prevLinkClass="'flex items-center  cursor-pointer justify-center px-2  h-10 ml-0 leading-tight text-gray-500  border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'"
                :nextLinkClass="'flex items-center cursor-pointer justify-center px-2 h-10 leading-tight text-gray-500  border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'"
                :pageLinkClass="'flex items-center hover:cursor-pointer justify-center px-5 h-10 leading-tight text-gray-500  border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'"
                :prevText="'«&nbsp; Anterior'" :nextText="'Siguiente &nbsp;»'"
                :disabledClass="'bg-gray-100 cursor-not-allowed'" :activeClass="'bg-gray-200 cursor-pointer'"
                :clickHandler="clickCallback">
              </pagination>
            </div>
          </div>
        </div>
      </div>

    </AuthenticatedLayout>

  </div>
</template>


<style type="text/css" scoped></style>
