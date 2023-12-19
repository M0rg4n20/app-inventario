<script>
import { onMounted, computed, watch } from "vue";
import NavLinkSideBar from '@/Components/NavLinkSideBar.vue';
import {usePage } from '@inertiajs/vue3';
import { useConfigStore } from '@/store/config.js'

export default {
    components: {
        NavLinkSideBar,
    },
    props: {
        isOpen: {
            type: Boolean,
            default: true,

        },

    },
    setup(props) {

        const {permissions} =usePage().props.auth
        const configStore = useConfigStore();
        const classes = computed(() => props.isOpen ? 'sm:translate-x-0' : 'sm:hidden sm:translate-x-0');
        const setMenu = (menu) => {
            configStore.showMenu(menu);
        }

        onMounted(() => {

        });

        watch(
            () => props.isOpen,
            () => {

                if (props.isOpen) {
                } else {
                }
            }
        );

        return {
            classes,
            configStore,
            setMenu,
            permissions
        }
    }
}


</script>

<template>
    <aside id="drawer-navigation"
        class="fixed top-0  left-0 z-30 w-64 h-full pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        :class="classes" aria-label="Sidenav">

        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">

            <ul class="space-y-2 font-normal">
                <li @click="setMenu('inicio')">

                    <NavLinkSideBar icon-class="fas fa-home"
                        class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('inicio')" :active="route().current('inicio')">
                        <span class="ml-3" sidebar-toggle-item>Inicio</span>

                    </NavLinkSideBar>
                </li>
                <li @click="setMenu('usuario')"
                v-show="permissions.includes('lista-usuarios')">
                    <NavLinkSideBar icon-class="fas fa-user-friends"
                        class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('usuarios.index')" :active="route().current('usuarios.index')">
                        <span class="ml-3" sidebar-toggle-item>Usuarios</span>
                    </NavLinkSideBar>
                </li>
                <li @click="setMenu('clientes')"
                v-show="permissions.includes('lista-clientes')">
                    <NavLinkSideBar icon-class="fas fa-users"
                        class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('clientes.index')" :active="route().current('clientes.index')">
                        <span class="ml-3" sidebar-toggle-item>Clientes</span>
                    </NavLinkSideBar>
                </li>
                <li @click="setMenu('producto')"
                v-show="permissions.includes('lista-productos')">
                    <NavLinkSideBar icon-class="fas fa-boxes"
                        class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('productos.index')" :active="route().current('productos.index')">
                        <span class="ml-3" sidebar-toggle-item>Productos</span>
                    </NavLinkSideBar>
                </li>
                <li @click="setMenu('kardex')" v-show="permissions.includes('listado-kerdex')">
                    <NavLinkSideBar icon-class="fas fa-file-signature"
                        class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        href="#" >
                        <span class="ml-3" sidebar-toggle-item>Kardex</span>
                    </NavLinkSideBar>
                </li>




            </ul>
            <div class="pt-2 space-y-2 font-normal" >
                <ul>

                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="ventas" data-collapse-toggle="ventas">
                            <i class="fas fa-clipboard-list"></i>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap"
                                sidebar-toggle-item>Ventas</span>
                            <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul id="ventas" class=" py-2 space-y-2"
                            :class="configStore.getCurrentMenu == 'ventas' ? '' : 'hidden'">

                            <li>
                                <NavLinkSideBar @click="setMenu('ventas')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('ventas.index')" :active="route().current('ventas.index')">
                                    <span class="ml-3" sidebar-toggle-item>Administrar</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('ventas')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('ventas.create')" :active="route().current('ventas.create')">
                                    <span class="ml-3" sidebar-toggle-item>Crear venta</span>
                                </NavLinkSideBar>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>

            <div class="pt-2 space-y-2 font-normal" >
                <ul>

                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="productos" data-collapse-toggle="productos">
                            <i class="fas fa-clipboard-list"></i>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap"
                                sidebar-toggle-item>Catálogos</span>
                            <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <ul id="productos" class=" py-2 space-y-2"
                            :class="configStore.getCurrentMenu == 'productos' ? '' : 'hidden'">

                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('categorias.index')" :active="route().current('categorias.index')">
                                    <span class="ml-3" sidebar-toggle-item>Categorias</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('familias.index')" :active="route().current('familias.index')">
                                    <span class="ml-3" sidebar-toggle-item>Familias</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('subproductos.index')" :active="route().current('subproductos.index')">
                                    <span class="ml-3" sidebar-toggle-item>Sub Producto</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('marcas.index')" :active="route().current('marcas.index')">
                                    <span class="ml-3" sidebar-toggle-item>Marcas</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('pesos.index')" :active="route().current('pesos.index')">
                                    <span class="ml-3" sidebar-toggle-item>Pesos</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('longitudes.index')" :active="route().current('longitudes.index')">
                                    <span class="ml-3" sidebar-toggle-item>Longitudes</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('curvas.index')" :active="route().current('curvas.index')">
                                    <span class="ml-3" sidebar-toggle-item>Curvas</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('colores.index')" :active="route().current('colores.index')">
                                    <span class="ml-3" sidebar-toggle-item>Colores</span>
                                </NavLinkSideBar>
                            </li>
                            <li>
                                <NavLinkSideBar @click="setMenu('productos')"
                                    class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                                    :href="route('diferenciadores.index')" :active="route().current('diferenciadores.index')">
                                    <span class="ml-3" sidebar-toggle-item>Diferenciadores</span>
                                </NavLinkSideBar>
                            </li>


                        </ul>
                    </li>
                </ul>
            </div>


            <ul class="space-y-2 font-normal">
                <li @click="setMenu('roles')"
                v-show="permissions.includes('ver-roles')">
                    <NavLinkSideBar icon-class="fas fa-user-tag"
                        class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-200 group dark:text-gray-200 dark:hover:bg-gray-700"
                        :href="route('roles.index')" :active="route().current('roles.index')">
                        <span class="ml-3" sidebar-toggle-item>Roles y Permisos</span>
                    </NavLinkSideBar>
                </li>

            </ul>


        </div>
    </aside>
</template>
