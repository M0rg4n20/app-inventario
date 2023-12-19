
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted,  computed } from 'vue'
import { Head, usePage, useForm, router } from '@inertiajs/vue3';
import { Modal, Breadcrumb, BreadcrumbItem } from 'flowbite-vue'
import Swal from 'sweetalert2';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Multiselect from '@vueform/multiselect';

import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import language from 'datatables.net-plugins/i18n/es-ES.mjs';
DataTable.use(DataTablesCore);

const previewImage = ref('/images/usuarios/user.png');
const isShowModal = ref(false)
const titulo = ref('')
const operation = ref(null)
const {permissions} =usePage().props.auth

const datosTabla = computed(() => {
    return usePage().props.usuarios.data;
})




const formDelete = useForm({
    id: '',
});

const perfiles = ref({
    value: '',
    closeOnSelect: true,
    placeholder: "Seleccione",
    searchable: true,
    options: [],
});

onMounted(() => {
    perfiles.value.options = usePage().props.lista_roles
});

//datos usuario
const form = useForm({
    id: '',
    name: '',
    username: '',
    photo: '',
    password: '',
    perfil: '',

})

//envio de formulario
const submit = () => {

    //form.reset()
    form.clearErrors()
    if (operation.value == 1) {
        form.post(route('usuarios.store'), {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                isShowModal.value = false
                ok('Usuario Creado')
                router.get(route('usuarios.index'));
            },
            onFinish: () => {

                //form.reset()
            },
            onError: () => {

            }
        });
    } else {
        form.post(route('usuarios.update', form.id), {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                isShowModal.value = false
                ok('Usuario actualizado')
                router.get(route('usuarios.index'));
            },
            onError: () => {

            },
        });
    }


};
//modal Crear Editar

function closeModal() {
    isShowModal.value = false
}
function showModal(op, id, name, username, photo, id_rol) {
    //form.reset();
    //form.clearErrors()

    isShowModal.value = true
    operation.value = op;
    //form.id = ''
    form.perfil = id_rol;
    form.name = ''
    form.username = ''
    form.password = ''
    form.photo = ''
    previewImage.value = '/images/usuarios/user.png'

    if (operation.value == '1') {
        titulo.value = "Agregar"
        form.perfil = '';

    } else {
        previewImage.value = photo
        titulo.value = "Editar"
        form.id = id
        form.name = name
        form.username = username
    }

}

const pickFile = (e) => {
    e.preventDefault();

    form.photo = e.target.files[0]

    let file = e.target.files
    if (file && file[0]) {
        let reader = new FileReader
        reader.onload = e => {
            previewImage.value = e.target.result
        }
        reader.readAsDataURL(file[0])

    }
}
//modal eliminar
const eliminar = (id, name) => {

    const alerta = Swal.mixin({ buttonsStyling: true });
    alerta.fire({
        width: 350,
        title: "Seguro de eliminar " + name,
        text: 'Se eliminará definitivamente',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        cancelButtonColor: 'red',
        confirmButtonColor: '#2563EB',

    }).then((result) => {
        if (result.isConfirmed) {
            formDelete.delete(route('usuarios.destroy', id),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        ok('Eliminado')
                        router.get(route('usuarios.index'));
                     }
                });
        }
    });
}

const ok = (mensaje) => {
    form.reset();

    Swal.fire({
        width: 350,
        title: mensaje,
        icon: 'success'
    })
}


//actualizar estado
const updateStatus = (id, status) => {
    router.get('/usuario/status/' + id + '/' + status, { preserveState: true });
}

//funciones personalizadas
//eliminar espacios
const deleteSpaces = (e) => {
    e.target.value = e.target.value.replace(/[^a-z0-9]/gi, '');
    e.target.value = ("" + e.target.value).replace(/\s+/g, '')
};
</script>
<template>
    <div>

        <Head title="Usuarios" />
        <AuthenticatedLayout>

            <div class="ml-4 col-span-full">

                <Breadcrumb>
                    <BreadcrumbItem href="/" home>
                        Inicio
                    </BreadcrumbItem>
                    <BreadcrumbItem>
                        Usuarios
                    </BreadcrumbItem>
                </Breadcrumb>
            </div>
            <div class=" px-5 col-span-full flex justify-between items-center">

                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Usuarios</h1>
                <button type="button" @click="showModal(1)" v-if="permissions.includes('crear-usuarios')" class="m-1 p-2 text-sm font-medium rounded text-center text-white bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-700">
                    Agregar Usuario
                </button>
            </div>
            <div
                class="p-4 mb-4 bg-white col-span-12 border border-gray-200 rounded-lg shadow-sm 2xl:col-span-12 dark:border-gray-700 sm:p-4 dark:bg-gray-800">
                <div class="overflow-x-auto">

                    <div class="lg:inline-block min-w-full  mt-4">

                        <DataTable :options="{ language }"
                            class="pt-3 w-full text-sm text-center text-gray-600 dark:text-gray-400">
                            <thead
                                class="text-md text-center text-gray-700 bg-gray-200/80 dark:bg-gray-700 dark:text-gray-400">

                                <tr>
                                    <th scope="col" class="p-1 border border-gray-300 dark:border-gray-500">
                                        ID
                                    </th>
                                    <th scope="col" class="p-1 border border-gray-300 dark:border-gray-500">
                                        Nombre
                                    </th>
                                    <th scope="col" class="p-1 border border-gray-300 dark:border-gray-500">
                                        <div class="flex justify-center">
                                            Usuario
                                        </div>
                                    </th>
                                    <th scope="col" class="p-1 border border-gray-300 dark:border-gray-500">
                                        <div class="flex justify-center">
                                            Foto
                                        </div>
                                    </th>
                                    <th scope="col" class="p-1 border border-gray-300 dark:border-gray-500">
                                        <div class="flex justify-center">
                                            Perfil
                                        </div>
                                    </th>
                                    <th scope="col" class="p-1 border border-gray-300 dark:border-gray-500">
                                        <div class="flex justify-center">
                                            Estado
                                        </div>
                                    </th>
                                    <th scope="col" class="p-1 border border-gray-300 dark:border-gray-500">
                                        <div class="flex justify-center">
                                            Último login
                                        </div>
                                    </th>
                                    <th scope="col" class="p-1 border border-gray-300 dark:border-gray-500">
                                        <div class="flex justify-center">
                                            Acciones
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr :key="id"
                                    v-for="{ id, name, username, photo, roles, status, last_login_at, id_rol }, index in datosTabla"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                                        {{ id }}
                                    </th>
                                    <th scope="row"
                                        class="p-1 border dark:bg-gray-800 dark:border-gray-700 font-medium text-gray-900 dark:text-white">
                                        {{ name }}
                                    </th>
                                    <td scope="row" class="p-1 border dark:border-gray-700">
                                        {{ username }}
                                    </td>
                                    <td scope="row" class="p-1 border dark:border-gray-700">
                                        <img class="rounded-full shadow-2xl border-4 w-10 h-10 object-contain" :src="photo"
                                            alt="image description">
                                    </td>
                                    <td scope="row" class="p-1 border dark:border-gray-700">
                                        {{ roles }}
                                    </td>
                                    <td scope="row" class="p-1 border dark:border-gray-700">
                                        <button type="button" v-if="status == 1" @click.prevent="updateStatus(id, 0)"
                                            class="p-1 text-xs font-medium rounded text-center text-white bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-700">Activado</button>
                                        <button type="button" v-if="status == 0" @click.prevent="updateStatus(id, 1)"
                                            class="p-1 text-xs font-medium rounded text-center text-white bg-red-500 hover:bg-red-600 dark:bg-red-500 dark:hover:bg-red-700">Desactivado</button>
                                    </td>
                                    <td scope="row" class="p-1 border dark:border-gray-700">
                                        {{ last_login_at }}
                                    </td>
                                    <td class="px-4 py-2 text-right border  dark:border-gray-700">
                                        <span
                                        v-if="permissions.includes('editar-usuarios')"
                                            class="inline-block rounded bg-blue-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-blue-700">
                                            <button @click.prevent=" showModal(2, id, name, username, photo, id_rol)"><i
                                                    class="fas fa-edit"></i></button>
                                        </span>
                                        <span
                                        v-if="permissions.includes('eliminar-usuarios')"
                                            class="inline-block rounded bg-red-600 px-2 py-1 text-base font-semibold text-white mr-1 mb-1 hover:bg-red-700">
                                            <button @click.prevent="eliminar(id, name)"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </span>
                                    </td>
                                </tr>

                            </tbody>
                        </DataTable>
                    </div>



                </div>
            </div>

        </AuthenticatedLayout>
        <Transition>

            <div class="z-40">

                <Modal size="xl" v-if="isShowModal" @close="closeModal">
                    <template #header>
                        <div class="flex items-center m-0 text-lg font-bold text-gray-900 dark:text-gray-400">
                            {{ titulo }}
                        </div>
                    </template>
                    <template #body>
                        <form @submit.prevent="submit">
                            <div class="px-2 grid grid-cols-6 gap-4 md:gap-2 2xl:gap-6">

                                <div class="col-span-6 shadow-default xl:col-span-3">
                                    <InputLabel for="name" value="Nombre"
                                        class="block text-base font-medium leading-6 text-gray-900" />
                                    <TextInput id="name" type="text" v-model="form.name" autocomplete="name"
                                        placeholder="Ingrese Nombre" />
                                    <InputError class="mt-1 text-xs" :message="form.errors.name" />
                                </div>

                                <div class="col-span-6 shadow-default xl:col-span-3">
                                    <InputLabel for="username" value="Usuario"
                                        class="block text-base font-medium leading-6 text-gray-900" />
                                    <TextInput id="username" type="text" @keyup="deleteSpaces" v-model="form.username"
                                        autocomplete="username" placeholder="Ingrese usuario" />
                                    <InputError class="mt-1 text-xs" :message="form.errors.username" />
                                </div>


                                <div class="col-span-6 shadow-default xl:col-span-3">
                                    <InputLabel for="password" value="Contraseña"
                                        class="block text-base font-medium leading-6 text-gray-900" />
                                    <TextInput id="password" type="password" v-model="form.password"
                                        placeholder="Ingrese Contraseña"
                                        class="block w-full text-gray-900 border border-gray-300 rounded bg-gray-50 sm:text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                    <InputError class="mt-1 text-xs" :message="form.errors.password" />
                                </div>



                                <div class="col-span-6 shadow-default xl:col-span-3">
                                    <InputLabel for="perfil" value="Perfil"
                                        class="block text-base font-medium leading-6 text-gray-900" />
                                    <Multiselect id="perfil" v-model="form.perfil" v-bind="perfiles">
                                    </Multiselect>
                                    <InputError class="mt-1 text-xs" :message="form.errors.perfil" />
                                </div>

                                <div class="col-span-6 xl:col-span-6">
                                    <InputLabel for="foto" value="Subir Foto"
                                        class="block  mb-0 text-base font-medium leading-6 text-gray-900" />
                                    <input @input="pickFile"
                                        class="block w-full text-xs text-gray-900 border border-gray-300 rounded cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        aria-describedby="file_input_help" id="file_input" type="file">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-300" id="file_input_help">Peso
                                        máximo de la
                                        foto 2MB</p>
                                    <InputError class="mt-1 text-xs" :message="form.errors.photo" />

                                    <div class="imagePreviewWrapper"
                                        :style="{ 'background-image': `url(${previewImage})` }"></div>

                                </div>

                            </div>
                            <div class="flex justify-between pt-0">
                                <button @click="closeModal" type="button"
                                    class="inline-block rounded bg-red-600 p-2 text-sm font-semibold text-white mr-1 mb-1 hover:bg-red-700">
                                    Cancelar
                                </button>
                                <PrimaryButton
                                    class="inline-block rounded bg-blue-600 p-2 text-sm font-semibold text-white mr-1 mb-1 hover:bg-blue-700"
                                    :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                                    Guardar
                                </PrimaryButton>
                            </div>
                        </form>
                    </template>

                </Modal>
            </div>
        </Transition>
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
