<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref, nextTick, computed } from 'vue'
import { Head, usePage, useForm, router } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import Swal from 'sweetalert2';
import StockColor from '@/Components/StockColor.vue';
import Multiselect from '@vueform/multiselect';
import DataTable from 'datatables.net-dt';
import DataTablesCore from 'datatables.net';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import CrearClientExterno from '@/Pages/Clientes/Partials/CrearClientExterno.vue';
import AgregarDescuentoModal from '@/Pages/Venta/Partials/AgregarDescuentoModal.vue';
import language from 'datatables.net-plugins/i18n/es-ES.mjs';
DataTable.use(DataTablesCore);

const datos = ref([]);
const tabla1 = ref(null);
const tipo_cliente = ref('');
const lista_clientes = ref([]);
const lista_metodos = ref([]);

const titulo = "Editar Venta"

const options = {
  responsive: false,
  language,
};


const tabla = () => {
  nextTick(() => {
    tabla1.value = new DataTable('#tabla1', options);

  })
}

const regenClientes = () => {

}
const setDescuento = (e) => {
  form.porcentaje_descuento = e
  sumaTotal()
  descuentoUno()
  sumaTotalPago()


}
const descuentoUno = () => {
  form.descuento = (form.porcentaje_descuento * form.total / 100).toFixed(2)
  form.total = (form.total - form.descuento).toFixed(2)
}
const listado_c = computed(() => {
  return usePage().props.clientes
});

const codigo_c = computed(() => {
  return usePage().props.venta.codigo
});

const listado_venta = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: false,
  options: [
    { "value": "INMEDIATA", "label": "INMEDIATA" },
    { "value": "DOMICILIO", "label": "DOMICILIO" }
  ],
});
onMounted(() => {
  let vent = usePage().props.venta;
  clientes.value.options = listado_c
  metodos.value.options = usePage().props.metodos_pago
  lista_metodos.value = usePage().props.metodos_pago
  lista_clientes.value = usePage().props.lista_clientes
  datos.value = usePage().props.productos.data;
  form.vendedor = usePage().props.vendedor
  form.user_id = vent.user_id
  form.cliente_id = vent.cliente_id
  form.codigo = codigo_c
  form.tipo_pago = vent.tipo_pago
  form.forma_entrega = vent.forma_entrega
  form.porcentaje_descuento = vent.porcentaje_descuento
  form.monto_efectivo = vent.pagos[0].monto_efectivo
  form.monto_tarjeta = vent.pagos[0].monto_tarjeta
  form.descuento = vent.descuento
  form.id = vent.id
  form.productos = usePage().props.detalle_productos
  form.metodo_pago = vent.pagos[0].metodo_pago
  form.metodo_pago_id = vent.pagos[0].metodo_pago_id
  form.pago_id = vent.pagos[0].id
  form.total = parseFloat(vent.total).toFixed(2)
  var tipo = lista_clientes.value.find(prod => prod.id === vent.cliente_id);
  tipo_cliente.value = tipo.tipo_cliente;
  tabla()
  calcularCambio();
});

const form = useForm({
  vendedor: '',
  user_id: '',
  codigo: '',
  pago_id: '',
  neto: '',
  cliente_id: '',
  porcentaje_descuento: '',
  descuento: '0',
  metodo_pago: '',
  metodo_pago_id: '',
  monto_efectivo: '',
  num_tarjeta: '',
  monto_tarjeta: '',
  productos: [],
  saldo: '0',
  total: '0',
  cambio: '0',
  suma_pago: '0',
  tipo_pago: 'CONTADO',
  forma_entrega: 'INMEDIATA'


})





const sumaTotalProducto = ($event, id, producto) => {
  if ($event.target.value > 0) {
    var prod = datos.value.find(prod => prod.id === producto);
    if (prod.stock >= form.productos[id].cantidad) {
      form.productos[id].total = (parseFloat(form.productos[id].cantidad) * parseFloat(form.productos[id].precio)).toFixed(2)
      sumaTotal()
      descuentoUno()
    } else {
      form.productos[id].cantidad = 1
      form.productos[id].total = (parseFloat(form.productos[id].cantidad) * parseFloat(form.productos[id].precio)).toFixed(2)
      alerta('La cantidad supera el Stock', 'error')
    }
  } else {
    return;
  }

}
const sumaTotal = () => {
  form.neto = (form.productos.reduce((acc, cur) => acc + parseFloat(cur['total']), 0)).toFixed(2)
  form.total = (form.productos.reduce((acc, cur) => acc + parseFloat(cur['total']), 0)).toFixed(2)

}
const sumaTotalPago = () => {
  form.suma_pago = parseFloat(form.monto_efectivo + form.monto_tarjeta).toFixed(2);
  let saldo = parseFloat(form.total) - parseFloat(form.suma_pago);
  form.saldo = saldo.toFixed(2);
  calcularCambio()
}

const calcularCambio = () => {
  form.cambio = parseFloat(form.monto_efectivo - form.total).toFixed(2);

}


const setTipoCliente = (e) => {
  form.clearErrors()
  tipo_cliente.value = '';
  //form.reset('metodo_pago', 'productos', 'total', 'porcentaje_descuento', 'porcentaje', 'saldo', 'suma_pago');
  var tipo = lista_clientes.value.find(prod => prod.id === e);
  tipo_cliente.value = tipo.tipo_cliente;
}
const setMetodoPago = (e) => {
  form.clearErrors()
  form.metodo_pago_id = e;
  form.monto_efectivo = 0;
  form.monto_tarjeta = 0;
  var tipo = lista_metodos.value.find(prod => prod.value === e);
  form.metodo_pago = tipo.label;
  form.cambio = 0
}

const setTipoPago = (e) => {

  if (e.target.checked) {
    form.tipo_pago = "CONTADO";
  } else {
    form.tipo_pago = "ABONO";
  }
}
const setFormaEntrega = (e) => {
  if (e.target.checked) {
    form.forma_entrega = "INMEDIATA";
  } else {
    form.forma_entrega = "DOMICILIO";
  }
}


const limpiarFormulario = () => {
  tipo_cliente.value = '';
  form.reset('metodo_pago', 'productos', 'total');

}


const agregarProducto = (id) => {

  alerta('No es posible agregar productos a este documento', 'error')
  return false;
  /*
  * Por solicitud del cliente no se deben agregar productos a documentos ya generados
  *  if (tipo_cliente.value != '') {
  *    var prod = datos.value.find(prod => prod.id === id);
  *    if (prod.stock > 0) {
  *      var precio = tipo_cliente.value == 'Minorista' ? prod.precio_venta : prod.precio_mayorista;
  *      form.productos.push(
  *        {
  *          producto_id: prod.id,
  *          nombre: prod.nombre,
  *          cantidad: 1,
  *          stock: prod.stock,
  *          precio: (precio).toFixed(2),
  *          total: (precio).toFixed(2)
  *        }
  *      )
  *      sumaTotal()
  *      descuentoUno()
  *      sumaTotalPago()
  *    } else {
  *      alerta('No hay stock disponible', 'error')
  *    }
  *  } else {
  *    alerta('Seleccione el cliente antes de agregar producto', 'error')
  *  }
  */
}
const removerProducto = (index) => {
  alerta('No es posible remover productos a este documento', 'error')
  return false;
  /*
  * Por solicitud del cliente no se deben remover productos de documentos ya generados
  *  form.productos.splice(index, 1);
  *  sumaTotal()
  *  descuentoUno()
  *  sumaTotalPago()
  */
}

//listado de cliente
const clientes = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: true,
  options: [],
});

//modal advertencia
const alerta = (mensaje, icono) => {
  Swal.fire({
    width: 350,
    title: mensaje,
    icon: icono
  })
}

//listado metodos de pago
const metodos = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: false,
  options: [],
});
const res_codigo = ref('');

//envio de formulario
const submit = () => {
  form.clearErrors()
  form.post(route('ventas.update', form.id), {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: () => {
      router.get(route('ventas.index'));
      form.reset('metodos_pago', 'productos', 'total', 'porcentaje_descuento', 'porcentaje', 'saldo', 'suma_pago');
    },
    onFinish: () => {
    },
    onError: () => {

    }
  });

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

      <!--Formulario venta-->
      <div
        class="p-4 mb-4 col-span-12 md:col-span-12 lg:col-span-6 bg-white rounded-lg border-gray-700 shadow dark:bg-gray-800 dark:border-gray-800  2xl:col-span-6  sm:p-4 ">
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
          role="alert">
          <svg class="flex-shrink-0 inline w-4 h-4 mr-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="currentColor" viewBox="0 0 20 20">
            <path
              d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
          </svg>
          <span class="sr-only">Danger</span>
          <div>
            <span class="font-normal text-xs">Estimado usuario. Si usted modifica esta información, sepa que
              puede
              generar un descuadre entre los montos de venta y la suma de pagos o abonos realizados.</span>
          </div>
        </div>
        <div class="px-5 col-span-full flex justify-center items-center">
          <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ titulo }}</h1>
        </div>

        <form @submit.prevent="submit">
          <div class="px-2 grid grid-cols-12 gap-2 lg:gap-2 mt-0 mb-2">
            <div class="grid grid-cols-12 gap-2 col-span-full lg:gap-2 mt-5">

              <div class="col-span-8  lg:col-span-9">
                <InputLabel for="vendedor" value="Usuario" class="block text-base font-medium leading-6  text-gray-900" />
                <TextInput id="vendedor" type="text"
                  class="rounded bg-gray-50 border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white font-bold disabled:bg-gray-200"
                  v-model="form.vendedor" disabled />
                <InputError class="mt-1 text-xs w-full" :message="form.errors.vendedor" />
              </div>


              <div class="col-span-4  lg:col-span-3">
                <InputLabel for="codigo" value="Código" class="block text-base font-medium leading-6 text-gray-900" />
                <TextInput id="codigo" type="text"
                  class="rounded bg-gray-50 border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600  text-center dark:text-white font-bold disabled:bg-gray-200"
                  v-model="form.codigo" disabled />
                <InputError class="mt-1 text-xs w-full " :message="form.errors.codigo" />
              </div>

            </div>


            <div class="grid grid-cols-12 gap-2  mt-0 col-span-full">
              <div class="col-span-8  lg:col-span-9">
                <InputLabel for="cliente_id" :value="'Cliente -- ' + tipo_cliente"
                  class="block text-base font-medium leading-6 text-gray-900" />
                <!--@clear="limpiarFormulario"-->
                <Multiselect id="cliente_id" v-model="form.cliente_id" v-bind="clientes" @select="setTipoCliente">
                </Multiselect>
                <InputError class="mt-1 text-xs" :message="form.errors.cliente_id" />
              </div>

              <div class="col-span-4 lg:col-span-3 flex items-end mb-0.5 justify-end">

                <CrearClientExterno @creado="regenClientes"></CrearClientExterno>
              </div>
            </div>

            <!--TipoVenta-->
            <div class="grid grid-cols-12 gap-2 col-span-full  py-2 my-2 border-t-2 border-b-2 lg:gap-2">
              <div class="col-span-6 hidden">
                <InputLabel for="tipo_pago" value="Condición de pago"
                  class="block text-sm font-medium leading-6 text-gray-900 " />
                <label class="relative inline-flex items-center cursor-pointer">
                  <input @change="setTipoPago" type="checkbox" value="" class="sr-only peer"
                    :checked="form.tipo_pago == 'CONTADO'">
                  <div
                    class="w-11 h-6 bg-green-600 rounded-full peer dark:bg-green-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                  </div>
                  <span class="ml-3  text-gray-900 text-md font-normal dark:text-gray-500">{{
                    form.tipo_pago }}</span>
                </label>
              </div>
              <div class="col-span-6">
                <InputLabel for="forma_entrega" value="Forma de entrega"
                  class="block text-sm font-medium leading-6 text-gray-900 " />
                <label class="relative inline-flex items-center cursor-pointer">
                  <input @change="setFormaEntrega" type="checkbox" value="" class="sr-only peer"
                    :checked="form.forma_entrega == 'INMEDIATA'">
                  <div
                    class="w-11 h-6 bg-green-600 rounded-full peer dark:bg-green-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                  </div>
                  <span class="ml-3  text-gray-900 text-md font-normal dark:text-gray-500">{{
                    form.forma_entrega }}</span>
                </label>
              </div>

            </div>
            <!--/TipoVenta-->


            <div class="grid grid-cols-12 mt-2 col-span-12 text-center">

              <div class="col-span-3  lg:col-span-6">
                <InputLabel value="Item" class="m-0 text-md font-medium leading-6 text-gray-900" />

              </div>
              <div class="col-span-3  lg:col-span-2">
                <InputLabel value="Precio" class="m-0 text-md font-medium leading-6 text-gray-900" />
              </div>
              <div class="col-span-3  lg:col-span-2">
                <InputLabel value="Cantidad" class="m-0 text-md font-medium leading-6 text-gray-900" />

              </div>
              <div class="col-span-3  lg:col-span-2">
                <InputLabel value="Subtotal" class="m-0 text-md font-medium leading-6 text-gray-900" />
              </div>
            </div>

            <div v-for="(producto, index) in form.productos" :key="index" class="grid grid-cols-12 gap-2 col-span-full">
              <div class="col-span-3 lg:col-span-6">

                <div class="flex">
                  <span
                    class="rounded-none rounded-l inline-flex justify-center hidden bg-red-600  text-base font-semibold text-white hover:bg-red-700">
                    <button @click.prevent="removerProducto(index)" class="w-6"><i class="fas fa-times"></i></button>
                  </span>
                  <TextInput disabled
                    class="rounded-none rounded-r bg-gray-50 border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white disabled:bg-gray-200"
                    type="text" v-model="producto.nombre" />
                </div>

              </div>

              <div class="col-span-3  lg:col-span-2">

                <div class="flex">
                  <TextInput disabled
                    class="rounded text-end  text-xs bg-gray-50 border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white disabled:bg-gray-200"
                    type="text" v-model="producto.precio" />
                </div>

              </div>
              <div class="col-span-3  lg:col-span-2">
                <div class="flex">
                  <TextInput
                    class="rounded text-end bg-gray-50 border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white "
                    type="number" min="1" step="1" readonly v-model="producto.cantidad"
                    @input="sumaTotalProducto($event, index)" />
                </div>
              </div>
              <div class="col-span-3  lg:col-span-2">

                <div class="flex">
                  <TextInput disabled
                    class="rounded text-end bg-gray-50 text-xs border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white disabled:bg-gray-200"
                    type="text" v-model="producto.total" />
                </div>

              </div>
            </div>
            <div class="col-span-12  lg:col-span-12">
              <InputError class="mt-1 text-xs w-full " :message="form.errors.productos" />
            </div>






            <!--Descuento-->
            <div class="grid grid-cols-12 gap-2  mt-0 col-span-12  lg:col-span-6 items-center"
              v-if="form.porcentaje_descuento > 0">
              <div class="col-span-12  lg:col-span-4">

              </div>
              <div class="col-span-12  lg:col-span-3">
                <InputLabel for="descuento" value="Descuento"
                  class="block text-base text-end font-normal leading-6 text-gray-900" />
              </div>
              <div class="col-span-12  lg:col-span-2">
                <div class="flex">
                  <TextInput disabled
                    class="rounded-none rounded-l bg-gray-50 border border-gray-300 text-gray-900 disabled:bg-gray-200 text-end min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white"
                    type="text" v-model="form.porcentaje_descuento" />
                  <span
                    class="inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-l-0 border-gray-300 rounded-r-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    <i class="fas fa-percentage"></i>
                  </span>
                </div>
              </div>

              <div class="col-span-12  lg:col-span-3">

                <div class="flex">
                  <span
                    class="inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    <i class="fas fa-dollar-sign"></i> </span>
                  <TextInput disabled
                    class="rounded-none text-end rounded-r bg-gray-50 border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white disabled:bg-gray-200"
                    type="number" v-model="form.descuento" />
                </div>
                <InputError class="mt-1 text-xs w-full " :message="form.errors.descuento" />
              </div>
            </div>
            <!--/Descuento-->

            <!--Total-->
            <div class="grid grid-cols-12 gap-2  mt-0 col-span-full">
              <div class="col-span-12 lg:col-span-5 flex justify-start items-end">
                <AgregarDescuentoModal @valDescuento="setDescuento" v-if="form.total > 0">
                </AgregarDescuentoModal>
              </div>
              <div class="col-span-6 lg:col-span-4 flex justify-end items-end">
                <InputLabel for="total" value="Total a pagar"
                  class="block text-base font-normal leading-6 text-gray-900" />
              </div>
              <div class="col-span-6  lg:col-span-3">

                <div class="flex">
                  <span
                    class="inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    <i class="fas fa-dollar-sign"></i>
                  </span>
                  <TextInput disabled
                    class="rounded-none text-end rounded-r bg-gray-50 border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white disabled:bg-gray-200"
                    type="number" v-model="form.total" />
                </div>
                <InputError class="mt-1 text-xs w-full " :message="form.errors.total" />
              </div>
            </div>
            <!--/Total-->


            <!--Metodos de pago-->
            <div class="grid grid-cols-12  mt-0 col-span-full text-start">
              <div class="col-span-12  lg:col-span-8">
                <InputLabel for="metodos" value="Métodos de Pago"
                  class="block text-md font-medium leading-6 text-gray-900" />
                <Multiselect v-model="form.metodo_pago_id" v-bind="metodos" @select="setMetodoPago" disabled>
                </Multiselect>
              </div>

              <!--Efectivo-->

              <div class="grid grid-cols-12 gap-3 col-span-full text-center">

                <div class="col-span-6 lg:col-span-8 flex pt-3 mt-3 justify-end">
                  <InputLabel value="Efectivo:" class="m-1 pb-0 text-xs font-medium leading-6 text-gray-900" readonly />

                </div>
                <div class="col-span-6  lg:col-span-4">
                  <InputLabel for="monto" value="Monto" class="block mb-0 text-xs font-normal leading-6 text-gray-900"
                    readonly />

                  <div class="flex">

                    <span
                      class="inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                    <TextInput :disabled="form.metodo_pago_id == 2"
                      class="rounded  bg-gray-50 border border-gray-300 text-gray-900 text-end min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white "
                      type="number" step="0.1" v-model="form.monto_efectivo" @input="sumaTotalPago" readonly />
                  </div>
                  <InputError class="mt-1 text-start  w-full" :message="form.errors.monto_efectivo" readonly />
                </div>

                <!--

                                    <div class="col-span-12  lg:col-span-4">
                                        <InputLabel for="monto" value="Cambio"
                                        class="block text-xs font-normal leading-6 text-gray-900" />

                                        <div class="flex">
                                            <span
                                            class="inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        <TextInput disabled
                                        class="rounded-none text-end rounded-r bg-gray-50 border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white disabled:bg-gray-200"
                                        type="number" v-model="form.cambio" />
                                    </div>
                                </div>
                            -->

              </div>
              <!--/Efectivo-->
              <!--tarjetas--->
              <div v-if="form.metodo_pago_id == 2 || form.metodo_pago_id == 3"
                class="grid mt-3 grid-cols-12 gap-3 col-span-full  text-center">

                <div class="col-span-6 lg:col-span-4 flex pt-3 mt-3 justify-end">
                  <InputLabel value="Tarjeta Debito/Credito:"
                    class="m-1 pb-0 text-xs font-medium leading-6 text-gray-900" />

                </div>
                <div class="col-span-6  lg:col-span-4">
                  <InputLabel for="monto" value="Monto" class="block text-xs font-normal leading-6 text-gray-900" />

                  <div class="flex">

                    <span
                      class="inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                    <TextInput
                      class="rounded  bg-gray-50 border border-gray-300 text-gray-900 text-end  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white "
                      type="number" step="0.1" v-model="form.monto_tarjeta" @input="sumaTotalPago" />
                  </div>
                  <InputError class="mt-1 text-start  w-full" :message="form.errors.monto_tarjeta" />
                </div>
                <div class="col-span-6 md:block lg:hidden lg:col-span-4">

                </div>
                <div class="col-span-6  lg:col-span-4">
                  <InputLabel for="tarjeta" value="Tres últimos digitos"
                    class="block text-xs font-normal leading-6 text-gray-900" />
                  <div class="flex">
                    <span
                      class="inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                      <i class="fas fa-credit-card"></i>
                    </span>
                    <TextInput
                      class="rounded-none rounded-r bg-gray-50 border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white"
                      type="text" v-model="form.num_tarjeta" />
                  </div>
                  <InputError class="mt-1 text-start w-full " :message="form.errors.num_tarjeta" />
                </div>

              </div>
              <!--tarjetas--->

              <div v-if="form.tipo_pago == 'ABONO'"
                class="grid mt-3 grid-cols-12 gap-3 col-span-full  lg:col-span-12 text-center">

                <div class="col-span-12 lg:col-span-4 flex items-end justify-end">
                </div>
                <div class="col-span-8 lg:col-span-4">
                </div>
                <div class="col-span-4 lg:col-span-4">
                  <InputLabel for="saldo" value="Saldo" class="block text-xs font-normal leading-6 text-gray-900" />

                  <div class="flex">
                    <span
                      class="inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                    <TextInput disabled
                      class="rounded-none text-end rounded-r bg-gray-50 border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white disabled:bg-gray-200"
                      type="number" v-model="form.saldo" />
                  </div>
                  <InputError class="mt-1 text-xs w-full " :message="form.errors.saldo" />
                </div>
              </div>
            </div>
            <!--/Metodos de pago-->


          </div>

          <div class="flex justify-end pt-5">
            <PrimaryButton
              class="inline-block rounded bg-blue-600 p-2 text-sm font-semibold text-white mr-1 mb-1 hover:bg-blue-700"
              :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
              Guardar Venta
            </PrimaryButton>
          </div>
        </form>
      </div>

      <!--Productos-->
      <div
        class="p-4 mb-4 col-span-12 md:col-span-12 lg:col-span-6 bg-white rounded-lg border-gray-700 shadow dark:bg-gray-800 dark:border-gray-800  sm:p-4 ">
        <div class="overflow-x-auto">
          <table id="tabla1" class="pt-4 w-full text-xs text-center text-gray-600 dark:text-gray-400">
            <thead class="text-md text-center text-gray-700 bg-gray-200/80 dark:bg-gray-700 dark:text-gray-400">
              <tr>

                <th scope="col" class="border border-gray-300 dark:border-gray-500 w-8 p-0">
                  <div class="flex justify-center text-center">
                    Imagen
                  </div>
                </th>
                <th scope="col" class="border border-gray-300 dark:border-gray-500">
                  <div class="flex justify-center  text-center">
                    Nombre
                  </div>
                </th>
                <th scope="col" class="border border-gray-300 dark:border-gray-500 w-8">
                  <div class="flex justify-center">
                    Código
                  </div>
                </th>

                <th scope="col" class="p-0 m-0 border border-gray-300 dark:border-gray-500 w-8">
                  <div class="flex justify-center">
                    Stock
                  </div>
                </th>

                <th scope="col" class="border border-gray-300 dark:border-gray-500 w-10">
                  <div class="flex justify-center">
                    Acciones
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr :key="id" v-for="{
                id, nombre, imagen_1, codigo, stock, precio_compra, precio_venta, precio_mayorista
              }, index in datos" class="bg-white text-center dark:bg-gray-800 dark:border-gray-700">

                <td scope="row" class="p-0 m-0 border dark:border-gray-700">
                  <div class=" flex justify-center">

                    <img class="rounded shadow-2xl border-2 w-12 h-12 object-contain" :src="imagen_1"
                      alt="image description">
                  </div>
                </td>
                <th scope="row"
                  class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                  {{ nombre }}
                </th>
                <td scope="row" class="p-1 border dark:border-gray-700">
                  {{ codigo }}
                </td>

                <td scope="row" class="p-1 border dark:border-gray-700">
                  <StockColor :cantidad="stock">
                    {{ stock }}
                  </StockColor>
                </td>

                <td scope="row" class="p-1 border dark:border-gray-700">
                  <span
                    :class="form.productos.filter(e => e.producto_id === id).length > 0 ? 'bg-blue-400' : ' bg-blue-600 hover:bg-blue-700'"
                    class="inline-block rounded  px-2 py-1 text-xs font-normal text-white mr-1 mb-1">
                    <button @click="agregarProducto(id)"
                      :disabled="form.productos.filter(e => e.producto_id === id).length > 0">Agregar</button>
                  </span>

                </td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>


<style type="text/css">
@import 'datatables.net-dt';
</style>
