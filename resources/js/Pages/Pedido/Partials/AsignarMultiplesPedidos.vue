<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, defineProps } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';
import Multiselect from '@vueform/multiselect';

//Variables
const props = defineProps({
  selectedOrders: Array,
});

const isShowModal = ref(false);
const { user } = usePage().props.auth;
const form = useForm({
  ruta_id: '0',
  repartidor_id: '',
  responsable_id: '',
  selected_orders: '',
  rutasseleccionadas: ref([]),
  cantidad_rutas:'',
  cantidad_disponible:''
})

const titulo = "Colonia"
const ruta = "pedidos";

const rutas = ref({
  value: '',
});

const repartidores = ref({
  value: '',
});

const selectedRows = ref([]);

const toggleRowSelection = (id) => {
  if (!selectedRows.value.includes(id)) 
  {
    selectedRows.value = [...selectedRows.value, id];
  }
  /*
  if (selectedRows.value.includes(id)) {
    selectedRows.value = selectedRows.value.filter((rowId) => rowId !== id);
  } else {
    selectedRows.value = [...selectedRows.value, id];
  }*/
 // form.rutasseleccionadas.value = 'nada';
};



const repartidorRowSelection = (id) => {  
  form.cantidad_rutas = id; 
};


//Funciones
const showModal = ( id) => {
  axios.get(route(ruta + '.asignar', id))
    .then(res => {     
      isShowModal.value = true;
      var datos = res.data;
      rutas.value = datos.rutas;     
      repartidores.value = datos.repartidores;
      form.responsable_id = user.id;     
    });
};

const closeModal = () => {
  isShowModal.value = false;
  form.reset();
};

//envio de formulario
const submit = () => {
  form.cantidad_disponible = 3-form.cantidad_rutas ;
   let asignar = form.rutasseleccionadas.length + form.cantidad_rutas ;
   let mensaje = "";
  
   console.log(asignar);
   console.log(form.cantidad_rutas);

   if (asignar == 0 && form.cantidad_rutas >0)  
   { 
    mensaje = "Esta repartidor ya tiene " + form.cantidad_rutas + " rutas asignadas, no puede asignar mas.";
  }else
  {
    if (form.cantidad_rutas == 0 && asignar>3 )  mensaje = "No puede asignar mas de 3 rutas a este repartidor.";
    else  mensaje = "Esta repartidor ya tiene " + form.cantidad_rutas + " rutas asignadas, no puede asignar mas de "+ form.cantidad_disponible +" rutas .";
  }  
  

   if (asignar <=3 ) { 
    form.selected_orders = props.selectedOrders
    form.clearErrors()
    form.post(route(ruta + '.update-multiple'), {
      preserveScroll: true,
      forceFormData: true,
      onSuccess: () => {
        isShowModal.value = false
        ok(titulo + ' Asignada')
        router.get(route(ruta + '.index'));
        form.reset()
      },
      onFinish: () => {
      },
      onError: () => {
      }
    });
  } 
   else {
    Swal.fire({
      icon: 'warning',
      title:mensaje,
      width: 350,
    })
  } 
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
  <div>
    <button type="button"
      class="m-1 p-2 text-sm font-medium rounded text-center text-white bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-700"
      @click="showModal">Asignar {{ titulo }}</button>

    <Modal :show="isShowModal" @close="closeModal" maxWidth="md">
      <div class="p-2">

        <div class="p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600">
          <h2 class="text-lg font-medium text-gray-900">
            Asignar {{ titulo }}
          </h2>
        </div>

        <form @submit.prevent="submit">
          <div class="px-2 grid grid-cols-6 gap-4 md:gap-3 2xl:gap-6 mb-2">
            <div class="col-span-6 shadow-default xl:col-span-6">
             <!--  <p>{{form.rutasseleccionadas}}</p> -->
              <InputLabel value="Colonias" class="block text-base font-medium leading-6 text-gray-900" />
              <div class="grid grid-cols-3 gap-4">
                <div v-for="(ruta, index) in rutas" :key="index" class="flex items-center space-x-2">
                  <input type="checkbox"  :id="'ruta_' + ruta.value"                   
                  v-model="form.rutasseleccionadas"            
                  @change="toggleRowSelection(ruta.label)"
                  :value="ruta.label"/>
                  <label :for="'ruta_' + ruta.label">{{ ruta.label }}</label>

                <!--   <input type="radio" :id="'ruta_' + ruta.value" v-model="form.ruta_id" :value="ruta.value" />
                  <label :for="'ruta_' + ruta.value">{{ ruta.label }}</label> -->
                </div>
              </div>
              <InputError class="mt-1 text-xs" :message="form.errors.ruta_id" />
            </div>
            <div class="col-span-6 shadow-default xl:col-span-6">
              <hr class="p-2">
              <InputLabel value="Repartidor" class="block text-base font-medium leading-6 text-gray-900" />
              <div class="grid grid-cols-3 gap-4">
                <div v-for="(repartidor, index) in repartidores" :key="index" class="flex items-center space-x-2">
                  <input type="radio" :id="'repartidor_' + repartidor.value" v-model="form.repartidor_id"
                    :value="repartidor.value" 
                    @change="repartidorRowSelection(repartidor.cantidad_rutas)"/>
                  <label :for="'repartidor_' + repartidor.value">{{ repartidor.label }}</label>               

                </div>
              </div>
              <InputError class="mt-1 text-xs" :message="form.errors.repartidor_id" />
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
  </div>
</template>
