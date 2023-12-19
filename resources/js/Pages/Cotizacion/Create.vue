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
import AgregarDescuentoModal from '@/Pages/Cotizacion/Partials/AgregarDescuentoModal.vue';
import language from 'datatables.net-plugins/i18n/es-ES.mjs';
DataTable.use(DataTablesCore);

const datos = ref([]);
const tabla1 = ref(null);
const tipo_cliente = ref('');
const lista_clientes = ref([]);

const titulo = "Crear Cotización"

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
    return usePage().props.codigo
});

const listado_venta = ref({
    value: '',
    closeOnSelect: true,
    placeholder: "Seleccione",
    searchable: false,
    options: [
        { "value": "Contado", "label": "Contado" },
        { "value": "Abono", "label": "Abono" },
        { "value": "Domicilio", "label": "Domicilio" }
    ],
});
onMounted(() => {
    //clientes.value.options = usePage().props.clientes
    clientes.value.options = listado_c
    metodos.value.options = usePage().props.metodos_pago
    lista_clientes.value = usePage().props.lista_clientes
    datos.value = usePage().props.productos.data;
    form.vendedor = usePage().props.vendedor
    form.user_id = usePage().props.user_id
    form.codigo = codigo_c
    tabla()
});

const form = useForm({
    vendedor: '',
    user_id: '',
    codigo: '',
    neto: '',
    cliente_id: '',
    porcentaje_descuento: '',
    descuento: '0',
    metodos_pago: [{
        metodo_pago_id: '',
        monto: '',
        tarjeta: ''
    }],
    productos: [],
    saldo: '0',
    total: '0',
    tipo_venta: 'Contado'


})

const agregarMetodo = () => {
    form.metodos_pago.push(
        {
            metodo_pago_id: '',
            monto: '',
            tarjeta: ''
        }
    )

}
//funcion permitir solo numero inputs
const onlyNumber = ($event) => {
    let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
    if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
        $event.preventDefault();
    }
}

const sumaTotalProducto = ($event, id) => {
    if ($event.target.value > 0) {

        if (form.productos[id].stock >= form.productos[id].cantidad) {
            form.productos[id].total = (parseFloat(form.productos[id].cantidad) * parseFloat(form.productos[id].precio)).toFixed(2)
            sumaTotal()
            descuentoUno()
        } else {
            form.productos[id].cantidad = 1
            form.productos[id].total = (parseFloat(form.productos[id].cantidad) * parseFloat(form.productos[id].precio)).toFixed(2)
            alerta('La cantidad supera el Stock', 'error')
        }
        //form.total = form.productos.reduce((acc, cur) => acc + parseFloat(cur['total']), 0)
    } else {
        return;
    }
}
const sumaTotal = () => {
    form.neto = (form.productos.reduce((acc, cur) => acc + parseFloat(cur['total']), 0)).toFixed(2)
    form.total = (form.productos.reduce((acc, cur) => acc + parseFloat(cur['total']), 0)).toFixed(2)

}
const sumaTotalPago = () => {
    form.suma_pago = (form.metodos_pago.reduce((acc, cur) => acc + parseFloat(cur['monto']), 0)).toFixed(2)
    form.saldo = (form.total - form.suma_pago).toFixed(2);

}


const setTipoCliente = (e) => {
    tipo_cliente.value = '';
    form.reset('metodos_pago', 'productos', 'total', 'porcentaje_descuento', 'porcentaje', 'saldo', 'suma_pago');
    var tipo = lista_clientes.value.find(prod => prod.id === e);
    tipo_cliente.value = tipo.tipo_cliente;
}


const limpiarFormulario = () => {
    tipo_cliente.value = '';
    form.reset('metodos_pago', 'productos', 'total');

}
const agregarProducto = (id) => {
    if (tipo_cliente.value != '') {

        var prod = datos.value.find(prod => prod.id === id);
        if (prod.stock > 0) {
            var precio = tipo_cliente.value == 'Minorista' ? prod.precio_venta : prod.precio_mayorista;
            form.productos.push(
                {
                    producto_id: prod.id,
                    nombre: prod.nombre,
                    cantidad: 1,
                    stock: prod.stock,
                    precio: (precio).toFixed(2),
                    total: (precio).toFixed(2)
                }
            )
            sumaTotal()
            descuentoUno()
            sumaTotalPago()
        } else {
            alerta('No hay stock disponible', 'error')
        }
    } else {
        alerta('Seleccione el cliente antes de agregar producto', 'error')
    }

}
const removerProducto = (index) => {
    form.productos.splice(index, 1);
    sumaTotal()
    descuentoUno()
    sumaTotalPago()
}
const removePago = (index) => {
    form.metodos_pago.splice(index, 1);
    sumaTotalPago();
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
    form.post(route('cotizaciones.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {

            res_codigo.value = usePage().props.flash.success;
            if (res_codigo.value !== null) {
                window.open(route('cotizaciones.generar_ticket', res_codigo.value), '_blank');
            }
            tipo_cliente.value = '';
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

                <div class="px-5 col-span-full flex justify-center items-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ titulo }}</h1>
                </div>

                <form @submit.prevent="submit">
                    <div class="px-2 grid grid-cols-12 gap-2 lg:gap-2 mt-0 mb-2">

                        <div class="grid grid-cols-12 gap-2 col-span-full lg:gap-2 mt-5">

                            <div class="col-span-8  lg:col-span-9">
                                <InputLabel for="vendedor" value="Usuario"
                                    class="block text-base font-medium leading-6  text-gray-900" />
                                <TextInput id="vendedor" type="text"
                                    class="rounded bg-gray-50 border border-gray-300 text-gray-900  min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white font-bold disabled:bg-gray-200"
                                    v-model="form.vendedor" disabled />
                                <InputError class="mt-1 text-xs w-full" :message="form.errors.vendedor" />
                            </div>


                            <div class="col-span-4  lg:col-span-3">
                                <InputLabel for="codigo" value="Código"
                                    class="block text-base font-medium leading-6 text-gray-900" />
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
                                <Multiselect id="cliente_id" v-model="form.cliente_id" v-bind="clientes"
                                    @clear="limpiarFormulario" @select="setTipoCliente">
                                </Multiselect>
                                <InputError class="mt-1 text-xs" :message="form.errors.cliente_id" />
                            </div>

                            <div class="col-span-4 lg:col-span-3 flex items-end mb-0.5 justify-end">

                                <CrearClientExterno @creado="regenClientes"></CrearClientExterno>
                            </div>
                        </div>




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

                        <div v-for="(producto, index) in form.productos" :key="index"
                            class="grid grid-cols-12 gap-2 col-span-full">
                            <div class="col-span-3 lg:col-span-6">

                                <div class="flex">
                                    <span
                                        class="rounded-none rounded-l inline-flex justify-center bg-red-600  text-base font-semibold text-white hover:bg-red-700">
                                        <button @click.prevent="removerProducto(index)" class="w-6"><i
                                                class="fas fa-times"></i></button>
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
                                        type="number" min="1" step="1" v-model="producto.cantidad"
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

                    </div>

                    <div class="flex justify-end pt-5">
                        <PrimaryButton
                            class="inline-block rounded bg-blue-600 p-2 text-sm font-semibold text-white mr-1 mb-1 hover:bg-blue-700"
                            :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                            Guardar Cotización
                        </PrimaryButton>
                    </div>
                </form>
            </div>

            <!--Productos-->
            <div
                class="p-4 mb-4 col-span-12 md:col-span-12 lg:col-span-6 bg-white rounded-lg border-gray-700 shadow dark:bg-gray-800 dark:border-gray-800  2xl:col-span-6  sm:p-4 ">
                <div class="overflow-x-auto">
                    <div class="">
                        <div class="overflow-auto">

                            <table id="tabla1" class="pt-4 w-full text-xs text-center text-gray-600 dark:text-gray-400">
                                <thead
                                    class="text-md text-center text-gray-700 bg-gray-200/80 dark:bg-gray-700 dark:text-gray-400">
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
                                    }, index in datos"
                                        class="bg-white text-center dark:bg-gray-800 dark:border-gray-700">

                                        <td scope="row" class="p-0 m-0 border dark:border-gray-700">
                                            <div class=" flex justify-center">

                                                <img class="rounded shadow-2xl border-2 w-12 h-12 object-contain"
                                                    :src="imagen_1" alt="image description">
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
