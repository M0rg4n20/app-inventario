<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, watch } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';

import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
import 'vue-datepicker-next/locale/es.es.js';
//Variables
const isShowModal = ref(false);
const fec_nac = ref()
const of_colonia = ref('')
const casa_colonia = ref('')
const ruta = "pedidos"
const form = useForm({
  id: '',
  comentario: '',
  telefono: '',
  casa_direccion: '',
  casa_colonia: '',
  fecha: '',
  hora: '',
})


const props = defineProps({
  clienteId: {
    type: Number,
    default: null,
  },
});

//Funciones
watch(of_colonia, () => {
  return form.oficina_colonia = of_colonia.value
})
watch(casa_colonia, () => {
  return form.casa_colonia = casa_colonia.value
})
const setOficinaColonia = (e) => {
  of_colonia.value = e.name
}

const setCasaColonia = (e) => {
  casa_colonia.value = e.name
}
const selectNac = (modelData) => {
  form.fecha = modelData;
  fec_nac.value = modelData;
}

const addCliente = () => {
  dataEdit(props.clienteId);
  //nextTick(() => passwordInput.value.focus());
};

const dataEdit = (id) => {
  axios.get(route(ruta + '.show', id))
    .then(res => {
      isShowModal.value = true;
      var datos = res.data.data
      form.id = datos.id
      form.comentario = datos.comentario
      form.telefono = datos.telefono
      form.casa_direccion = datos.casa_direccion
      form.casa_colonia = datos.casa_colonia
      form.fecha = datos.fecha
      form.hora = datos.hora
      fec_nac.value = datos.fecha
    })
};

const closeModal = () => {
  isShowModal.value = false;
  form.reset();
};

//envio de formulario
const submit = () => {
  form.clearErrors()
  form.post(route(ruta + '.updatepedido', form.id), {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: () => {
      isShowModal.value = false
      ok('Editado')
      //form.reset()
      router.get(route(ruta + '.index'));
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
    <button type="button" class="rounded bg-blue-500 px-1 py-1 text-xs font-normal text-white mr-1 mb-1 hover:bg-blue-600"
      @click="addCliente">Editar</button>

    <Modal :show="isShowModal" @close="closeModal" maxWidth="md">
      <div class="p-2">

        <div class="p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600">
          <h2 class="text-lg font-medium text-gray-900">
            Editar
          </h2>

        </div>
        <form @submit.prevent="submit">
          <div class="px-2 grid grid-cols-6 gap-4 md:gap-3 2xl:gap-6 mb-2">

            <div class="col-span-4 shadow-default xl:col-span-2">
              <InputLabel for="telefono" value="Télefono" class="block text-base font-medium leading-6 text-gray-900" />
              <TextInput id="telefono" type="text" v-model="form.telefono" placeholder="Ingrese telefono"
                class="block w-full text-gray-900 border border-gray-300 rounded bg-gray-50 sm:text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
              <InputError class="mt-1 text-xs" :message="form.errors.telefono" />
            </div>

            <div class="col-span-4 shadow-default xl:col-span-2 z-50">
              <InputLabel for="fecha" value="Fecha" class="block text-base font-medium leading-6 text-gray-900" />
              <date-picker v-model:value="fec_nac" value-type="YYYY-MM-DD" format="DD/MM/YYYY" type="date"
                @change="selectNac" lang="es" placeholder="Seleccione fecha"></date-picker>
              <InputError class="mt-1 text-xs" :message="form.errors.fecha" />
            </div>

            <div class="col-span-4 shadow-default xl:col-span-2 z-50">
              <InputLabel for="hora" value="Hora" class="block text-base font-medium leading-6 text-gray-900" />
              <TextInput id="hora" type="time" v-model="form.hora" />
              <InputError class="mt-1 text-xs" :message="form.errors.hora" />
            </div>

            <div class="col-span-6 shadow-default xl:col-span-6 z-50 mb-5">
              <InputLabel for="comentario" value="Comentario"
                class="block text-base font-medium leading-6 text-gray-900" />
              <textarea id="comentario" placeholder="Comentario" v-model="form.comentario"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-md rounded p-1 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white  dark:focus:border-primary-500"
                rows="2" cols="50"></textarea>
              <InputError class="mt-1 text-xs" :message="form.errors.comentario" />
            </div>
            <!--

    <div class="col-span-6 shadow-default xl:col-span-3">
        <InputLabel for="casa_direccion" value="Casa dirección"
        class="block text-base font-medium leading-6 text-gray-900" />
        <TextInput id="casa_direccion" type="text" v-model="form.casa_direccion"
        autocomplete="casa_direccion" placeholder="Ingrese casa direccion" />
        <InputError class="mt-1 text-xs" :message="form.errors.casa_direccion" />
    </div>
    <div class="col-span-6 shadow-default xl:col-span-3">
        <InputLabel for="casa_colonia" value="Casa colonia"
                                class="block text-base font-medium leading-6 text-gray-900" />
                            <GMapAutocomplete
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-md rounded  focus:ring-primary-500 focus:border-primary-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Ingrese casa colonia" @place_changed="setCasaColonia"
                                :value="form.casa_colonia" :options="{
                                    types: ['geocode'],
                                    componentRestrictions: { country: 'MX' }
                                }">
                            </GMapAutocomplete>
                            <InputError class="mt-1 text-xs" :message="form.errors.casa_colonia" />
                        </div>

                    -->

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
