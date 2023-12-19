<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';
import Multiselect from '@vueform/multiselect';
import Swal from 'sweetalert2';
const isShowModal = ref(false);
const lista_ventas = ref([]);
const lista_metodos = ref([]);
const addCliente = () => {
  isShowModal.value = true;

};

const titulo = "Abono"
const ruta = "abonos";

const closeModal = () => {
  isShowModal.value = false;
  form.reset();
};


const form = useForm({

  monto_efectivo: '',
  metodo_pago_id: 1,
  metodo_pago: 'EFECTIVO',
  user_id: '',
  venta_id: '',
  num_tarjeta: '',
  monto_tarjeta: '',

  tipo_pago: 'ABONO',

})
//listado de ventas
const ventas = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: true,
  options: [],
});
//listado metodos de pago
const metodos = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: false,
  options: [],
});
const limpiarFormulario = () => {
  metodos.value = '';
  //form.reset('metodo_pago', 'metodo_pago_id');
  form.metodo_pago = ''
  form.metodo_pago_id = ''

}
onMounted(() => {
  ventas.value.options = usePage().props.ventas
  lista_ventas.value = usePage().props.ventas
  metodos.value.options = usePage().props.metodos_pago
  lista_metodos.value = usePage().props.metodos_pago
})
//envio de formulario
const submit = () => {

  form.clearErrors()
  form.post(route(ruta + '.store'), {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: (data) => {
      isShowModal.value = false
      if (!data.props.success) {
        Swal.fire({
          width: 350,
          title: data.props.message,
          icon: 'error'
        })
      } else if (data.props.success && data.props.message != '') {
        Swal.fire({
          width: 350,
          title: data.props.message,
          icon: 'success'
        })
      }
      router.get(route(ruta + '.index'));
    },
    onFinish: () => {

      //form.reset()
    },
    onError: () => {

    }
  });



};
const setTipoCliente = (e) => {
  form.clearErrors()
  //tipo_cliente.value = '';
  //form.reset('metodo_pago', 'productos', 'total', 'porcentaje_descuento', 'porcentaje', 'saldo', 'suma_pago');
  //var tipo = lista_clientes.value.find(prod => prod.id === e);
  //tipo_cliente.value = tipo.tipo_cliente;
}
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
      Agregar {{ titulo }}
    </button>

    <Modal :show="isShowModal" @close="closeModal" maxWidth="md">
      <div class="p-2">

        <div class="p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600">
          <h2 class="text-lg font-medium text-gray-900">
            Agregar {{ titulo }}
          </h2>

        </div>
        <form @submit.prevent="submit">
          <div class="px-2 grid grid-cols-6 gap-4 md:gap-3 2xl:gap-6 mb-2">
            <div class="grid grid-cols-12 gap-2  mt-0 col-span-12  xl:col-span-6">
              <div class="col-span-12  xl:col-span-12">
                <InputLabel for="venta_id" value="Ticket - Cliente"
                  class="block text-base font-medium leading-6 text-gray-900" />
                <Multiselect id="venta_id" v-model="form.venta_id" v-bind="ventas" @clear="limpiarFormulario"
                  @select="setTipoCliente">
                </Multiselect>
                <InputError class="mt-1 text-xs" :message="form.errors.venta_id" />
              </div>

            </div>

            <!--Metodos de pago-->
            <div class="grid grid-cols-12  mt-0 col-span-12  xl:col-span-6 text-start">
              <div class="col-span-6  xl:col-span-12">
                <InputLabel for="metodos" value="Métodos de Pago"
                  class="block text-md font-medium leading-6 text-gray-900" />
                <Multiselect v-model="form.metodo_pago_id" v-bind="metodos" @select="setMetodoPago">
                </Multiselect>
                <InputError class="mt-1 text-xs" :message="form.errors.metodo_pago_id" />
              </div>
              <!--Efectivo-->

              <div class="grid grid-cols-12 gap-2 col-span-12  xl:col-span-12 text-center">

                <div class="col-span-6 xl:col-span-4 flex pt-3 mt-4 justify-end">
                  <InputLabel value="Efectivo:" class="m-1 pb-0 text-xs font-medium leading-6 text-gray-900" />

                </div>
                <div class="col-span-12  xl:col-span-4">
                  <InputLabel for="monto" value="Monto" class="block mb-0 text-xs font-normal leading-6 text-gray-900" />

                  <div class="flex">

                    <span
                      class="inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                    <TextInput :disabled="form.metodo_pago_id == 2"
                      class="rounded  bg-gray-50 border border-gray-300 text-gray-900   min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white "
                      type="number" step="0.1" v-model="form.monto_efectivo" @input="sumaTotalPago" />
                  </div>
                  <InputError class="mt-1 text-start  w-full" :message="form.errors.monto_efectivo" />
                </div>


              </div>
              <!--/Efectivo-->
              <!--tarjetas--->
              <div v-if="form.metodo_pago_id == 2 || form.metodo_pago_id == 3"
                class="grid mt-3 grid-cols-12 gap-2 col-span-12  xl:col-span-12">

                <div class="col-span-6 xl:col-span-4 flex pt-3 mt-4 justify-start">
                  <InputLabel value="Tarjeta Debito/Credito:"
                    class="m-0 pb-0 text-xs font-medium leading-6 text-gray-900" />

                </div>
                <div class="col-span-12  xl:col-span-4">
                  <InputLabel for="monto" value="Monto" class="block text-xs font-normal leading-6 text-gray-900" />

                  <div class="flex">

                    <span
                      class="inline-flex w-6 justify-center items-center px-2 text-xs text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                    <TextInput
                      class="rounded  bg-gray-50 border border-gray-300 text-gray-900   min-w-0 w-full text-sm dark:bg-gray-700 dark:border-gray-600   dark:text-white "
                      type="number" step="0.1" v-model="form.monto_tarjeta" @input="sumaTotalPago" />
                  </div>
                  <InputError class="mt-1 text-start  w-full" :message="form.errors.monto_tarjeta" />
                </div>
                <div class="col-span-12  xl:col-span-4">
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

            </div>
            <!--/Metodos de pago-->
          </div>
          <div class="flex justify-center mt-5 w-full">
            <div id="alert-border-4"
              class="flex w-full items-center p-2 mb-4 text-yellow-800 border-t-4 border-yellow-300 bg-yellow-50 dark:text-yellow-300 dark:bg-gray-800 dark:border-yellow-800"
              role="alert">
              <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                  d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
              </svg>
              <div class="ml-3 text-xs text-center font-medium">
                Antes de guardar verifique el ticket.
              </div>

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
