<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';
import Multiselect from '@vueform/multiselect';

//Variables
const isShowModal = ref(false);
const { user } = usePage().props.auth;
const form = useForm({
  id: '',
  acciones: '',
  comentario: '',
})

const titulo = "Retiros"
const ruta = "retiros";

const props = defineProps({
  id: {
    default: '',
  },
});

const acciones = ref({
  value: '',
  placeholder: "Seleccione",
  options: [
    { "value": "1", "label": "Aprobar" },
    { "value": "2", "label": "Denegar" }
  ],
});

const showModal = () => {
  isShowModal.value = true;
  form.id = props.id;
};

const closeModal = () => {
  isShowModal.value = false;
  form.reset();
};

//envio de formulario
const submit = () => {
  form.clearErrors();

  const formData = new FormData();
  formData.append('id', form.id);
  formData.append('acciones', form.acciones);
  formData.append('comentario', form.comentario);

  axios.post(route(ruta + '.update', form.id), formData)
    .then(response => {
      isShowModal.value = false;
      form.reset();
      router.get(route(ruta + '.index'));
      Swal.fire({
        width: 350,
        title: 'completado',
        icon: 'success'
      });
    })
    .catch(error => {
      console.error(error);
    });
};
</script>

<template>
  <div>
    <button type="button"
      class="rounded bg-green-500 px-1 py-1 text-xs font-normal text-white mr-1 mb-1 hover:bg-green-700"
      @click="showModal">Aprobar / Rechazar</button>
    <Modal :show="isShowModal" @close="closeModal" maxWidth="md">
      <div class="p-2">
        <div class="p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600">
          <h2 class="text-lg font-medium text-gray-900">
            {{ titulo }}
          </h2>
        </div>

        <form @submit.prevent="submit">
          <div class="px-2 grid grid-cols-6 gap-4 md:gap-3 2xl:gap-6 mb-2">
            <div class="col-span-6 shadow-default xl:col-span-6">
              <InputLabel value="Operación" class="block text-base font-medium leading-6 text-gray-900" />
              <Multiselect v-model="form.acciones" :options="acciones.options" placeholder="Seleccione" />
            </div>
            <div class="col-span-6 shadow-default xl:col-span-6">
              <InputLabel value="Operación" class="block text-base font-medium leading-6 text-gray-900" />
              <TextInput v-model="form.comentario" placeholder="Comentarios"
                class="block text-base font-medium leading-6 text-gray-900" />
              <InputError class="mt-1 text-xs" :message="form.errors.comentario" />
            </div>
          </div>

          <div class="flex justify-end pt-2">
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
  </div>
</template>
