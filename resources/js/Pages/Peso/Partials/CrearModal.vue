<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm,router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {ref } from 'vue';
import Swal from 'sweetalert2';
const isShowModal = ref(false);


const addCliente = () => {
    isShowModal.value = true;

};

const titulo="Peso"
const ruta="pesos";

const closeModal = () => {
    isShowModal.value = false;
    form.reset();
};

const form = useForm({
    codigo: '',
    nombre: '',
    comentario:''
})


//envio de formulario
const submit = () => {

form.clearErrors()
form.post(route(ruta+'.store'), {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: () => {
        isShowModal.value = false
        ok( titulo+' Creada');
        router.get(route(ruta+'.index'));
    },
    onFinish: () => {

        //form.reset()
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
</script>

<template>
<section class="space-y-4">
    <button type="button" @click="addCliente"
        class="m-1 p-2 text-sm font-medium rounded text-center text-white bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-700">
        Agregar {{titulo}}
    </button>

    <Modal :show="isShowModal" @close="closeModal" maxWidth="md">
        <div class="p-2">

            <div class="p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600">
                <h2 class="text-lg font-medium text-gray-900">
                    Crear {{ titulo }}
                </h2>

            </div>
                <form @submit.prevent="submit">
                    <div class="px-2 grid grid-cols-6 gap-4 md:gap-3 2xl:gap-6 mb-2">

                        <div class="col-span-6 shadow-default xl:col-span-6">
                            <InputLabel for="codigo" value="Código"
                                class="block text-base font-medium leading-6 text-gray-900" />
                            <TextInput id="codigo" type="text" v-model="form.codigo" autocomplete="codigo"
                                placeholder="Ingrese código" />
                            <InputError class="mt-1 text-xs" :message="form.errors.codigo" />
                        </div>
                        <div class="col-span-6 shadow-default xl:col-span-6">
                            <InputLabel for="nombre" value="Nombre"
                                class="block text-base font-medium leading-6 text-gray-900" />
                            <TextInput id="nombre" type="text" v-model="form.nombre" autocomplete="nombre"
                                placeholder="Ingrese nombre" />
                            <InputError class="mt-1 text-xs" :message="form.errors.nombre" />
                        </div>

                        <div class="col-span-6 shadow-default xl:col-span-6">
                            <InputLabel for="comentario" value="Comentario"
                                class="block text-base font-medium leading-6 text-gray-900" />
                            <TextInput id="comentario" type="text" v-model="form.comentario" autocomplete="comentario"
                                placeholder="Ingrese Comentario" />
                            <InputError class="mt-1 text-xs" :message="form.errors.comentario" />
                        </div>

                    </div>
                    <div class="flex justify-end pt-0">
                        <button @click="closeModal" type="button"
                            class="inline-block rounded bg-red-600 p-2 text-sm font-semibold text-white mr-4 mb-1 hover:bg-red-700">
                            Cancelar
                        </button>
                        <PrimaryButton
                            class="inline-block rounded bg-blue-600 p-2 text-sm font-semibold text-white mr-1 mb-1 hover:bg-blue-700"
                            :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                            Guardar
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>
    </section>
</template>
