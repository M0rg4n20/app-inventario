<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, computed, ref, nextTick } from 'vue'
import { Head, usePage, useForm, router, Link } from '@inertiajs/vue3';
import { Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import Swal from 'sweetalert2';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Multiselect from '@vueform/multiselect';

const {user}=usePage().props.auth;

const titulo = "Devolución"
const ruta = "kardex";

const form = useForm({
    producto_id: '',
    codigo: '',
    proveedor: '',
    cantidad: '',
    ticket: 0,
    user_id:'',
    comentario:'',
    tipo:''


})

onMounted(() => {
    productos.value.options = usePage().props.productos;
    form.user_id=user.id

});

//envio de formulario
const submit = () => {

form.clearErrors()
form.post(route(ruta+'.guardar_devolucion'), {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: () => {
        ok( titulo+' Creada');
        router.get(route(ruta+'.index'));
    },
    onFinish: () => {
    },
    onError: () => {

    }
});

};
const ok = (mensaje) => {
form.reset();

Swal.fire({
    width: 350,
    title: mensaje,
    icon: 'success'
})
}
//listado productos
const productos = ref({
    value: '',
    closeOnSelect: true,
    placeholder: "Seleccione",
    searchable: false,
    options: [],
});
const tipo_devolucion = ref({
    value: '',
    closeOnSelect: true,
    placeholder: "Seleccione",
    searchable: false,
    options: [
        { "value": "SALIDA POR PRODUCTO DAÑADO", "label": "SALIDA POR PRODUCTO DAÑADO" },
        { "value": "SALIDA POR DEVOLUCIÓN", "label": "SALIDA POR DEVOLUCIÓN" }
    ],
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
            <div class="px-4 col-span-full flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{ titulo }}</h1>
            </div>
            <div
            class="p-4 mb-4 bg-white col-span-7 pb-5 rounded-lg shadow-sm 2xl:col-span-7 dark:border-gray-700 sm:p-4 dark:bg-gray-800">
                <form @submit.prevent="submit">
                    <div class="col-span-12 p-2 xl:col-span-9">
                        <InputLabel for="cliente_id" value="Producto"
                            class="block text-base font-medium leading-6 text-gray-900" />
                        <Multiselect id="cliente_id" v-model="form.producto_id" v-bind="productos">
                        </Multiselect>
                        <InputError class="mt-1 text-xs" :message="form.errors.producto_id" />
                    </div>
                    <div class="col-span-12 p-2 xl:col-span-9">
                        <InputLabel for="tipo" value="Tipo devolución"
                            class="block text-base font-medium leading-6 text-gray-900" />
                        <Multiselect id="tipo" v-model="form.tipo" v-bind="tipo_devolucion">
                        </Multiselect>
                        <InputError class="mt-1 text-xs" :message="form.errors.tipo" />
                    </div>

                    <div class="col-span-12 p-2 xl:col-span-9">
                        <InputLabel for="cantidad" value="Cantidad"
                            class="block text-base font-medium leading-6 text-gray-900" />
                        <TextInput id="cantidad"  type="number" min="1" step="1" v-model="form.cantidad" placeholder="Ingrese cantidad" />
                        <InputError class="mt-1 text-xs" :message="form.errors.cantidad" />
                    </div>
                    <div class="col-span-12 p-2 xl:col-span-9">
                        <InputLabel for="proveedor" value="Proveedor"
                            class="block text-base font-medium leading-6 text-gray-900" />
                        <TextInput id="proveedor" type="text" v-model="form.proveedor" placeholder="Ingrese proveedor" />
                        <InputError class="mt-1 text-xs" :message="form.errors.proveedor" />
                    </div>
                    <div class="col-span-12 p-2 xl:col-span-9">
                        <InputLabel for="ticket" value="#Factura"
                            class="block text-base font-medium leading-6 text-gray-900" />
                        <TextInput id="ticket" type="text" v-model="form.ticket" placeholder="Ingrese Factura proveedor" />
                        <InputError class="mt-1 text-xs" :message="form.errors.ticket" />
                    </div>
                    <div class="col-span-12 p-2 xl:col-span-9">
                        <InputLabel for="codigo" value="Código"
                            class="block text-base font-medium leading-6 text-gray-900" />
                        <TextInput id="codigo" type="text" v-model="form.codigo" placeholder="#" />
                        <InputError class="mt-1 text-xs" :message="form.errors.codigo" />
                    </div>
                    <div class="col-span-12 p-2 xl:col-span-9">
                        <InputLabel for="comentario" value="Comentario"
                            class="block text-base font-medium leading-6 text-gray-900" />
                            <textarea id="comentario" placeholder="Motivo de salida" v-model="form.comentario" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-md rounded p-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white  dark:focus:border-primary-500" rows="2" cols="50"></textarea>
                        <InputError class="mt-1 text-xs" :message="form.errors.comentario" />
                    </div>
                    <div class="flex justify-end pt-2">

                        <PrimaryButton
                            class="inline-block rounded bg-blue-600 p-2 text-sm font-semibold text-white mr-1 mb-1 hover:bg-blue-700"
                            :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                            Enviar
                        </PrimaryButton>
                    </div>

                </form>
            </div>
        </AuthenticatedLayout>
    </div>
</template>


<style type="text/css">

</style>
