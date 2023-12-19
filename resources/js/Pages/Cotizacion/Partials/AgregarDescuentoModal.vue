<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2';
const isShowModal = ref(false);


const emit = defineEmits(['valDescuento']);

const addCliente = () => {
    isShowModal.value = true;
};

onMounted(() => {


});


const closeModal = () => {
    isShowModal.value = false;
    form.reset();
};


const form = useForm({
    descuento: '',
    contrasena: '',


})

//envio de formulario
const submit = () => {

    form.clearErrors()
    form.post(route('ventas.descuento'), {
        preserveScroll: true,
        //forceFormData: true,
        onSuccess: () => {
            isShowModal.value = false
            //ok('Producto Creado')
            emit('valDescuento', form.descuento);
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
    <section class="space-y-4">
        <button type="button" @click="addCliente"
            class="inline-block rounded bg-green-600 px-2  hover:bg-green-700 py-1 text-xs font-normal text-white mr-1 mb-1">
            Aplicar Descuento
        </button>

        <Modal :show="isShowModal" @close="closeModal" max-width="sm">
            <div class="p-2">

                <div
                    class="p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-lg font-medium text-gray-900">
                        Aplicar Descuento
                    </h2>

                </div>
                <form @submit.prevent="submit">
                    <div class="px-2 grid grid-cols-6 gap-4 md:gap-4 2xl:gap-2 mb-2">

                        <div class="col-span-4 shadow-default xl:col-span-6">
                            <InputLabel for="descuento" value="Descuento %"
                                class="block text-base font-medium leading-6 text-gray-900" />
                            <div class="flex">
                                <TextInput
                                    class="rounded-none rounded-l bg-gray-50 border border-gray-300 text-gray-900 disabled:bg-gray-200 text-end min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white"
                                    type="number" v-model="form.descuento" />
                                <span
                                    class="inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-l-0 border-gray-300 rounded-r-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                    <i class="fas fa-percentage"></i>
                                </span>
                            </div>
                            <InputError class="mt-1 text-xs" :message="form.errors.descuento" />
                        </div>
                        <div class="col-span-6 shadow-default xl:col-span-6">
                            <InputLabel for="contrasena" value="Contraseña"
                                class="block text-base font-medium leading-6 text-gray-900" />
                            <TextInput id="contrasena" type="password" v-model="form.contrasena"
                                placeholder="Ingrese contrasena" />
                            <InputError class="mt-1 text-xs" :message="form.errors.contrasena" />
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


<style type="text/css" scoped>
.imagePreviewWrapper {
    background-repeat: no-repeat;
    width: 60px;
    height: 60px;
    display: block;
    margin: 0 auto;
    background-size: contain;
    background-position: center center;
}
</style>
