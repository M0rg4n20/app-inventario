<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm,router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';

//Variables
const isShowModal = ref(false);

const titulo="Longitud"
const ruta="longitudes";

const form = useForm({
    id: '',
    codigo: '',
    nombre: '',
    comentario: '',
})


const props = defineProps({
    categoriaId: {
        type: Number,
        default: null,
    },


});


//Funciones
const addCliente = () => {
    dataEdit(props.categoriaId);
};

const dataEdit = (id) => {
    axios.get(route(ruta+'.show', id))
  .then(res => {
    isShowModal.value = true;
    var datos=res.data.data
    form.id=datos.id
    form.codigo=datos.codigo
    form.nombre=datos.nombre
    form.comentario=datos.comentario
  })

};


const closeModal = () => {
    isShowModal.value = false;
    form.reset();
};


//envio de formulario
const submit = () => {

form.clearErrors()
form.post(route(ruta+'.update',form.id), {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: () => {
        isShowModal.value = false
        ok(titulo+' editada')
        router.get(route(ruta+'.index'));
        form.reset()
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
</script>

<template>
<section>
    <button type="button" @click="addCliente"><i class="fas fa-edit"></i></button>

    <Modal :show="isShowModal" @close="closeModal" maxWidth="md">
        <div class="p-2">

            <div class="p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600">
                <h2 class="text-lg font-medium text-gray-900">
                    Editar {{ titulo }}
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
