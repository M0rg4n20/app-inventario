<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import Multiselect from '@vueform/multiselect';

import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, watch, onMounted } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';
const type_img = ref([{ name: 'local' }, { name: 'url' }]);

//Variables
const isShowModal = ref(false);
const previewImage = ref('/images/productos/temp_producto.png');
const previewImage2 = ref('/images/productos/temp_producto.png');

const pickFile = (e) => {
  e.preventDefault();

  form.photo_1 = e.target.files[0]

  let file = e.target.files
  if (file && file[0]) {
    let reader = new FileReader
    reader.onload = e => {
      previewImage.value = e.target.result
    }
    reader.readAsDataURL(file[0])

  }
}
const pickFile2 = (e) => {
  e.preventDefault();

  form.photo_2 = e.target.files[0]

  let file = e.target.files
  if (file && file[0]) {
    let reader = new FileReader
    reader.onload = e => {
      previewImage2.value = e.target.result
    }
    reader.readAsDataURL(file[0])

  }
}

const setCodigo = (e) => {
  form.codigo = form.familia_id +
    form.subproducto_id +
    form.marca_id +
    form.peso_id +
    form.longitud_id +
    form.curva_id +
    form.color_id + form.diferenciador_id;

  const familia = form.familia_id ? obtenerNombreDeOpcion(familias.value.options, form.familia_id) : '';
  const subproducto = form.subproducto_id ? obtenerNombreDeOpcion(subproductos.value.options, form.subproducto_id) : '';
  const marca = form.marca_id ? obtenerNombreDeOpcion(marcas.value.options, form.marca_id) : '';
  const peso = form.peso_id ? obtenerNombreDeOpcion(pesos.value.options, form.peso_id) : '';
  const longitud = form.longitud_id ? obtenerNombreDeOpcion(longitudes.value.options, form.longitud_id) : '';
  const curva = form.curva_id ? obtenerNombreDeOpcion(curvas.value.options, form.curva_id) : '';
  const color = form.color_id ? obtenerNombreDeOpcion(colores.value.options, form.color_id) : '';
  const diferenciador = form.diferenciador_id ? obtenerNombreDeOpcion(diferenciadores.value.options, form.diferenciador_id) : '';

  const nuevoNombre = [subproducto, marca, peso, longitud, curva, color, diferenciador].filter(item => item).join(' ');
  form.nombre = nuevoNombre;
}

const obtenerNombreDeOpcion = (opciones, valor) => {
  const opcion = opciones.find(option => option.value === valor);
  if (opcion) {
    const partes = opcion.label.split('|');
    if (partes.length > 1) {
      return partes[1].trim();
    }
    return opcion.label.trim();
  }
  return '';
}

const setUrlImg1 = (e) => {

  previewImage.value = form.image_url_1;
}
const setUrlImg2 = (e) => {

  previewImage2.value = form.image_url_2;
}
const setPrecioVenta = (e) => {

  if (form.precio_compra > 0) {
    form.precio_venta = parseFloat(form.precio_compra) + parseFloat((form.precio_compra * form.porcentaje_venta) / 100);
  }

}
const setPrecioMayorista = (e) => {

  if (form.precio_compra > 0) {
    form.precio_mayorista = parseFloat(form.precio_compra) + parseFloat((form.precio_compra * form.porcentaje_mayorista) / 100);
  }

}

onMounted(() => {
  categorias.value.options = usePage().props.categorias
  familias.value.options = usePage().props.familias
  subproductos.value.options = usePage().props.subproductos
  marcas.value.options = usePage().props.marcas
  pesos.value.options = usePage().props.pesos
  longitudes.value.options = usePage().props.longitudes
  curvas.value.options = usePage().props.curvas
  colores.value.options = usePage().props.colores
  diferenciadores.value.options = usePage().props.diferenciadores

});



const categorias = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: true,
  options: [],
});
const familias = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: true,
  options: [],
});
const marcas = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: true,
  options: [],
});
const subproductos = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: true,
  options: [],
});
const pesos = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: true,
  options: [],
});

const curvas = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: true,
  options: [],
});
const colores = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: true,
  options: [],
});
const longitudes = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: true,
  options: [],
});
const diferenciadores = ref({
  value: '',
  closeOnSelect: true,
  placeholder: "Seleccione",
  searchable: true,
  options: [],
});




const form = useForm({
  id: '',
  nombre: '',
  categoria_id: '',
  descripcion: '',
  familia_id: '',
  subproducto_id: '',
  marca_id: '',
  peso_id: '',
  longitud_id: '',
  curva_id: '',
  color_id: '',
  diferenciador_id: '',
  codigo: '',
  codigo_barra: null,
  precio_compra: '',
  stock: '',
  precio_venta: '',
  precio_mayorista: '',
  porcentaje_mayorista: '',
  porcentaje_venta: '',
  check_mayorista: '',
  check_venta: '',
  imagen_1: '',
  imagen_2: '',
  photo_1: previewImage.value,
  photo_2: previewImage2.value,
  tipo_img_1: 'local',
  tipo_img_2: 'local',
  image_url_1: '',
  image_url_2: ''

})

const props = defineProps({
  clienteId: {
    type: Number,

  },


});


//Funciones

const addCliente = () => {
  dataEdit(props.clienteId);
  //nextTick(() => passwordInput.value.focus());
};

const dataEdit = (id) => {
  axios.get(route('productos.show', id))
    .then(res => {
      isShowModal.value = true;
      var datos = res.data.data

      form.id = datos.id
      form.nombre = datos.nombre
      form.categoria_id = datos.categoria_id
      form.descripcion = datos.descripcion
      form.familia_id = datos.familia_id
      form.subproducto_id = datos.subproducto_id
      form.marca_id = datos.marca_id
      form.peso_id = datos.peso_id
      form.curva_id = datos.curva_id
      form.color_id = datos.color_id
      form.longitud_id = datos.longitud_id
      form.diferenciador_id = datos.diferenciador_id
      form.codigo = datos.codigo
      form.codigo_barra = datos.codigo_barra
      form.stock = datos.stock

      form.precio_venta = datos.precio_venta
      form.precio_compra = datos.precio_compra
      form.precio_mayorista = datos.precio_mayorista
      form.check_venta = datos.check_venta
      form.check_mayorista = datos.check_mayorista
      form.porcentaje_mayorista = datos.porcentaje_mayorista
      form.porcentaje_venta = datos.porcentaje_venta
      previewImage.value = usePage().props.base_url + datos.imagen_1
      previewImage2.value = usePage().props.base_url + datos.imagen_2
      form.imagen_1 = datos.imagen_1


    })

};


const closeModal = () => {
  isShowModal.value = false;
  form.reset();
};


//envio de formulario
const submit = () => {
  form.clearErrors()
  form.post(route('productos.update', form.id), {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: () => {
      isShowModal.value = false
      ok('Producto Editado')
      form.reset()
      router.get(route('productos.index'));
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

    <Modal :show="isShowModal" @close="closeModal">
      <div class="p-2">

        <div class="p-4 mb-4 rounded-t flex justify-between items-center border-b border-gray-200 dark:border-gray-600">
          <h2 class="text-lg font-medium text-gray-900">
            Editar Cliente
          </h2>

        </div>
        <form @submit.prevent="submit">
          <div class="px-2 grid grid-cols-12  gap-3 xl:gap-3 mt-2 mb-2">

            <div class="col-span-12 md:col-span-12 xl:col-span-12">
              <InputLabel for="nombre" value="Nombre" class="block text-base font-medium leading-6 text-gray-900" />
              <TextInput id="nombre" type="text" v-model="form.nombre" autocomplete="nombre"
                placeholder="Ingrese nombre" readonly/>
              <InputError class="mt-1 text-xs" :message="form.errors.nombre" />
            </div>
            <div class="col-span-12 md:col-span-6 xl:col-span-6 hidden">
              <InputLabel for="categoria_id" value="Categoria"
                class="block text-base font-medium leading-6 text-gray-900" />
              <Multiselect id="categoria_id" disabled v-model="form.categoria_id" v-bind="categorias">
              </Multiselect>
              <InputError class="mt-1 text-xs" :message="form.errors.categoria_id" />
            </div>

            <div class="col-span-12">
              <InputLabel for="descripcion" value="Descripción"
                class="block text-base font-medium leading-6 text-gray-900" />
              <TextInput id="descripcion" type="text" v-model="form.descripcion" autocomplete="descripcion"
                placeholder="Ingrese descripcion" />
              <InputError class="mt-1 text-xs" :message="form.errors.descripcion" />
            </div>



            <div class="col-span-12  xl:col-span-6">
              <InputLabel for="familia_id" value="Familia" class="block text-base font-medium leading-6 text-gray-900" />
              <Multiselect id="familia_id" v-model="form.familia_id" v-bind="familias" disabled @select="setCodigo">
              </Multiselect>
              <InputError class="mt-1 text-xs" :message="form.errors.familia_id" />
            </div>

            <div class="col-span-12  xl:col-span-6">
              <InputLabel for="subproducto_id" value="Sub producto"
                class="block text-base font-medium leading-6 text-gray-900" />
              <Multiselect id="subproducto_id" v-model="form.subproducto_id" disabled v-bind="subproductos"
                @select="setCodigo">
              </Multiselect>
              <InputError class="mt-1 text-xs" :message="form.errors.subproducto_id" />
            </div>
            <div class="col-span-12  xl:col-span-6">
              <InputLabel for="marca_id" value="Marca" class="block text-base font-medium leading-6 text-gray-900" />
              <Multiselect id="marca_id" v-model="form.marca_id" v-bind="marcas" disabled @select="setCodigo">
              </Multiselect>
              <InputError class="mt-1 text-xs" :message="form.errors.marca_id" />
            </div>
            <div class="col-span-12  xl:col-span-6">
              <InputLabel for="peso_id" value="Peso" class="block text-base font-medium leading-6 text-gray-900" />
              <Multiselect id="peso_id" v-model="form.peso_id" v-bind="pesos" disabled @select="setCodigo">
              </Multiselect>
              <InputError class="mt-1 text-xs" :message="form.errors.peso_id" />
            </div>
            <div class="col-span-12  xl:col-span-6">
              <InputLabel for="longitud_id" value="Longitud"
                class="block text-base font-medium leading-6 text-gray-900" />
              <Multiselect id="longitud_id" v-model="form.longitud_id" disabled v-bind="longitudes" @select="setCodigo">
              </Multiselect>
              <InputError class="mt-1 text-xs" :message="form.errors.longitud_id" />
            </div>
            <div class="col-span-12  xl:col-span-6">
              <InputLabel for="curva_id" value="Curva" class="block text-base font-medium leading-6 text-gray-900" />
              <Multiselect id="curva_id" v-model="form.curva_id" v-bind="curvas" disabled @select="setCodigo">
              </Multiselect>
              <InputError class="mt-1 text-xs" :message="form.errors.curva_id" />
            </div>
            <div class="col-span-12  xl:col-span-6">
              <InputLabel for="color_id" value="Color" class="block text-base font-medium leading-6 text-gray-900" />
              <Multiselect id="color_id" v-model="form.color_id" v-bind="colores" disabled @select="setCodigo">
              </Multiselect>
              <InputError class="mt-1 text-xs" :message="form.errors.color_id" />
            </div>

            <div class="col-span-12  xl:col-span-6">
              <InputLabel for="diferenciador_id" value="Diferenciador"
                class="block text-base font-medium leading-6 text-gray-900" />
              <Multiselect id="diferenciador_id" v-model="form.diferenciador_id" disabled class="dark:bg-gray-900"
                v-bind="diferenciadores" @select="setCodigo">
              </Multiselect>
              <InputError class="mt-1 text-xs" :message="form.errors.diferenciador_id" />
            </div>


            <div class="col-span-12  xl:col-span-6">
              <InputLabel for="codigo" value="Código" readonly
                class="block text-base font-medium leading-6 text-gray-900" />
              <TextInput id="codigo" type="text" v-model="form.codigo" readonly />
              <InputError class="mt-1 text-xs" :message="form.errors.codigo" />
            </div>

            <div class="col-span-12  xl:col-span-6">
              <InputLabel for="codigo_barra" value="Código barra" readonly
                class="block text-base font-medium leading-6 text-gray-900" />
              <TextInput id="codigo_barra" type="text" v-model="form.codigo_barra" autocomplete="codigo_barra"
                placeholder="Ingrese Código barra" />
              <InputError class="mt-1 text-xs" :message="form.errors.codigo_barra" />
            </div>

            <div class="col-span-6  xl:col-span-3">
              <InputLabel for="stock" value="Stock" class="block text-base font-medium leading-6 text-gray-900" />
              <TextInput id="stock" type="number" disabled v-model="form.stock" />
              <InputError class="mt-1 text-xs" :message="form.errors.stock" />
            </div>
            <div class="col-span-6  xl:col-span-3">
              <InputLabel for="precio_compra" value="Precio de compra"
                class="block text-base font-medium leading-6 text-gray-900" />
              <TextInput id="precio_compra" type="number" step="any" v-model="form.precio_compra" />
              <InputError class="mt-1 text-xs" :message="form.errors.precio_compra" />
            </div>
            <div class="col-span-6  xl:col-span-3">
              <InputLabel for="precio_venta" value="Precio de venta"
                class="block text-base font-medium leading-6 text-gray-900" />
              <TextInput id="precio_venta" type="number" step="any" v-model="form.precio_venta" />
              <InputError class="mt-1 text-xs" :message="form.errors.precio_venta" />
              <div class="flex flex-col ">
                <div class="flex w-full my-2 items-center">
                  <input id="check_venta" name="check_venta" v-model="form.check_venta" type="checkbox"
                    class="h-5 w-5 rounded border-gray-300 text-indigo-600 shadow-sm " />
                  <label for="check_venta" class="text-xs font-normal pl-2 dark:text-white text-gray-900">Utilizar
                    porcentaje venta</label>
                </div>
                <div class="flex  w-50" v-if="form.check_venta">
                  <TextInput id="precio_mayorista" v-model="form.porcentaje_venta" class="text-end" type="number"
                    @keyup="setPrecioVenta" />
                  <div
                    class="w-8 flex items-center justify-center  bg-gray-50 border border-gray-300 text-gray-900 text-md font-bold  p-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    %</div>
                </div>
                <InputError class="mt-1 text-xs" :message="form.errors.porcentaje_venta" />
              </div>
            </div>
            <div class="col-span-6  xl:col-span-3">
              <InputLabel for="precio_mayorista" value="Precio de Mayorista"
                class="block text-base font-medium leading-6 text-gray-900" />
              <TextInput id="precio_mayorista" type="number" step="any" v-model="form.precio_mayorista" />
              <InputError class="mt-1 text-xs" :message="form.errors.precio_mayorista" />
              <div class="flex flex-col ">
                <div class="flex w-full my-2 items-center">
                  <input id="check_mayorista" name="check_mayorista" v-model="form.check_mayorista" type="checkbox"
                    class="h-5 w-5 rounded border-gray-300 text-indigo-600  shadow-sm " />
                  <label for="check_mayorista" class="text-xs font-normal pl-2 text-gray-900 dark:text-white">Utilizar
                    porcentaje mayorista</label>
                </div>
                <div class="flex  w-50" v-if="form.check_mayorista">
                  <TextInput id="precio_mayorista" v-model="form.porcentaje_mayorista" class="text-end" type="number"
                    @keyup="setPrecioMayorista" />
                  <div
                    class="w-8 flex items-center justify-center  bg-gray-50 border border-gray-300 text-gray-900 dark:text-white text-md font-bold  p-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    %</div>
                </div>
                <InputError class="mt-1 text-xs" :message="form.errors.porcentaje_mayorista" />
              </div>
            </div>
            <!--Imagen 1-->
            <div class="col-span-12 xl:col-span-2">
              <div class="imagePreviewWrapper" :style="{ 'background-image': `url(${previewImage})` }"></div>
            </div>

            <div class="col-span-7 xl:col-span-7 my-2">
              <InputLabel value="Imagen 1" class="block  mb-0 text-xs font-medium leading-6 text-gray-900" />
              <div v-if="form.tipo_img_1 == 'local'">
                <input @input="pickFile"
                  class="pl-4 block w-full text-xs  font-bold text-gray-500 cursor-pointer file:mr-4 file:py-1 file:px-2 file:rounded-md  file:border-0 file:text-sm file:font-semibold     file:bg-gray-300 file:text-gray-700 hover:file:bg-gray-100"
                  aria-describedby="file_input1_help" id="file_input1" type="file">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-300" id="imagen_1">Peso
                  máximo de la
                  foto 2MB</p>
                <InputError class="mt-1 text-xs" :message="form.errors.imagen_1" />
              </div>
              <div v-if="form.tipo_img_1 == 'url'">
                <TextInput v-model="form.image_url_1" class="text-start" type="text" @keyup="setUrlImg1" />
              </div>
            </div>

            <div class="col-span-3 xl:col-span-3 flex items-center">
              <label v-for="user in type_img" :key="user.name">
                <input type="radio" class="w-4 h-4 m-2" :value="user.name" v-model="form.tipo_img_1" />
                <span class="font-bold">{{ user.name }}</span>
              </label>
            </div>

            <!--Imagen 2-->
            <div class="col-span-12 xl:col-span-2">
              <div class="imagePreviewWrapper" :style="{ 'background-image': `url(${previewImage2})` }"></div>
            </div>

            <div class="col-span-7 xl:col-span-7 my-2">
              <InputLabel value="Imagen 2" class="block  mb-0 text-xs font-medium leading-6 text-gray-900" />
              <div v-if="form.tipo_img_2 == 'local'">
                <input @input="pickFile2"
                  class="pl-4 block w-full text-xs  font-bold text-gray-500 cursor-pointer file:mr-4 file:py-1 file:px-2 file:rounded-md  file:border-0 file:text-sm file:font-semibold     file:bg-gray-300 file:text-gray-700 hover:file:bg-gray-100"
                  aria-describedby="file_input2_help" id="file_input2" type="file">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-300" id="imagen_2">Peso
                  máximo de la
                  foto 2MB</p>
                <InputError class="mt-1 text-xs" :message="form.errors.imagen_2" />
              </div>
              <div v-if="form.tipo_img_2 == 'url'">
                <TextInput v-model="form.image_url_2" @keyup="setUrlImg2" class="text-start" type="text" />
              </div>
            </div>

            <div class="col-span-3 xl:col-span-3 flex items-center">
              <label v-for="user in type_img" :key="user.name">
                <input type="radio" class="w-4 h-4 m-2" :value="user.name" v-model="form.tipo_img_2" />
                <span class="font-bold">{{ user.name }}</span>
              </label>
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
